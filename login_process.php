<?php
session_start();
include('config/db_connect.php');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'doctor') {
                header("Location: doctor_dashboard.php");
            } elseif ($user['role'] === 'patient') {
                header("Location: patient_dashboard.php");
            } else {
                header("Location: admin_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with that username.'); window.location='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>login - Medicare Plus</title>
</head>
<body>
  <h2>Login to Medicare Plus</h2>
  <form action="login_process.php" method="POST">

    <label>Username:</label>
    <input type="text" name="username" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>


    <button type="submit" name="login">Log In</button>

  </form>

</body>
</html>