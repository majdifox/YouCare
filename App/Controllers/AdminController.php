<?php
// File: /app/controllers/AdminController.php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    // Display the admin dashboard
    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        $users = $this->adminModel->getAllUsers();
        $pendingRendezVous = $this->adminModel->getPendingRendezVous();
        $stats = $this->adminModel->getStatistics();
        include __DIR__ . '/../views/admin_dashboard.php';
    }

    // Show edit user form or process update submission
    public function editUser() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userId = $_GET['id'] ?? '';
            $userData = $this->adminModel->getUserById($userId);
            include __DIR__ . '/../views/edit_user.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId     = $_POST['id'] ?? '';
            $first_name = $_POST['first_name'] ?? '';
            $last_name  = $_POST['last_name'] ?? '';
            $email      = $_POST['email'] ?? '';
            $phone      = $_POST['phone'] ?? '';
            $role       = $_POST['role'] ?? '';
            
            $this->adminModel->updateUser($userId, $first_name, $last_name, $email, $phone, $role);
            header("Location: index.php?action=admin_dashboard");
            exit();
        }
    }

    // Delete a user
    public function deleteUser() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        $userId = $_GET['id'] ?? '';
        if ($userId) {
            $this->adminModel->deleteUser($userId);
        }
        header("Location: index.php?action=admin_dashboard");
        exit();
    }

    // Confirm a rendez-vous (update status to 'confirm')
    public function confirmRdv() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        $rdvId = $_GET['id'] ?? '';
        if ($rdvId) {
            $this->adminModel->updateRdvStatus($rdvId, 'confirm');
        }
        header("Location: index.php?action=admin_dashboard");
        exit();
    }

    // Delete a rendez-vous
    public function deleteRdv() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        $rdvId = $_GET['id'] ?? '';
        if ($rdvId) {
            $this->adminModel->deleteRdv($rdvId);
        }
        header("Location: index.php?action=admin_dashboard");
        exit();
    }
}
