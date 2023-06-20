# EXPLANATION

## Generate Repository

`php artisan make:repository {name}`

Use created custom command to generate repository for Model, think `{name}` as a Model, For example:

```
$ php artisan make:repository Brand
```

This command will result files:

- App\Interfaces\BrandRespositoryInterface.php
- App\Repositories\BrandRespository.php

## Generate Service

`php artisan make:service {name}`

Use created custom command to generate service for Model and Respository, think `{name}` as a Model, For example:

```
$ php artisan make:service Brand
```

This command will result files:

- App\Interfaces\BrandServiceInterface.php
- App\Repositories\BrandService.php