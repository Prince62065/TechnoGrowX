<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!="farmer") {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Farmer Dashboard - Farmers' Portal</title>
  <link rel="stylesheet" href="./output.css">
</head>
<body class="bg-gray-100" onclick="closeSidebarOnOutsideClick(event)">
  <div class="min-h-screen flex flex-col md:flex-row">
    <!-- Mobile Sidebar Toggle Button (At the Top) -->
    <header class="w-full bg-green-600 text-white p-4 flex justify-between items-center md:hidden">
      <h2 class="text-xl font-bold">Farmer Dashboard</h2>
      <button class="text-white text-2xl" onclick="toggleSidebar(event)">☰</button>
    </header>

    <!-- Sidebar (Full Height) -->
    <aside class="w-64 bg-green-600 text-white p-5 hidden md:block h-screen">
      <h2 class="text-2xl font-bold mb-8">Farmer Dashboard</h2>
      <ul>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/report.php" class="hover:text-gray-200">Report Disease</a></li>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/view_reports.php" class="hover:text-gray-200">View Reports</a></li>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/farmer_profile.php" class="hover:text-gray-200">Profile</a></li>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/login.html" class="hover:text-gray-200">Logout</a></li>
      </ul>
    </aside>

    <!-- Mobile Sidebar (Full Height) -->
    <aside id="mobileSidebar" class="fixed inset-y-0 left-0 w-64 bg-green-600 text-white p-5 transform -translate-x-full transition-transform md:hidden z-50 h-full">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold">Farmer Dashboard</h2>
        <button class="text-white text-2xl" onclick="toggleSidebar(event)">✖</button>
      </div>
      <ul>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/report.php" class="hover:text-gray-200">Report Disease</a></li>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/farmer_profile.php" class="hover:text-gray-200">View Reports</a></li>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/farmer_profile.php" class="hover:text-gray-200">Profile</a></li>
        <li class="mb-4"><a href="http://localhost/PROJECT/src/login.html" class="hover:text-gray-200">Logout</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <h1 class="text-3xl font-bold text-green-700 mb-6">Welcome,<?php echo $_SESSION['user_name'] ?></h1>
      <p class="text-gray-600">Here you can report any crop or livestock issues, check previous reports, and get expert advice.</p>

      <!-- Dashboard Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-green-700">Report Disease</h3>
          <p class="text-gray-500">Submit a new report about your crop or livestock issues.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-green-700">View Reports</h3>
          <p class="text-gray-500">Check the status of your previous reports.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-semibold text-green-700">Profile</h3>
          <p class="text-gray-500">View and edit your profile details.</p>
        </div>
      </div>
    </main>
  </div>

  <script>
    function toggleSidebar(event) {
      event.stopPropagation();
      const sidebar = document.getElementById('mobileSidebar');
      sidebar.classList.toggle('-translate-x-full');
    }

    function closeSidebarOnOutsideClick(event) {
      const sidebar = document.getElementById('mobileSidebar');
      if (!sidebar.classList.contains('-translate-x-full') && !sidebar.contains(event.target)) {
        sidebar.classList.add('-translate-x-full');
      }
    }
  </script>
</body>
</html>