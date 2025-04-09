<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["btn_register"])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Basic encryption (use bcrypt in real applications)
        $user_type = $_POST['user_type'];

        // check email already exists in the database
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_query);
    
        if (mysqli_num_rows($result) > 0) {
            // Email already exists — show alert
            echo "<script>
                    alert('Email is already registered! Please use another one.');
                    window.location.href = 'register.html';
                  </script>";
        }
        else{
            $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                    alert('Registration successful!');
                    window.location.href = 'login.html';
                  </script>";
            } 
            else {
                echo "<script>
                alert('Something went wrong. Please try again.');
                window.location.href = 'register.html';
              </script>";
            }

        }
        mysqli_close($conn);
    }
    
}
?>
