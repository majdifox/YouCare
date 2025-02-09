<?php

$title = "Login - YouCare";
ob_start();
?>
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-bold mb-4 text-center">Login</h2>
  <form action="index.php?action=login" method="POST">
    <div class="mb-4">
      <label class="block text-gray-700">Email</label>
      <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded" placeholder="Email" required>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700">Password</label>
      <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded" placeholder="Password" required>
    </div>
    <div class="mb-4">
      <button type="submit" class="w-full bg-primary text-white py-2 rounded hover:bg-secondary">Login</button>
    </div>
  </form>
  <p class="text-center text-gray-600">Don't have an account? <a href="index.php?action=register_form" class="text-primary hover:underline">Sign up</a></p>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
