<?php
session_start();
require_once('config/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_POST['doctor_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// STEP 1: Get the real patient_id from the patients table
$user_id = $_SESSION['user_id'];

$query = "SELECT patient_id FROM patients WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Patient ID not found for this user!");
}

$row = $result->fetch_assoc();
$patient_id = $row['patient_id']; // This is the correct foreign key value



// STEP 2: Insert feedback
$sql = "INSERT INTO feedback (doctor_id, patient_id, rating, comment)
        VALUES (?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("iiis", $doctor_id, $patient_id, $rating, $comment);



if ($stmt2->execute()) {
    echo "<script>alert('Feedback submitted!'); window.location.href='patient_dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
