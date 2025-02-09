<?php
// File: /app/models/Doctor.php
require_once __DIR__ . '/../../core/Database.php';

class Doctor {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get the doctor's record using the user ID from the public.users table.
    public function getDoctorByUserId($user_id) {
        $this->db->query("SELECT * FROM public.doctors WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->fetch();
    }
    
    // Get confirmed rendez-vous (appointments) for this doctor.
    public function getConfirmedRendezVous($doctor_id) {
        $this->db->query("
            SELECT 
            rv.appointment_date, 
            rv.status, 
            rv.reason, 
            p.first_name AS patient_first, 
            p.last_name AS patient_last 
        FROM public.rendez_vous rv
        JOIN public.patients p ON rv.patient_id = p.id
        WHERE rv.doctor_id = :doctor_id 
        AND rv.status = 'confirm'
        ORDER BY rv.appointment_date ASC
        ");
        $this->db->bind(':doctor_id', $doctor_id);
        return $this->db->fetchAll();
    }
    
    // Update the status of a rendez-vous based on doctor's decision.
    public function updateRendezVousStatus($rdv_id, $status) {
        // For doctor's actions: Accept -> update status to "termin", Refuse -> update to "cancel"
        $this->db->query("UPDATE public.rendez_vous 
                          SET status = :status, updated_at = CURRENT_TIMESTAMP 
                          WHERE id = :rdv_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':rdv_id', $rdv_id);
        return $this->db->execute();
    }
}
