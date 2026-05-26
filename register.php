<?php
include('config/db_connect.php');

if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization'] ?? '');

    // Check if username exists
    $check = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $check);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username already exists!'); window.location='register.php';</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into users table
    $sql_user = "INSERT INTO users (full_name, username, email, phone, password, role, specialization)
                 VALUES ('$full_name', '$username', '$email', '$phone', '$hashed_password', '$role', '$specialization')";

    if (mysqli_query($conn, $sql_user)) {
        // If role is patient, also insert into patients table
        if ($role === 'patient') {
            // Generate a simple patient_id (you can adjust as needed)
            $patient_id = 'PAT' . time();
            $sql_patient = "INSERT INTO patients (patient_id, full_name, phone, email)
                            VALUES ('$patient_id', '$full_name', '$phone', '$email')";
            if (!mysqli_query($conn, $sql_patient)) {
                echo "Error inserting into patients table: " . mysqli_error($conn);
                exit();
            }
        }

        echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Medicare Plus</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #e6f7f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
      width: 400px;
    }
    h2 {
      text-align: center;
      color: #008080;
    }
    label {
      display: block;
      margin-top: 10px;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .btn {
      background-color: #008080;
      color: white;
      border: none;
      width: 100%;
      padding: 10px;
      margin-top: 15px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    .btn:hover {
      background-color: #006666;
    }
  </style>
  <script>
    function toggleSpecialization() {
      var role = document.getElementById('role').value;
      var specializationField = document.getElementById('specialization-field');
      if (role === 'doctor') {
        specializationField.style.display = 'block';
      } else {
        specializationField.style.display = 'none';
      }
    }
  </script>
</head>
<body>
  <div class="register-box">
    <h2>Register</h2>
    <form action="register.php" method="POST">
      <label>Full Name:</label>
      <input type="text" name="full_name" required>

      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Email:</label>
      <input type="email" name="email" required>

      <label>Phone:</label>
      <input type="text" name="phone" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <label>Register As:</label>
      <select name="role" id="role" onchange="toggleSpecialization()" required>
        <option value="">-- Select Role --</option>
        <option value="patient">Patient</option>
        <option value="doctor">Doctor</option>
      </select>

      <div id="specialization-field" style="display:none;">
        <label>Specialization:</label>
        <input type="text" name="specialization" placeholder="e.g., Cardiologist, Dentist">
      </div>

      <button type="submit" name="register" class="btn">Register</button>
    </form>
  </div>
</body>
</html>
