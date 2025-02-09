<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/DoctorController.php';
require_once __DIR__ . '/../app/controllers/PatientController.php';


$action = $_GET['action'] ?? '';

switch ($action) {
    // Authentication routes
    case 'register':
        $authController = new AuthController();
        $authController->register();
        break;
        
    case 'login':
        $authController = new AuthController();
        $authController->login();
        break;
        
    case 'register_form':
        include __DIR__ . '/../app/views/register.php';
        break;
        
    case 'login_form':
        include __DIR__ . '/../app/views/login.php';
        break;
        
    // Admin routes
    case 'admin_dashboard':
        $adminController = new AdminController();
        $adminController->dashboard();
        break;
        
    case 'edit_user':
        $adminController = new AdminController();
        $adminController->editUser();
        break;
        
    case 'delete_user':
        $adminController = new AdminController();
        $adminController->deleteUser();
        break;
        
    case 'confirm_rdv':
        $adminController = new AdminController();
        $adminController->confirmRdv();
        break;
        
    case 'delete_rdv':
        $adminController = new AdminController();
        $adminController->deleteRdv();
        break;
        
    // Doctor routes
    case 'doctor_dashboard':
        $doctorController = new DoctorController();
        $doctorController->dashboard();
        break;
        
    case 'doctor_update':
        $doctorController = new DoctorController();
        $doctorController->updateAppointment();
        break;
        
    // Patient routes
    case 'patient_dashboard':
        $patientController = new PatientController();
        $patientController->dashboard();
        break;
        
    case 'patient_book':
        $patientController = new PatientController();
        $patientController->bookAppointment();
        break;
        
    // Default route: Show welcome message with links
    default:
        echo "Welcome to Youcare ! <br>";
        echo "<a href='index.php?action=login_form'>Login</a> | ";
        echo "<a href='index.php?action=register_form'>Register</a>";
        break;
}
