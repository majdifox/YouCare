<?php
// File: /app/models/Patient.php
require_once __DIR__ . '/../../core/Database.php';

class Patient {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Retrieve the patient's record using the user_id from public.patients.
    public function getPatientByUserId($user_id) {
        $this->db->query("SELECT * FROM public.patients WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->fetch();
    }
    
    // Get all appointments for the patient.
    public function getAppointments($patient_id) {
        $this->db->query("
            SELECT 
            rv.appointment_date, 
            rv.status, 
            rv.reason, 
            d.first_name AS doctor_first, 
            d.last_name AS doctor_last 
        FROM public.rendez_vous rv
        JOIN public.doctors d ON rv.doctor_id = d.id
        WHERE rv.patient_id = :patient_id
        ORDER BY rv.appointment_date ASC
        ");
        $this->db->bind(':patient_id', $patient_id);
        return $this->db->fetchAll();
    }
    
    // Retrieve a list of all doctors for booking a new appointment.
    public function getDoctorList() {
        $this->db->query("
            SELECT d.*, u.first_name AS user_first, u.last_name AS user_last, u.email
            FROM public.doctors d
            JOIN public.users u ON d.user_id = u.id
            ORDER BY u.first_name ASC
        ");
        return $this->db->fetchAll();
    }
    
    // Insert a new rendez-vous (appointment) for the patient.
    // The new appointment will have status 'in progress' by default.
    public function createAppointment($patient_id, $doctor_id, $appointment_date, $reason) {
        $this->db->query("
            INSERT INTO public.rendez_vous (patient_id, doctor_id, appointment_date, reason)
            VALUES (:patient_id, :doctor_id, :appointment_date, :reason)
        ");
        $this->db->bind(':patient_id', $patient_id);
        $this->db->bind(':doctor_id', $doctor_id);
        $this->db->bind(':appointment_date', $appointment_date);
        $this->db->bind(':reason', $reason);
        return $this->db->execute();
    }
}
