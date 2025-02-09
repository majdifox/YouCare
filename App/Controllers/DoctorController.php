<?php
// File: /app/controllers/DoctorController.php
require_once __DIR__ . '/../models/Doctor.php';

class DoctorController {
    private $doctorModel;
    
    public function __construct() {
        $this->doctorModel = new Doctor();
    }
    
    // Display the doctor dashboard
    public function dashboard() {
        // Ensure the session is started and that the logged-in user is a doctor.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        // Get the logged-in user's id from the session.
        $user = $_SESSION['user'];
        
        // Retrieve the doctor's record (from public.doctors) using the user's id.
        $doctorRecord = $this->doctorModel->getDoctorByUserId($user['id']);
        if (!$doctorRecord) {
            echo "Doctor record not found!";
            exit();
        }
        $doctor_id = $doctorRecord['id'];
        
        // Get all confirmed appointments for this doctor.
        $appointments = $this->doctorModel->getConfirmedRendezVous($doctor_id);
        
        include __DIR__ . '/../views/doctor_dashboard.php';
    }
    
    // Process the doctor's action to accept or refuse an appointment.
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
            
            // Map the action: "accept" updates status to "termin", "refuse" updates status to "cancel"
            $newStatus = ($action === 'accept') ? 'termin' : 'cancel';
            $this->doctorModel->updateRendezVousStatus($rdv_id, $newStatus);
            
            header("Location: index.php?action=doctor_dashboard");
            exit();
        }
    }
}
