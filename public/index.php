<?php

use App\Kernel;
use Bow\Application\Application;
use Bow\Http\Request;
use Bow\Http\Response;

// Security: Disable error display in production
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Security: Set secure session settings
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');

// Register The Auto Loader
if (!file_exists(__DIR__ . "/../vendor/autoload.php")) {
    die("Please install the dependencies with 'composer update'");
}

if (file_exists(__DIR__ . '/../var/storage/maintenance.php')) {
    require __DIR__ . '/../var/storage/maintenance.php';
}

require __DIR__."/../vendor/autoload.php";

$app = Application::make(Request::getInstance(), Response::getInstance());

// Bind kernel to application
$app->bind(
    Kernel::configure(dirname(__DIR__))->withConfigPath(dirname(__DIR__) . '/config')
);

// Run The Application
$app->run();
