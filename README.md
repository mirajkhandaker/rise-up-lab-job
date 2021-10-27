## About Project
This a simple Backend Service (REST APIs) for job portal.

## Requirements
- Ensure in your environment PHP version is 7.3+
- Make sure you have composer install in your environment.
  if you don't have composer in your environment then read the [Composer Documentation and install it](https://getcomposer.org/doc/00-intro.md).

## Installation Guidelines 
1. Get the project by below command or Download the zip file and export it.
```
git clone https://github.com/mirajkhandaker/rise-up-labs-job.git
```
2. Open the project directory and install the dependency by below command.

```
composer install
```
3. Generate the env file by below command
```
cp .env.example .env
```
4. Generate **APP_KEY** by below command
```
php artisan key:generate
```
5. Add Database name and credential in **.env** file
   - DB_DATABASE=Database Name.
   - DB_USERNAME=Database User Name.
   - DB_PASSWORD= Database User Password.
    
6. Run the below command. It will create all the necessary table and one admin user.
   - Admin Email: admin@email.com
   - Admin Password: 123456
```
php artisan make:migration --seed
```
7. Run the project by below command
```
php artisan serve
```
By running this command it will run the project. You will be able to access the project by this url [http://127.0.0.1:8000](http://127.0.0.1:8000) / [http://localhost:8000](http://localhost:8000)

## Other Required Document
- Api Documentation Url: https://documenter.getpostman.com/view/7647599/UV5ddu5X
- Postman Collection Url: https://www.getpostman.com/collections/8ce42bf2a56f4c881bf8
