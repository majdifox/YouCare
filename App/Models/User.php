<?php
require_once __DIR__ . '/../../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Register a new user with role-based data
    public function register($first_name, $last_name, $email, $password, $phone, $role, $extra) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        if ($role == 'doctor') {
            $speciality = $extra['speciality'];
            $years_of_xp = $extra['years_of_xp'];
            $sql = "INSERT INTO public.users (first_name, last_name, email, password, phone, role, speciality, years_of_xp)
                    VALUES (:first_name, :last_name, :email, :password, :phone, :role, :speciality, :years_of_xp)
                    RETURNING id";
            $this->db->query($sql);
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':email', $email);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':phone', $phone);
            $this->db->bind(':role', $role);
            $this->db->bind(':speciality', $speciality);
            $this->db->bind(':years_of_xp', $years_of_xp);
        } elseif ($role == 'patient') {
            $sql = "INSERT INTO public.users (first_name, last_name, email, password, phone, role)
                    VALUES (:first_name, :last_name, :email, :password, :phone, :role)
                    RETURNING id";
            $this->db->query($sql);
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':email', $email);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':phone', $phone);
            $this->db->bind(':role', $role);
        } else {
            // Fallback for any other role
            $sql = "INSERT INTO public.users (first_name, last_name, email, password, phone, role)
                    VALUES (:first_name, :last_name, :email, :password, :phone, :role)
                    RETURNING id";
            $this->db->query($sql);
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':email', $email);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':phone', $phone);
            $this->db->bind(':role', $role);
        }
        
        // Execute and retrieve the new user's id
        $result = $this->db->fetch();
        if (!$result) {
            return false;
        }
        $user_id = $result['id'];

        // Insert into role-specific table
        if ($role == 'doctor') {
            $sql = "INSERT INTO public.doctors (user_id, first_name, last_name, speciality, years_of_xp, phone)
                    VALUES (:user_id, :first_name, :last_name, :speciality, :years_of_xp, :phone)";
            $this->db->query($sql);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':speciality', $speciality);
            $this->db->bind(':years_of_xp', $years_of_xp);
            $this->db->bind(':phone', $phone);
            return $this->db->execute();
        } elseif ($role == 'patient') {
            $birth_date = $extra['birth_date'];
            $address = $extra['address'];
            $sql = "INSERT INTO public.patients (user_id, first_name, last_name, birth_date, phone, address)
                    VALUES (:user_id, :first_name, :last_name, :birth_date, :phone, :address)";
            $this->db->query($sql);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':birth_date', $birth_date);
            $this->db->bind(':phone', $phone);
            $this->db->bind(':address', $address);
            return $this->db->execute();
        } else {
            return true;
        }
    }

    // Login an existing user (using email and password)
    public function login($email, $password) {
        $this->db->query("SELECT * FROM public.users WHERE email = :email");
        $this->db->bind(':email', $email);
        $user = $this->db->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
