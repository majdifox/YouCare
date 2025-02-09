<?php

$title = "Admin Dashboard - YouCare";
ob_start();
?>
<div class="mb-6">
  <h2 class="text-2xl font-bold text-primary mb-4">Admin Dashboard</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-4 rounded shadow">
      <h3 class="text-xl font-semibold mb-2">Statistics</h3>
      <ul class="text-gray-700">
        <li>Total Patients: <span class="font-bold"><?= $stats['patients'] ?? 'N/A' ?></span></li>
        <li>Total Confirmed Consultations: <span class="font-bold"><?= $stats['consultations'] ?? 'N/A' ?></span></li>
      </ul>
    </div>
   
  </div>
</div>

<div class="mb-6">
  <h3 class="text-xl font-semibold text-primary mb-4">Users</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded shadow">
      <thead class="bg-primary text-white">
        <tr>
          <th class="px-4 py-2">First Name</th>
          <th class="px-4 py-2">Last Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Phone</th>
          <th class="px-4 py-2">Role</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if(!empty($users)): ?>
          <?php foreach($users as $user): ?>
            <tr class="border-b">
              <td class="px-4 py-2"><?= $user['first_name'] ?></td>
              <td class="px-4 py-2"><?= $user['last_name'] ?></td>
              <td class="px-4 py-2"><?= $user['email'] ?></td>
              <td class="px-4 py-2"><?= $user['phone'] ?></td>
              <td class="px-4 py-2"><?= $user['role'] ?></td>
              <td class="px-4 py-2">
                <a href="index.php?action=edit_user&id=<?= $user['id'] ?>" class="text-primary hover:underline">Edit</a> |
                <a href="index.php?action=delete_user&id=<?= $user['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="px-4 py-2 text-center text-gray-600">No users found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div>
  <h3 class="text-xl font-semibold text-primary mb-4">Pending Appointments</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded shadow">
      <thead class="bg-primary text-white">
        <tr>
          <th class="px-4 py-2">Patient</th>
          <th class="px-4 py-2">Doctor</th>
          <th class="px-4 py-2">Appointment Date</th>
          <th class="px-4 py-2">Reason</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if(!empty($pendingRendezVous)): ?>
          <?php foreach($pendingRendezVous as $rv): ?>
            <tr class="border-b">

              <td class="px-4 py-2"><?= $rv['patient_first'] . ' ' . $rv['patient_last'] ?></td>
              <td class="px-4 py-2"><?= $rv['doctor_first'] . ' ' . $rv['doctor_last'] ?></td>
              <td class="px-4 py-2"><?= $rv['appointment_date'] ?></td>
              <td class="px-4 py-2"><?= $rv['reason'] ?></td>
              <td class="px-4 py-2"><?= $rv['status'] ?></td>
              <td class="px-4 py-2">
                <a href="index.php?action=confirm_rdv&id=<?= $rv['id'] ?>" class="text-green-600 hover:underline">Confirm</a> |
                <a href="index.php?action=delete_rdv&id=<?= $rv['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="px-4 py-2 text-center text-gray-600">No pending appointments found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
