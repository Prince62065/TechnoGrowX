<?php
include 'config.php';
session_start();

$alertMessage = "";

if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!="farmer") {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    $filename = $_FILES["image"]["name"];
    $filetype = $_FILES["image"]["type"];
    $filesize = $_FILES["image"]["size"];
    $filetmpname = $_FILES["image"]["tmp_name"];
    $fileerror = $_FILES["image"]["error"];
    $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $user_id = $_SESSION['user_id'];
    $crop_type = $_POST['crop_type'];
    $symptoms = $_POST['symptoms'];
    $image_path = "";

    if ($fileerror === 0) {
        if ($filesize < 10000000) {
            if (in_array($fileext, ['jpg', 'jpeg', 'png'])) {
                $newFileName = uniqid("img_", true) . '.' . $fileext;
                $targetPath = "uploads/" . $newFileName;

                if (move_uploaded_file($filetmpname, $targetPath)) {
                    $image_path = $targetPath;

                    $sql = "INSERT INTO disease_reports (user_id, crop_type, symptoms, image_path) 
                            VALUES ('$user_id', '$crop_type', '$symptoms', '$image_path')";

                    if (mysqli_query($conn, $sql)) {
                        $alertMessage = "✅ Report submitted successfully!";
                    } else {
                        $alertMessage = "❌ Database error: " . mysqli_error($conn);
                    }
                } else {
                    $alertMessage = "❌ Failed to move uploaded file.";
                }
            } else {
                $alertMessage = "⚠️ Only JPG, JPEG, and PNG files are allowed.";
            }
        } else {
            $alertMessage = "⚠️ File size too large. Max 10MB allowed.";
        }
    } else {
        $alertMessage = "⚠️ File upload error code: $fileerror";
    }

    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Disease Report</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-green-700 text-white p-4 shadow">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold">Farmers’ Disease Diagnostic Portal</h1>
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Logout</a>
    </div>
  </header>

  <!-- Form Container -->
  <main class="flex-grow container mx-auto px-4 py-10">
    <div class="bg-white p-8 rounded-lg shadow max-w-xl mx-auto">
      <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Submit Disease Report</h2>
      <form action="report.php" method="POST" enctype="multipart/form-data" class="space-y-5">
        <div>
          <label class="block mb-1 font-medium text-gray-700">Crop Type</label>
          <input type="text" name="crop_type" placeholder="e.g. Tomato" required
                 class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Symptoms</label>
          <textarea name="symptoms" rows="4" placeholder="Describe symptoms..." required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
        </div>
        <div>
          <label class="block mb-1 font-medium text-gray-700">Upload Image</label>
          <input type="file" name="image"
                 accept="image/*"
                 class="w-full file:mr-4 file:py-2 file:px-4 file:border-0
                        file:text-sm file:font-semibold file:bg-green-100 file:text-green-700
                        hover:file:bg-green-200 rounded">
        </div>
        <div class="text-center">
          <button type="submit" name="submit"
                  class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition">
            Submit Report
          </button>
        </div>
      </form>
    </div>
  </main>



  <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center py-4">
    <p>&copy; 2025 Farmers' Disease Diagnostic Portal</p>
  </footer>

  <?php if (!empty($alertMessage)): ?>
  <script>
    alert("<?= addslashes($alertMessage); ?>");
    //  reset the form after alert
    window.onload = () => {
      const form = document.querySelector("form");
      if (form) form.reset();
    };
  </script>
<?php endif; ?>

</body>
</html>
