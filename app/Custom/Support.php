<?php


namespace App\Custom;


use Illuminate\Support\Str;

class Support
{
    public static function  uploadImage($image, $directory = "upload/thumbnail/"){
        $image_name = Str::random(10);
        $ext = strtolower($image->getClientOriginalExtension());
        $image_full_name = $image_name . '.' . $ext;
        $upload_path = $directory;
        $image_url = $upload_path . $image_full_name;
        $image->move($upload_path, $image_full_name);
        return $image_url;
    }

    public static function deleteFile($file){
        if (file_exists($file)){
            chmod($file, 0644);
            @unlink($file);
        }
    }
}
