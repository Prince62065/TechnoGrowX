<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!="expert") {
    header("Location: login.php");
    exit();
}

// Fetch all reports
$sql = "SELECT disease_reports.id AS report_id, users.name, crop_type, symptoms, image_path, disease_reports.created_at 
        FROM disease_reports 
        JOIN users ON disease_reports.user_id = users.id
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <h2 class="text-3xl font-bold text-green-700 mb-6">Submitted Reports</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border rounded shadow">
      <thead class="bg-green-600 text-white">
        <tr>
          <th class="px-4 py-2">Farmer</th>
          <th class="px-4 py-2">Crop Type</th>
          <th class="px-4 py-2">Symptoms</th>
          <th class="px-4 py-2">Image</th>
          <th class="px-4 py-2">Submitted At</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr class="text-center border-t">
            <td class="p-2"><?= $row['name'] ?></td>
            <td class="p-2"><?= $row['crop_type'] ?></td>
            <td class="p-2"><?= $row['symptoms'] ?></td>
            <td class="p-2">
              <?php if ($row['image_path']): ?>
                <a href="<?= $row['image_path'] ?>" target="_blank" class="text-blue-600 underline">View</a>
              <?php else: ?>
                No image
              <?php endif; ?>
            </td>
            <td class="p-2"><?= $row['created_at'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
