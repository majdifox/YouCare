<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Handle user registration
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = $_POST['name'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->register($name, $email, $password)) {
                // Redirect to login page (adjust URL as needed)
                header("Location: index.php?action=login_form");
                exit();
            } else {
                echo "Registration failed!";
            }
        } else {
            // If not a POST request, show the registration form
            include __DIR__ . '/../views/register.php';
        }
    }

    // Handle user login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($email, $password);

            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                // Redirect to dashboard or another secure page
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid login credentials!";
            }
        } else {
            // If not a POST request, show the login form
            include __DIR__ . '/../views/login.php';
        }
    }
}
