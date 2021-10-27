<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|max:50',
            'email' => 'required|max:100|unique:users',
            'password' => 'required|min:5',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            return response()->json([
                'errors' => $validation->getMessageBag(),
            ], 402);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 1,
        ]);

        if (!$user){
            return response()->json(["message" => "Unable to register user. Please try again"], 502);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json(["message" => "Unable to login. Please try again"], 401);
        }else{
            return response()->json([
                'token' => auth()->user()->createToken('API Token')->plainTextToken,
                'user' => auth()->user()
            ]);
        }
    }

    public function login(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            return response()->json([
                'errors' => $validation->getMessageBag(),
            ], 402);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json(["message" => "Incorrect email or password"], 401);
        }else{
            return response()->json([
                'token' => auth()->user()->createToken('API Token')->plainTextToken,
                'user' => auth()->user()
            ]);
        }

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
