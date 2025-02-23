<?php
// File: /app/controllers/PatientController.php
require_once __DIR__ . '/../models/Patient.php';

class PatientController {
    private $patientModel;
    
    public function __construct() {
        $this->patientModel = new Patient();
    }
    
    public function dashboard() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        $user = $_SESSION['user'];
        $patientRecord = $this->patientModel->getPatientByUserId($user['id']);
        if (!$patientRecord) {
            echo "Patient record not found!";
            exit();
        }
        $patient_id = $patientRecord['id'];
        
        $appointments = $this->patientModel->getAppointments($patient_id);

        $doctorList = $this->patientModel->getDoctorList();
        
        include __DIR__ . '/../views/patient_dashboard.php';
    }
    
    public function bookAppointment() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'patient') {
            header("Location: index.php?action=login_form");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctor_id = $_POST['doctor_id'] ?? '';
            $appointment_date = $_POST['appointment_date'] ?? '';
            $reason = $_POST['reason'] ?? '';
            
            $user = $_SESSION['user'];
            $patientRecord = $this->patientModel->getPatientByUserId($user['id']);
            if (!$patientRecord) {
                echo "Patient record not found!";
                exit();
            }
            $patient_id = $patientRecord['id'];
            
            if ($this->patientModel->createAppointment($patient_id, $doctor_id, $appointment_date, $reason)) {
                header("Location: index.php?action=patient_dashboard");
                exit();
            } else {
                echo "Failed to book appointment!";
            }
        }
    }
}
