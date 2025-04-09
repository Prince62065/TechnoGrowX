<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Farmers’ Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-green-700 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-semibold">Farmers’ Disease Diagnostic Portal</h1>
      <div>
        <span class="mr-4">👋 Hello, <strong><?= $_SESSION['user_name'] ?></strong></span>
        <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">Logout</a>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow container mx-auto px-4 py-10">
    <div class="bg-white p-6 rounded-lg shadow text-center">
      <h2 class="text-2xl font-bold mb-4">Welcome to Your Dashboard</h2>
      <p class="text-gray-600 mb-6">You are logged in as <span class="text-green-700 font-semibold"><?= $_SESSION['user_type'] ?></span></p>
      <a href="report.php" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md text-lg transition">📋 Submit Disease Report</a>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center py-4">
    <p>&copy; 2025 Farmers' Disease Diagnostic Portal. All rights reserved.</p>
  </footer>

</body>
</html>
