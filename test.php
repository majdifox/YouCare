<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;

$auth = new AuthController();
echo "Autoloading works!";
