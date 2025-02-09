<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Handle user registration with role-based fields
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Common fields
            $first_name = $_POST['first_name'] ?? '';
            $last_name  = $_POST['last_name'] ?? '';
            $email      = $_POST['email'] ?? '';
            $password   = $_POST['password'] ?? '';
            $phone      = $_POST['phone'] ?? '';
            $role       = $_POST['role'] ?? '';

            $extra = [];
            if ($role === 'doctor') {
                $extra['speciality'] = $_POST['speciality'] ?? '';
                $extra['years_of_xp'] = $_POST['years_of_xp'] ?? '';
            } elseif ($role === 'patient') {
                $extra['birth_date'] = $_POST['birth_date'] ?? '';
                $extra['address']    = $_POST['address'] ?? '';
            }

            if ($this->userModel->register($first_name, $last_name, $email, $password, $phone, $role, $extra)) {
                header("Location: index.php?action=login_form");
                exit();
            } else {
                echo "Registration failed!";
            }
        } else {
            // Display registration form if not a POST request
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
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid login credentials!";
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }
}
