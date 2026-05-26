<?php
session_start();
require_once('config/db_connect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['id'])) exit('User ID required');

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM users WHERE user_id='$id'");
$_SESSION['flash_message'] = "User deleted successfully!";
header("Location: admin_dashboard.php");
exit();
