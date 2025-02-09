<?php
require_once __DIR__ . '/../models/User.php';



class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // REGISTER METHOD (kept as before)
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Common fields
            $first_name = $_POST['first_name'] ?? '';
            $last_name  = $_POST['last_name'] ?? '';
            $email      = $_POST['email'] ?? '';
            $password   = $_POST['password'] ?? '';
            $phone      = $_POST['phone'] ?? '';
            $role       = $_POST['role'] ?? '';

            // Role-specific extra fields
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
            include __DIR__ . '/../views/register.php';
        }
    }

    // LOGIN METHOD (updated with session check and role-based redirection)
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($email, $password);

            if ($user) {
                // Check if a session is already started to avoid duplicate session_start() calls.
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = $user;

                // Redirect based on the user's role
                switch ($user['role']) {
                    case 'admin':
                        header("Location: index.php?action=admin_dashboard");
                        break;
                    case 'doctor':
                        header("Location: index.php?action=doctor_dashboard");
                        break;
                    case 'patient':
                        header("Location: index.php?action=patient_dashboard");
                        break;
                    default:
                        header("Location: index.php");
                        break;
                }
                exit();
            } else {
                echo "Invalid login credentials!";
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }
}
