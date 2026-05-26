<?php
session_start();
require_once('config/db_connect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role, specialization, phone) VALUES (?, ?, ?, ?, 'doctor', ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $username, $email, $password, $specialization, $phone);

    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Doctor added successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Doctor | Admin Dashboard</title>
<style>
body { font-family: Arial,sans-serif; background:#f4f7f9; padding:20px; }
form { background:white; padding:20px; border-radius:10px; max-width:500px; margin:auto; }
input { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
button { padding:10px 15px; background:#008080; color:white; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>
<h2>Add New Doctor</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
<input type="text" name="full_name" placeholder="Full Name" required>
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="specialization" placeholder="Specialization" required>
<input type="text" name="phone" placeholder="Phone">
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Add Doctor</button>
</form>
<p><a href="admin_dashboard.php">← Back to Dashboard</a></p>
</body>
</html>
