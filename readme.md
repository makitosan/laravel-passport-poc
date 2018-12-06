# ABOUT 

This repository is created to confirm how "Laravel Passport" works in unexpected situations.
Laravel and its Passport is customized as the followings

* api path is under the `/api/v1`, see `routes/api.php` and `app/Providers/AuthServiceProvider.php`


## Create User

```
php artisan tinker
```

```
$user1 = new App\User;
$user1->name = 'user1';
$user1->email = 'user1@test.com';
$user1->password = Hash::make('password');
$user1->save();
exit;
```

## Create Laravel password Grant Client

```
php artisan passport:client --password
```

## Authentication Errors

```
curl -X POST -H 'Content-Type: application/json' -H 'Accept: application/json' -d '{"grant_type":"password", "client_id":"[client_id]", "client_secret":"[client_secret]", "username":"user1@test.com", "password":"password", "scope":"*"}' -i http://localhost/api/v1/oauth/token
```

### Wrong username or password

```
401 Unauthorized
{"error":"invalid_credentials","message":"The user credentials were incorrect."}
```

### Wrong client_id or client_secret

```
401 Unauthorized
{"error":"invalid_client","message":"Client authentication failed"}
```

## Authorization Errors

```
curl -H 'Accept: application/json' -H 'Accept: application/json' -H 'Authorization: Bearer [your_api_token]' -i http://localhost/api/v1/user
```

### Authorization Header Errors

* wrong api token
* no `Authorization` header
* expired api token

```
401 Unauthorized 
{"message":"Unauthenticated."}
```
