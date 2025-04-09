<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!="expert") {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_solution'])) {
    $report_id = $_POST['report_id'];
    $solution = $_POST['solution'];

    $update_sql = "UPDATE disease_reports SET solution = '$solution' WHERE id = '$report_id'";
    mysqli_query($conn, $update_sql);

    echo "<script>alert('Solution submitted successfully!');</script>";
}

// Fetch all disease reports
$sql = "SELECT dr.id, dr.crop_type, dr.symptoms, dr.image_path, dr.solution, u.name FROM disease_reports dr
        JOIN users u ON dr.user_id = u.id
        ORDER BY dr.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Solutions</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100">

  <!-- Header -->
  <header class="bg-green-700 text-white py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
      <h1 class="text-2xl font-bold">TechnoGrowX</h1>
      <nav class="hidden md:flex space-x-4">
        <a href="#" class="hover:underline">Home</a>
        <a href="#" class="hover:underline">About</a>
        <a href="#" class="hover:underline">Contact</a>
        <a href="login.html" class="hover:underline">Login</a>
        <a href="register.html" class="hover:underline">Register</a>
      </nav>
      <button class="md:hidden text-white" id="menu-btn">☰</button>
    </div>
    <nav class="md:hidden hidden bg-green-700 p-4 space-y-2" id="mobile-menu">
      <a href="#" class="block text-white hover:underline">Home</a>
      <a href="#" class="block text-white hover:underline">About</a>
      <a href="#" class="block text-white hover:underline">Contact</a>
      <a href="login.html" class="block text-white hover:underline">Login</a>
      <a href="register.html" class="block text-white hover:underline">Register</a>
    </nav>
  </header>

  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-green-700 mb-6">Manage Solutions</h1>

    <?php while($row = mysqli_fetch_assoc($result)): 
      $isSubmitted = !empty($row['solution']);
    ?>
      <form method="POST" action="" class="bg-white p-6 rounded shadow-md mb-6" id="solutionForm_<?php echo $row['id']; ?>">
        <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">

        <h2 class="text-xl font-semibold text-gray-800 mb-2">Report by: <?php echo htmlspecialchars($row['name']); ?></h2>
        <p><strong>Crop:</strong> <?php echo htmlspecialchars($row['crop_type']); ?></p>
        <p><strong>Symptoms:</strong> <?php echo htmlspecialchars($row['symptoms']); ?></p>

        <?php if (!empty($row['image_path'])): ?>
          <div class="my-4">
            <img src="<?php echo $row['image_path']; ?>" alt="Reported Issue" class="w-64 h-40 object-cover rounded border">
          </div>
        <?php endif; ?>

        <label class="block mt-4 mb-2 font-medium text-gray-700">Solution:</label>
        <textarea name="solution" id="solutionTextarea_<?php echo $row['id']; ?>" rows="4"
          class="w-full p-3 border border-gray-300 rounded disabled:bg-gray-100"
          <?php echo $isSubmitted ? 'disabled' : ''; ?>><?php echo htmlspecialchars($row['solution']); ?></textarea>

        <div class="mt-4 flex gap-4">
          <button type="submit" name="submit_solution"
            id="submitBtn_<?php echo $row['id']; ?>"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded <?php echo $isSubmitted ? 'hidden' : ''; ?>">
            Submit
          </button>

          <button type="button" onclick="enableEdit('<?php echo $row['id']; ?>')"
            id="editBtn_<?php echo $row['id']; ?>"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded <?php echo !$isSubmitted ? 'hidden' : ''; ?>">
            Edit
          </button>
        </div>
      </form>
    <?php endwhile; ?>
  </div>
  <footer class="bg-gray-800 text-white py-6 mt-auto w-full">
    <div class="container mx-auto text-center">
      <p>&copy; 2025 TechnoGrowX. All rights reserved.</p>
      <div class="mt-4">
        <a href="#" class="mx-2 hover:underline">Privacy Policy</a>
        <a href="#" class="mx-2 hover:underline">Terms of Service</a>
      </div>
      <!-- Social Media Icons -->
      <div class="flex justify-center mt-4 space-x-4">
        <a href="https://facebook.com" target="_blank" class="text-white hover:text-blue-500">
          <i class="fab fa-facebook-f text-xl"></i>
        </a>
        <a href="https://twitter.com" target="_blank" class="text-white hover:text-blue-400">
          <i class="fab fa-twitter text-xl"></i>
        </a>
        <a href="https://instagram.com" target="_blank" class="text-white hover:text-pink-500">
          <i class="fab fa-instagram text-xl"></i>
        </a>
        <a href="https://linkedin.com" target="_blank" class="text-white hover:text-blue-600">
          <i class="fab fa-linkedin-in text-xl"></i>
        </a>
        <a href="https://youtube.com" target="_blank" class="text-white hover:text-red-500">
          <i class="fab fa-youtube text-xl"></i>
        </a>
      </div>
    </div>
  </footer>

  <script>
        // Mobile Menu Toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    function enableEdit(id) {
      const textarea = document.getElementById('solutionTextarea_' + id);
      const submitBtn = document.getElementById('submitBtn_' + id);
      const editBtn = document.getElementById('editBtn_' + id);

      textarea.disabled = false;
      submitBtn.classList.remove('hidden');
      editBtn.classList.add('hidden');
    }
  </script>
</body>
</html>
