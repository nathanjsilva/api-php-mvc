<?php

session_start();

require_once 'config.php';
require_once 'app/configs/.env.php';
require_once 'app/configs/server.php';
require_once 'vendor/autoload.php';
require_once 'globals/functions.php';

register_shutdown_function('catch_fatal_error');

requireMessagesFiles();

try {
    $router = new \Utils\Router\Router();

    # Requires routes files
    foreach (new \DirectoryIterator('app/routes/') as $f) {
        if (!$f->isDot()) require_once 'app/routes/' . $f->getFilename();
    }

    (new \Utils\Router\Runner($router))->run();
} catch (\Exception $e) {
    echo (new \Utils\ExceptionsHandler($e, 'E000-000', 500))->_json();
} finally {
    session_destroy();
}
