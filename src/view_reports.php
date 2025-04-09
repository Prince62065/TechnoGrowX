<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!="farmer") {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM disease_reports WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <h2 class="text-3xl text-green-700 font-bold mb-4">My Disease Reports</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <div class="bg-white p-4 rounded shadow">
        <h3 class="text-xl font-semibold"><?= htmlspecialchars($row['crop_type']) ?></h3>
        <p class="text-gray-600 mb-1"><strong>Symptoms:</strong> <?= htmlspecialchars($row['symptoms']) ?></p>
        <?php if ($row['image_path']) : ?>
          <img src="<?= $row['image_path'] ?>" class="w-full h-48 object-cover rounded mb-2" />
        <?php endif; ?>
        <p class="text-gray-500 text-sm mb-2">Submitted: <?= date("F j, Y", strtotime($row['created_at'])) ?></p>
        <p class="text-green-700 font-medium">Solution: <?= $row['solution'] ?: 'Pending...' ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
