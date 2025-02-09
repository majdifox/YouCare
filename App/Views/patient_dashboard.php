<?php
// App/Views/patient_dashboard.php
// Expected variables: $appointments, $doctorList
$title = "Patient Dashboard - YouCare";
ob_start();
?>
<div class="mb-6">
  <h2 class="text-2xl font-bold text-primary mb-4">Patient Dashboard</h2>
  <p class="text-gray-700 mb-4">View your appointments and book a new one.</p>
</div>

<div class="mb-8">
  <h3 class="text-xl font-semibold text-primary mb-2">Your Appointments</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded shadow">
      <thead class="bg-primary text-white">
        <tr>
          <th class="px-4 py-2">Doctor</th>
          <th class="px-4 py-2">Appointment Date</th>
          <th class="px-4 py-2">Reason</th>
          <th class="px-4 py-2">Status</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if(!empty($appointments)): ?>
          <?php foreach($appointments as $app): ?>
            <tr class="border-b">
              <td class="px-4 py-2"><?= $app['doctor_first'] . ' ' . $app['doctor_last'] ?></td>
              <td class="px-4 py-2"><?= $app['appointment_date'] ?></td>
              <td class="px-4 py-2"><?= $app['reason'] ?></td>
              <td class="px-4 py-2"><?= $app['status'] ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="px-4 py-2 text-center text-gray-600">No appointments found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="bg-white p-6 rounded shadow">
  <h3 class="text-xl font-semibold text-primary mb-4">Book a New Appointment</h3>
  <form action="index.php?action=patient_book" method="POST">
    <div class="mb-4">
      <label class="block text-gray-700">Select Doctor:</label>
      <select name="doctor_id" class="w-full border border-gray-300 p-2 rounded" required>
        <option value="">Choose a doctor</option>
        <?php if(!empty($doctorList)): ?>
          <?php foreach($doctorList as $doc): ?>
            <option value="<?= $doc['id'] ?>">
              <?= $doc['user_first'] . ' ' . $doc['user_last'] . ' (' . $doc['speciality'] . ')' ?>
            </option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700">Appointment Date &amp; Time:</label>
      <input type="datetime-local" name="appointment_date" class="w-full border border-gray-300 p-2 rounded" required>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700">Reason for Appointment:</label>
      <textarea name="reason" class="w-full border border-gray-300 p-2 rounded" rows="3" required></textarea>
    </div>
    <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary">Book Appointment</button>
  </form>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
