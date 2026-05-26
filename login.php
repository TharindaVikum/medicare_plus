<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config/db_connect.php');


// ---------------- LOGIN PROCESS ----------------
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

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


// ---------------- REGISTER PROCESS ----------------
if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password_plain = mysqli_real_escape_string($conn, $_POST['password']);
    $password = password_hash($password_plain, PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $specialization = ($role === 'doctor') ? mysqli_real_escape_string($conn, $_POST['specialization']) : NULL;

    // ✅ Check for duplicates
    $check_sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username or email already exists. Please choose another.'); window.location='login.php';</script>";
        exit();
    }

    // Insert into users table first
    $insert_user = "INSERT INTO users (full_name, username, email, phone, password, role, specialization)
                    VALUES ('$fullname', '$username', '$email', '$phone', '$password', '$role', ".($specialization ? "'$specialization'" : "NULL").")";

    if (mysqli_query($conn, $insert_user)) {
        $user_id = mysqli_insert_id($conn);

        if ($role === 'doctor') {
            mysqli_query($conn, "INSERT INTO doctors (user_id, specialization) VALUES ($user_id, '$specialization')");
        } elseif ($role === 'patient') {
            mysqli_query($conn, "INSERT INTO patients (user_id, phone) VALUES ($user_id, '$phone')");
        }

        echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Registration failed: " . mysqli_error($conn) . "');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login / Register | Medicare Plus</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    * { box-sizing: border-box; }
    body {
      background: #f6f5f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }
    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                  0 10px 10px rgba(0,0,0,0.22);
      position: relative;
      overflow: hidden;
      width: 850px;
      max-width: 100%;
      min-height: 500px;
      transition: all 0.6s ease-in-out;
    }
    .form-container { 
      position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; 
    }
    .sign-in-container { 
      left: 0; width: 50%; z-index: 2; 
    }
    .container.right-panel-active .sign-in-container { 
      transform: translateX(100%); 
    }
    .sign-up-container { 
      left: 0; width: 50%; opacity: 0; z-index: 1; 
    }
    .container.right-panel-active .sign-up-container { 
      transform: translateX(100%); opacity: 1; z-index: 5; 
    }
    form { 
      background-color: #ffffff; 
      display: flex; 
      flex-direction: column; 
      align-items: center; 
      justify-content: center; 
      padding: 0 50px; 
      height: 100%; 
      text-align: center; 
    }
    form h1 { 
      font-weight: bold; 
      margin-bottom: 20px; 
      font-size: 20px;
    }
    form input { 
      background-color: #eee; 
      border: none; 
      padding: 12px 15px; 
      margin: 8px 0; 
      width: 100%; 
      border-radius: 5px; 
    }
    button { 
    border-radius: 20px; 
    border: 1px solid #0b5ed7; 
    background-color: #0b5ed7; 
    color: #fff; 
    font-size: 14px; 
    font-weight: bold; 
    padding: 12px 45px; 
    letter-spacing: 1px; 
    text-transform: uppercase; 
    transition: transform 80ms ease-in; 
    cursor: pointer; }
    button:active { 
      transform: scale(0.95); 
    }
    button.ghost { 
      background-color: transparent; border-color: #fff; 
    }
    .overlay-container { 
      position: absolute; 
      top: 0; left: 50%; 
      width: 50%; 
      height: 100%; 
      overflow: hidden; 
      transition: transform 0.6s ease-in-out; 
      z-index: 100; }
    .container.right-panel-active .overlay-container { 
      transform: translateX(-100%); 
    }
    .overlay { 
      background: linear-gradient(to right, #0062ff, #0048b1); 
      background-repeat: no-repeat; 
      background-size: cover; 
      background-position: center; 
      color: #ffffff; 
      position: relative; left: -100%; 
      height: 100%; width: 200%; 
      transform: translateX(0); 
      transition: transform 0.6s ease-in-out; 
    }
    .container.right-panel-active .overlay { 
      transform: translateX(50%); 
    }
    .overlay-panel { 
      position: absolute; 
      display: flex; 
      flex-direction: column; 
      align-items: center; 
      justify-content: center; 
      padding: 0 40px; 
      text-align: center; 
      top: 0; 
      height: 100%; 
      width: 50%; 
      transform: translateX(0); 
      transition: transform 0.6s ease-in-out; 
    }
    .overlay-left { 
      transform: translateX(-20%); 
    }
    .container.right-panel-active .overlay-left { 
      transform: translateX(0); 
    }
    .overlay-right { 
      right: 0; transform: translateX(0); 
    }
    .container.right-panel-active .overlay-right { 
      transform: translateX(20%); 
    }
    .fade {
  opacity: 0;
  transition: opacity 0.4s ease;
}
.fade.show {
  opacity: 1;
}

  </style>
</head>
<body>
  <div class="container" id="container">
  <!-- REGISTER FORM -->
<div class="form-container sign-up-container">
  <form method="POST" action="">
    <h1>Create Account</h1>
    <input type="text" name="fullname" placeholder="Full Name" required />
    <input type="text" name="username" placeholder="Username" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="tel" name="phone" placeholder="Phone Number" required />


    <select name="role" id="role" required onchange="toggleSpecialization()" 
      style="background-color: #eee; border: none; padding: 12px 15px; margin: 8px 0; width: 100%; border-radius: 5px;">
<option value="">Select Role</option>
    <option value="patient">Patient</option>
    <option value="doctor">Doctor</option>
    <option value="admin">Admin</option>
    </select>
  


    <div id="specializationField" class="fade" style="display: none; width: 100%;">
      <input type="text" name="specialization" placeholder="Specialization (if doctor)" 
        style="background-color: #eee; border: none; padding: 12px 15px; margin: 8px 0; width: 100%; border-radius: 5px;" />
    </div>

    <button type="submit" name="register">Register</button>
  </form>
</div>



  <!-- LOGIN FORM -->
  <div class="form-container sign-in-container">
    <form method="POST" action="">
      <h1>Login Please</h1>
      <input type="text" name="username" placeholder="Email or Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
    </form>
  </div>

  <!-- OVERLAY PANELS -->
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h1>Welcome Back!</h1>
        <p>To keep connected with us please login with your personal info</p>
        <button class="ghost" id="signIn">Login</button>
      </div>
      <div class="overlay-panel overlay-right">
        <h1>Hello, Friend!</h1>
        <p>Enter your personal details and start your journey with us</p>
        <button class="ghost" id="signUp">Register</button>
      </div>
    </div>
  </div>
</div>


  <script>
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');

  signUpButton.addEventListener('click', () => {
    container.classList.add('right-panel-active');
  });

  signInButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
  });

  // --- Role-based specialization toggle ---
  function toggleSpecialization() {
    const roleSelect = document.getElementById('role');
    const specializationField = document.getElementById('specializationField');
    if (roleSelect.value === 'doctor') {
      specializationField.style.display = 'block';
      setTimeout(() => specializationField.classList.add('show'), 10);
    } else {
      specializationField.classList.remove('show');
      setTimeout(() => specializationField.style.display = 'none', 400);
    }
  }



</script>

</body>
</html>
