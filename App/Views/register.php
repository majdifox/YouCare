<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script>
    function toggleFields() {
        var role = document.getElementById("role").value;
        if (role === "doctor") {
            document.getElementById("doctorFields").style.display = "block";
            document.getElementById("patientFields").style.display = "none";
        } else if (role === "patient") {
            document.getElementById("doctorFields").style.display = "none";
            document.getElementById("patientFields").style.display = "block";
        } else {
            document.getElementById("doctorFields").style.display = "none";
            document.getElementById("patientFields").style.display = "none";
        }
    }
    </script>
</head>
<body>
    <h2>Register</h2>
    <form action="index.php?action=register" method="POST">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone" required><br>
        <select name="role" id="role" onchange="toggleFields()" required>
            <option value="">Select Role</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select><br>
        <div id="doctorFields" style="display:none;">
            <input type="text" name="speciality" placeholder="Speciality"><br>
            <input type="text" name="years_of_xp" placeholder="Years of Experience"><br>
        </div>
        <div id="patientFields" style="display:none;">
            <input type="date" name="birth_date" placeholder="Birth Date"><br>
            <textarea name="address" placeholder="Address"></textarea><br>
        </div>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php?action=login_form">Login here</a></p>
</body>
</html>
