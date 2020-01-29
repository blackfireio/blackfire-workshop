Blackfire Workshop
==================

This Symfony application is a demo application created to show how you can
profile Symfony applications using [Blackfire.io](https://blackfire.io).

Requirements
------------

- Docker;
- Docker-compose.

**or**

- PHP 7.2 or higher;
- PDO-SQLite PHP extension enabled;
- [Blackfire](https://blackfire.io/getting-started);
- and the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html).

If unsure about meeting these requirements, download this application and
browse the `http://localhost:8000/check.php` script to get more detailed
information.

Installation (with Docker)
--------------------------

Install dependencies:

```
docker-compose run --rm app composer install
```

Export your Blackfire environment variables:

```
export BLACKFIRE_SERVER_ID=[YOUR-VALUE]
export BLACKFIRE_SERVER_TOKEN=[YOUR-VALUE]
```

And start containers:

```
docker-compose up
```

After this step, jump to section "Usage".

Installation (without Docker)
-----------------------------

Install dependencies:

```
composer install
```

And start server:

```
# With embedded server
app/console server:run --env=prod

# Or with Symfony CLI
symfony serve
```

Usage
-----

You can access the application in your browser at
[http://localhost:8000](http://localhost:8000). You can stop the server by
running `docker-compose down` if you're using docker, or by pressing `Ctrl + C`
while you're in the terminal if you're not using Docker.

> **Note**: if you are using Symfony CLI, you might need to add `/app.php` to
> your URL to get the "prod" environment.
