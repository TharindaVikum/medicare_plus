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
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // (Optional) basic validation
    if (empty($doctor_id) || empty($appointment_date) || empty($appointment_time)) {
        die("Error: Missing required fields.");
    }

    // Prepare and execute insert safely
    $insert_sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, notes)
                   VALUES (?, ?, ?, ?, ?)";
    $stmt3 = $conn->prepare($insert_sql);
    if (!$stmt3) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt3->bind_param("iisss", $patient_id, $doctor_id, $appointment_date, $appointment_time, $notes);

    if ($stmt3->execute()) {
        // Get the newly created appointment ID
        $new_appointment_id = $conn->insert_id;

        // Define the amount (change this logic if you want per-doctor fees)
        $amount = 2500;

        // Redirect to payment page with appointment id and amount
        header("Location: payment.php?id={$new_appointment_id}&amount={$amount}");
        exit();
    } else {
        echo "Error inserting appointment: " . htmlspecialchars($stmt3->error);
    }

    $stmt3->close();
} else {
    // If someone opened this page directly, send them back
    header("Location: patient_dashboard.php");
    exit();
}
?>
