<?php
session_start();
require_once('config/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_SESSION['user_id'];
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $message_text = mysqli_real_escape_string($conn, $_POST['message_text']);

    // Insert only the columns that exist in your table
    $sql = "INSERT INTO messages 
            (sender_id, receiver_id, message, sent_at)
            VALUES
            ('$patient_id', '$doctor_id', '$message_text', NOW())";

    if (mysqli_query($conn, $sql)) {
        header("Location: patient_dashboard.php");
        exit();
    } else {
        die("Error sending message: " . mysqli_error($conn));
    }
} else {
   header("Location: patient_dashboard.php?msg=sent");
exit();

}
?>
