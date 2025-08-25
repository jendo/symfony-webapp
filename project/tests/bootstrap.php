<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');


if ((bool) $_SERVER['APP_DEBUG'] === true) {
    umask(0000);
}
