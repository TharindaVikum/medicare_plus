<?php
session_start();
require_once('config/db_connect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) exit('User ID required');

$id = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id='$id'"));

if (!$user) exit('User not found');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : null;
    $password_sql = '';
    $params = [];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_sql = ", password=?";
        $params[] = $password;
    }

    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=? $password_sql" . ($user['role']=='doctor'?", specialization=?":"") . " WHERE user_id=?");

    if ($user['role']=='doctor') {
        $params = array_merge([$full_name, $email, $phone], $params, [$specialization, $id]);
        $stmt->bind_param(str_repeat('s', count($params)-1).'i', ...$params);
    } else {
        $params = array_merge([$full_name, $email, $phone], $params, [$id]);
        $stmt->bind_param(str_repeat('s', count($params)-1).'i', ...$params);
    }

    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "User updated successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = $stmt->error;
    }
}
?>
