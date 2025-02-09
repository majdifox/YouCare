<?php

$title = "Doctor Dashboard - YouCare";
ob_start();
?>
<div class="mb-6">
  <h2 class="text-2xl font-bold text-primary mb-4">Doctor Dashboard</h2>
  <p class="text-gray-700 mb-4">Here are your confirmed appointments.</p>
</div>

<div class="overflow-x-auto">
  <table class="min-w-full bg-white rounded shadow">
    <thead class="bg-primary text-white">
      <tr>
        <th class="px-4 py-2">Patient</th>
        <th class="px-4 py-2">Appointment Date</th>
        <th class="px-4 py-2">Reason</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Actions</th>
      </tr>
    </thead>
    <tbody class="text-gray-700">
      <?php if(!empty($appointments)): ?>
        <?php foreach($appointments as $app): ?>
          <tr class="border-b">
            <td class="px-4 py-2"><?= $app['patient_first'] . ' ' . $app['patient_last'] ?></td>
            <td class="px-4 py-2"><?= $app['appointment_date'] ?></td>
            <td class="px-4 py-2"><?= $app['reason'] ?></td>
            <td class="px-4 py-2"><?= $app['status'] ?></td>
            <td class="px-4 py-2">
              <form action="index.php?action=doctor_update" method="POST" class="inline">
                <input type="hidden" name="rdv_id" value="<?= $app['id'] ?>">
                <button type="submit" name="action" value="accept" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Accept</button>
              </form>
              <form action="index.php?action=doctor_update" method="POST" class="inline ml-2">
                <input type="hidden" name="rdv_id" value="<?= $app['id'] ?>">
                <button type="submit" name="action" value="refuse" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Refuse</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="px-4 py-2 text-center text-gray-600">No confirmed appointments found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
