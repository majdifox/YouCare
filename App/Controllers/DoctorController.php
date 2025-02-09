<?php
require_once __DIR__ . '/../models/Doctor.php';

class DoctorController {
    private $doctorModel;
    
    public function __construct() {
        $this->doctorModel = new Doctor();
    }
    
    // Display the doctor dashboard
    public function dashboard() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        $user = $_SESSION['user'];
        
        $doctorRecord = $this->doctorModel->getDoctorByUserId($user['id']);
        if (!$doctorRecord) {
            echo "Doctor record not found!";
            exit();
        }
        $doctor_id = $doctorRecord['id'];
        
        $appointments = $this->doctorModel->getConfirmedRendezVous($doctor_id);
        
        include __DIR__ . '/../views/doctor_dashboard.php';
    }
    
    public function updateAppointment() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rdv_id = $_POST['rdv_id'] ?? '';
            $action = $_POST['action'] ?? '';
            
            $newStatus = ($action === 'accept') ? 'finish' : 'cancel';
            $this->doctorModel->updateRendezVousStatus($rdv_id, $newStatus);
            
            header("Location: index.php?action=doctor_dashboard");
            exit();
        }
    }
}
