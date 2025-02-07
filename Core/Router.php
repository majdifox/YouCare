<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$authController = new AuthController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        $authController->register();
        break;
    case 'login':
        $authController->login();
        break;
    case 'register_form':
        include __DIR__ . '/../app/views/register.php';
        break;
    case 'login_form':
        include __DIR__ . '/../app/views/login.php';
        break;
    default:
        echo "Welcome to the MVC Login System! <br>";
        echo "<a href='index.php?action=login_form'>Login</a> | ";
        echo "<a href='index.php?action=register_form'>Register</a>";
        break;
}
