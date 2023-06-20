## About this repository

This is backend test for REDCOMM. Using Laravel 10 as a core, and use service repository pattern, also Strict class type.

Using JWT for Authorization.

## Installation

- Clone this project
- cd path/to/your/project
- cp .env.example .env
- composer install
- make some changes in .env file. like: database settings and APP_URL
- php artisan key:generate
- php artisan migrate:fresh --seed

## Configuration

Make some changes in the `.env` file

### JWT 

run command `php artisan jwt:secret`

```
JWT_SECRET={generated from command}
```

### Database

Adjust database env with your own setting

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=redcomm
DB_USERNAME=root
DB_PASSWORD=admin
```

### App Url

Adjust the application url, if you are using artisan `serve`, use this url

```
APP_URL=http://localhost:8000
```

### Mail

Register https://mailtrap.io/ for email testing, use your own setting, and put the credential to `.env` file

Example:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=be140c485cc633
MAIL_PASSWORD=308d4d977495bf
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@inosoft.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Filesystem Disk

Use public filesystem instead of local

```
FILESYSTEM_DISK=public
```

## Run

Run this application using `serve` or other method (like valet or homestead)

```
$ php artisan serve
```

## API Documentation

Download postman collection in this repo

## Credential

Every user generated using seeder, will using `password` for login.

Example:

email: jhon.doe@example.com

password: password

## Test

Run this command

```
php artisan test
```