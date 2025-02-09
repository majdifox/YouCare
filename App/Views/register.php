<?php

$title = "Register - YouCare";
ob_start();
?>
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>
  <form action="index.php?action=register" method="POST" id="registerForm">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700">First Name</label>
        <input type="text" name="first_name" class="w-full border border-gray-300 p-2 rounded" placeholder="First Name" required>
      </div>
      <div>
        <label class="block text-gray-700">Last Name</label>
        <input type="text" name="last_name" class="w-full border border-gray-300 p-2 rounded" placeholder="Last Name" required>
      </div>
    </div>
    <div class="mt-4">
      <label class="block text-gray-700">Email</label>
      <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded" placeholder="Email" required>
    </div>
    <div class="mt-4">
      <label class="block text-gray-700">Password</label>
      <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded" placeholder="Password" required>
    </div>
    <div class="mt-4">
      <label class="block text-gray-700">Phone</label>
      <input type="text" name="phone" class="w-full border border-gray-300 p-2 rounded" placeholder="Phone" required>
    </div>
    <div class="mt-4">
      <label class="block text-gray-700">Role</label>
      <select name="role" id="role" class="w-full border border-gray-300 p-2 rounded" required onchange="toggleExtraFields()">
        <option value="">Select Role</option>
        <option value="doctor">Doctor</option>
        <option value="patient">Patient</option>
      </select>
    </div>
    <!-- Extra fields for doctor -->
    <div id="doctorFields" class="mt-4 hidden">
      <div class="mt-4">
        <label class="block text-gray-700">Speciality</label>
        <input type="text" name="speciality" class="w-full border border-gray-300 p-2 rounded" placeholder="Speciality">
      </div>
      <div class="mt-4">
        <label class="block text-gray-700">Years of Experience</label>
        <input type="text" name="years_of_xp" class="w-full border border-gray-300 p-2 rounded" placeholder="Years of Experience">
      </div>
    </div>
    <!-- Extra fields for patient -->
    <div id="patientFields" class="mt-4 hidden">
      <div class="mt-4">
        <label class="block text-gray-700">Birth Date</label>
        <input type="date" name="birth_date" class="w-full border border-gray-300 p-2 rounded">
      </div>
      <div class="mt-4">
        <label class="block text-gray-700">Address</label>
        <textarea name="address" class="w-full border border-gray-300 p-2 rounded" placeholder="Address"></textarea>
      </div>
    </div>
    <div class="mt-6">
      <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary">Register</button>
    </div>
  </form>
  <p class="text-center text-gray-600 mt-4">Already have an account? <a href="index.php?action=login_form" class="text-primary hover:underline">Login</a></p>
</div>
<script>
function toggleExtraFields() {
  var role = document.getElementById("role").value;
  document.getElementById("doctorFields").classList.add("hidden");
  document.getElementById("patientFields").classList.add("hidden");
  if (role === "doctor") {
    document.getElementById("doctorFields").classList.remove("hidden");
  } else if (role === "patient") {
    document.getElementById("patientFields").classList.remove("hidden");
  }
}
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
