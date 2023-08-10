# dapr_pubsub_poc
Proof of concept of Dapr pub-sub feature with PHP 8 and Slim Framework

# Requirements

PHP 8 and composer installed as well as [dapr CLI](https://docs.dapr.io/getting-started/install-dapr-cli/) and Docker (dapr requirement).
# Installation

Download composer with [this instructions.](https://getcomposer.org/download/)

Don't forget to do `chmod +x composer.phar` to add execution permisions to the binary.

# Run the app

```
# inside the repo just do a `composer install`. This will install the PHP dependencies
composer.phar install

# Run php built-in PHP server
php -S localhost:8000 index.php

# (Optional) If you haven't made it already
dapr init

# On a separate session you can run the dapr sidecart
dapr run --app-port 8000 --app-id php-subscriber --app-protocol http --dapr-http-port 3500 --resources-path dapr
```

> ℹ️ **VERY IMPORTANT:** `php -S localhost:8000 index.php` won't work because dapr is not able to detect the server from it. It should have something to do with the way the PHP built-in webserver works.

# Endpoints available

Use the postman collection to test it.

# Useful commands

```
# to list the instances of `dapr run` in execution
dapr list

# To use the dapr CLI to publish and trigger the subscription endpoint
dapr publish --publish-app-id php-subscriber --pubsub php-subscriber --topic topic1 --data '{"hello": "world"}'

# To list the process running on port 8000 (Works on OS X, if not installed, install it with brew)
lsof -i :8000
```
