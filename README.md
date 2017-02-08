# silex-doctrine-orm-starter

**Project Requirements**: PHP7, Composer

[Silex](http://silex.sensiolabs.org/) is a PHP micro-framework based on Symfony components. Silex can be a pleasure to work with for developers that enjoy more control over the structure of their applications. However, large projects that use Silex often require more disciplined patterns and sometimes need a full-fledged ORM. While Silex does not officially support [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html), [dflydev-doctrine-orm-service-provider](https://github.com/dflydev/dflydev-doctrine-orm-service-provider) is an excellent extension for which to provide your Silex app with ORM behavior. This project goes a step futher. Silex-doctrine-orm-starter provides examples of extendible patterns and methods that I have found useful in my experience using Silex and Doctrine ORM. A few highlights include:

  - Doctrine ORM annotation mapping
  - Doctrine lifecycle event hooks in the form of a TimestampableEntity trait, and a UserSubscriber
  - A bootstrapped, custom Doctrine cli with an example custom command using the Symfony console component.
  - A test case class that provides easy integration with the doctrine-fixtures library.

The starter also includes some Silex specific goodies:
  - Defining controllers as services
  - Integration with the Silex web debug toolbar (also includes Doctrine DBAL queries)

### How should I use this project?

It is unlikely that you will need every component of this starter package. If you have an existing Silex app, you may decide to use this project as a reference guide for how to structure your application code or for how to utilize some of Doctrine ORM's high level features. For more information on Doctrine's features, check out its [excellent documentation](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/).

You may also decide to use silex-doctrine-orm-starter as a skeleton project for a new Silex app. It makes a great starting point specificically for JSON-based REST APIs backed by a MySQL database. To begin a new project, follow the installation instructions below.

### Installation

1. Clone this repository:

    ```
    $ git clone git@github.com:pstephenson02/silex-doctrine-orm-starter.git
    $ cd silex-doctrine-orm-starter/
    ```
2. Install dependencies:

    ```
    $ composer install -o
    ```
3. Configure app parameters:
    ```
    $ cp app/parameters.dist.php app/parameters.php
    ```
    Open the `parameters.php` file with your text editor of choice and replace the defaults with your own database settings. Changing `debug` to `true` will provide the Silex Web Profiler toolbar on requests - this is very useful during development. If you have not already created a new MySQL database, you should do so now. If you are unsure how to do this, refer to these DigitalOcean tutorials [^1], [^2].
    
4. Create the database schema:
    ```
    $ ./bin/doctrine orm:schema-tool:create
    ```
5. Profit! Your app is now installed, configured and ready to be used. Continue on to the usage section for some tips for getting started.

### Usage
You will need a web server to negotiate requests and responses to your app. For development purposes, the simplest option is to use the PHP built-in webserver:
```
$ php -S localhost:8000 -t public/
```
In a production environment, you should use something more reliable (Apache, nginx, etc.)
You can now make requests to your API. Let's create a new user:
```
$ curl -H 'Content-Type: application/json' -X POST '{"email":"bob@loblaw.org"}' localhost:8000/user/
{"id":1,"email":"bob@loblaw.org"}
```

If we now call the `getUsers` endpoint at /user/ we'll see our user:
```
curl -v localhost:8000/user/
*   Trying 127.0.0.1...
* Connected to localhost (127.0.0.1) port 8000 (#0)
> GET /user/ HTTP/1.1
> Host: localhost:8000
> User-Agent: curl/7.47.0
> Accept: */*
> 
< HTTP/1.1 200 OK
< Host: localhost:8000
< Connection: close
< X-Powered-By: PHP/7.0.13-0ubuntu0.16.04.1
< Cache-Control: no-cache, private
< Content-Type: application/json
< X-Debug-Token: 0ec09f
< X-Debug-Token-Link: http://localhost:8000/_profiler/0ec09f
< Date: Wed, 08 Feb 2017 19:46:08 GMT
< 
* Closing connection 0
[{"id":1,"email":"bob@loblaw.org"}]
```
In this case, I passed the `-v` curl flag to show the HTTP headers. Because I set `debug` to `true` in my `app/parameters.php` file, notice that I now get the header `X-Debug-Token-Link`. If we follow the link shown in this header with a web browser, we'll find the web profiler page with helpful information about this request.

**Seeding Users**

You can also create users with the command line tool by using the `orm:seed:users` command:
```
$ ./bin/doctrine orm:seed:users
How many users would you like to create? 100
Successfully generated 100 new users!
```
This command creates new users with random string email addresses. For more information on how this command works, see `UserSeeder.php` and Symfony's Console Component [documentation](http://symfony.com/doc/current/components/console.html).

### Running tests
To run the test suite, simply run phpunit from the vendor folder:
```
$ vendor/bin/phpunit
```
For more control over testing, use the `phpunit.xml.dist` file as a template and configure phpunit:
```
$ cp phpunit.xml.dist phpunit.xml
```

### What now?

That's all for now! I hope this project and this README contains some useful info for your own projects. I encourage you to play around with the features found here and tweak them to meet your own needs. This project was designed around my own needs for past (and current) Silex projects. You may (probably will) find your own requirements to be different.

In the future, I will write more documentation explaining other features found in silex-orm-doctrine-starter and I plan to write about why I chose to do things the way I've done here. I will also continue to build on this project to integrate more common tool sets. Specifically, in the future I would like to include:
* Data migrations with the [Doctrine Migrations library](https://github.com/doctrine/migrations)
* Integration with [Swagger](http://swagger.io/)


[^1]: https://www.digitalocean.com/community/tutorials/a-basic-mysql-tutorial
[^2]: https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql
