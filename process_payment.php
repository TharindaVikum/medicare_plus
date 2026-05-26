<?php
session_start();
require_once('config/db_connect.php');

if(!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

$patient_id = $_SESSION['user_id'];
$appointment_id = $_POST['appointment_id'];
$amount = $_POST['amount'];
$card_number = $_POST['card_number'];

$last4 = substr($card_number, -4);

$sql = "INSERT INTO payments (patient_id, appointment_id, amount, payment_method, card_last4)
        VALUES (?, ?, ?, 'Card', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iids", $patient_id, $appointment_id, $amount, $last4);
$stmt->execute();

echo "<script>alert('Payment Successful!'); window.location='patient_dashboard.php';</script>";
