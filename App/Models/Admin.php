<?php
// File: /app/models/Admin.php
require_once __DIR__ . '/../../core/Database.php';

class Admin {
    private $db;
    
    public function __construct(){
        $this->db = new Database();
    }
    
    // Get all users from the users table
    public function getAllUsers(){
        $this->db->query("SELECT * FROM public.users WHERE role <> 'admin'  ORDER BY created_at DESC");
        return $this->db->fetchAll();
    }
    
    // Get a single user by id
    public function getUserById($id){
        $this->db->query("SELECT * FROM public.users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }
    
    // Update user data (common fields)
    public function updateUser($id, $first_name, $last_name, $email, $phone, $role){
        $sql = "UPDATE public.users 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    email = :email, 
                    phone = :phone, 
                    role = :role, 
                    updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':first_name', $first_name);
        $this->db->bind(':last_name', $last_name);
        $this->db->bind(':email', $email);
        $this->db->bind(':phone', $phone);
        $this->db->bind(':role', $role);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Delete a user by id
    public function deleteUser($id){
        $this->db->query("DELETE FROM public.users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get rendez-vous that are pending (status 'in progress')
    public function getPendingRendezVous(){
        $this->db->query("
            SELECT rv.*, 
                   p.first_name AS patient_first, 
                   p.last_name AS patient_last, 
                   d.first_name AS doctor_first, 
                   d.last_name AS doctor_last 
            FROM public.rendez_vous rv
            JOIN public.patients p ON rv.patient_id = p.id
            JOIN public.doctors d ON rv.doctor_id = d.id
            WHERE rv.status = 'in progress'
            ORDER BY rv.created_at DESC
        ");
        return $this->db->fetchAll();
    }
    
    // Update the status of a rendez-vous (e.g., confirm it)
    public function updateRdvStatus($id, $status){
        $this->db->query("UPDATE public.rendez_vous SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Delete a rendez-vous
    public function deleteRdv($id){
        $this->db->query("DELETE FROM public.rendez_vous WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get statistics: count of patients and confirmed consultations
    public function getStatistics(){
        // Count patients (users with role 'patient')
        $this->db->query("SELECT COUNT(*) AS patient_count FROM public.users WHERE role = 'patient'");
        $patients = $this->db->fetch()['patient_count'];
        
        // Count confirmed consultations (rendez-vous with status 'confirm')
        $this->db->query("SELECT COUNT(*) AS consultation_count FROM public.rendez_vous WHERE status = 'confirm'");
        $consultations = $this->db->fetch()['consultation_count'];
        
        return [
            'patients'      => $patients,
            'consultations' => $consultations
        ];
    }
}
