<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form action="index.php?action=edit_user" method="POST">
        <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">
        <input type="text" name="first_name" placeholder="First Name" value="<?php echo $userData['first_name']; ?>" required><br>
        <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $userData['last_name']; ?>" required><br>
        <input type="email" name="email" placeholder="Email" value="<?php echo $userData['email']; ?>" required><br>
        <input type="text" name="phone" placeholder="Phone" value="<?php echo $userData['phone']; ?>" required><br>
        <select name="role" required>
            <option value="patient" <?php echo $userData['role'] == 'patient' ? 'selected' : ''; ?>>Patient</option>
            <option value="doctor" <?php echo $userData['role'] == 'doctor' ? 'selected' : ''; ?>>Doctor</option>
            <option value="admin" <?php echo $userData['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
    <p><a href="index.php?action=admin_dashboard">Back to Dashboard</a></p>
</body>
</html>
