<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 REST API Project Template</h1>
    <br>
</p>

Yii 2 REST API Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small rest api projects.

The template contains the basic features including user join/login api.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Testing](https://github.com/forecho/yii2-rest-api/workflows/Testing/badge.svg)](https://github.com/forecho/yii2-rest-api/actions)
[![Lint](https://github.com/forecho/yii2-rest-api/workflows/Lint/badge.svg)](https://github.com/forecho/yii2-rest-api/actions)
[![Code Coverage](https://scrutinizer-ci.com/g/forecho/yii2-rest-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/forecho/yii2-rest-api/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/forecho/yii2-rest-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/forecho/yii2-rest-api/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/forecho/yii2-rest-api/v/stable)](https://packagist.org/packages/forecho/yii2-rest-api) 
[![Total Downloads](https://poser.pugx.org/forecho/yii2-rest-api/downloads)](https://packagist.org/packages/forecho/yii2-rest-api) 
[![Latest Unstable Version](https://poser.pugx.org/forecho/yii2-rest-api/v/unstable)](https://packagist.org/packages/forecho/yii2-rest-api) 
[![License](https://poser.pugx.org/forecho/yii2-rest-api/license)](https://packagist.org/packages/forecho/yii2-rest-api)

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.2.0.

INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist forecho/yii2-rest-api <rest-api>
cd <rest-api>
cp .env.example .env
php yii generate/key # optional 
chmod 777 -R runtime/
~~~

Now you should be able to access the application through the following URL, assuming `rest-api` is the directory
directly under the Web root.

~~~
http://localhost/<rest-api>/web/
~~~

### Install from GitHub

Accessing [Use this template](https://github.com/forecho/yii2-rest-api/generate) Create a new repository from yii2-rest-api

```sh
git clone xxxx
cd <rest-api>
cp .env.example .env
chmod 777 -R runtime/
```

You can then access the application through the following URL:

~~~
http://localhost/<rest-api>/web/
~~~


### Install with Docker

Update your vendor packages

```sh
docker-compose run --rm php composer update --prefer-dist
```

Run the installation triggers (creating cookie validation code)

```sh
docker-compose run --rm php composer install    
```

Start the container

```sh
docker-compose up -d
```
   
You can then access the application through the following URL:

```
http://127.0.0.1:8000
```

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches

Check out the packages
------------

- [yiithings/yii2-doten](https://github.com/yiithings/yii2-doten)
- [sizeg/yii2-jwt](https://github.com/sizeg/yii2-jwt)
- [yiier/yii2-helpers](https://github.com/yiier/yii2-helpers)

Use
------------

At this time, you have a RESTful API server running at `http://127.0.0.1:8000`. It provides the following endpoints:

* `GET /health-check`: a health check service provided for health checking purpose (needed when implementing a server cluster)
* `POST /v1/join`: create a user
* `POST /v1/login`: authenticates a user and generates a JWT
* `POST /v1/refresh-token`: refresh a JWT

Try the URL `http://localhost:8000/health-check` in a browser, and you should see something like `{"code":0,"data":"OK","message":"成功"}` displayed.

If you have `cURL` or some API client tools (e.g. [Postman](https://www.getpostman.com/)), you may try the following 
more complex scenarios:

```shell
# create a user via: POST /v1/join
curl -X POST -H "Content-Type: application/json" -d '{"username":"demo","email":"demo@email.com","password":"pass123"}' http://localhost:8000/v1/join
# should return like: {"code":0,"data":{"username":"demo","email":"demo@email.com","status":1,"created_at":"2020-07-18T16:38:11+08:00","updated_at":"2020-07-18T16:38:11+08:00","id":17},"message":"成功"}

# authenticate the user via: POST /v1/login
curl -X POST -H "Content-Type: application/json" -d '{"username": "demo", "password": "pass123"}' http://localhost:8000/v1/login
# should return like: {"code":0,"data":{"user":{"id":4,"username":"dem211o1","avatar":"","email":"de21mo1@mail.com","status":1,"created_at":"2020-07-17T23:49:39+08:00","updated_at":"2020-07-17T23:49:39+08:00"},"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IllpaS1SRVNULUFQSSJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJqdGkiOiJZaWktUkVTVC1BUEkiLCJpYXQiOjE1OTUwNjQ5NzIsImV4cCI6MTU5NTMyNDE3MiwidXNlcm5hbWUiOiJkZW0yMTFvMSIsImlkIjo0fQ.y2NSVQe-TQ08RnXnF-o55h905G9WHo6GYHNaUWlKjDE"},"message":"成功"}

# refresh a JWT
curl -X POST -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IllpaS1SRVNULUFQSSJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJqdGkiOiJZaWktUkVTVC1BUEkiLCJpYXQiOjE1OTUwNjQ5NzIsImV4cCI6MTU5NTMyNDE3MiwidXNlcm5hbWUiOiJkZW0yMTFvMSIsImlkIjo0fQ.y2NSVQe-TQ08RnXnF-o55h905G9WHo6GYHNaUWlKjDE' http://localhost:8000/v1/refresh-token
# should return like: {"code":0,"data":{"user":{"id":4,"username":"dem211o1","avatar":"","email":"de21mo1@mail.com","status":1,"created_at":"2020-07-17T23:49:39+08:00","updated_at":"2020-07-17T23:49:39+08:00"},"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IllpaS1SRVNULUFQSSJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJqdGkiOiJZaWktUkVTVC1BUEkiLCJpYXQiOjE1OTUwNjQ5NzIsImV4cCI6MTU5NTMyNDE3MiwidXNlcm5hbWUiOiJkZW0yMTFvMSIsImlkIjo0fQ.y2NSVQe-TQ08RnXnF-o55h905G9WHo6GYHNaUWlKjDE"},"message":"成功"}
```
