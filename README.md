# Blackfire Workshop

This Symfony application is a demo application created to show how
you can profile Symfony applications using different tools.

Requirements
------------

  * Docker

**or**

  * PHP 5.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * Xdebug
  * XHProf
  * [Blackfire](https://blackfire.io/getting-started)
  * and the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html).

If unsure about meeting these requirements, download this application and
browse the `http://localhost:8000/check.php` script to get more detailed
information.

Installation
------------

First, clone this repository, if you haven't already.

If you want to use Docker, this is the moment to jump to the next section.

Finally, install the vendors (you will need composer installed) :


```bash
$ composer install
```

### Usage

If you have PHP 5.4 or higher, there is no need to configure a virtual host
in your web server to access the application. Just use the built-in web server:

```bash
$ cd blackfire-workshop/
$ php app/console server:run --env=prod
```

This command will start a web server for the Symfony application. Now you can
access the application in your browser at <http://localhost:8000>. You can
stop the built-in web server by pressing `Ctrl + C` while you're in the
terminal.

> **NOTE**
>
> If you're using PHP 5.3, configure your web server to point at the `web/`
> directory of the project. For more details, see:
> http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
> 

Getting started w/ Docker
-------------------------

Install local application dependencies:
```
composer install
```

You can pull the Docker images by running:
```
./pull.sh
```

### Usage

First of all export your Blackfire environment variables:
```
export BLACKFIRE_SERVER_ID=[YOUR-VALUE]
export BLACKFIRE_SERVER_TOKEN=[YOUR-VALUE]
```

Then just follow the instructions given by the `pull.sh` script.

Alternatively, if you have docker-compose, you can start the demo application easily:

```
docker-compose run -d
```
