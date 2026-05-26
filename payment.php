<?php
session_start();
require_once('config/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Check if appointment id exists in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Appointment ID missing!");
}
$appointment_id = intval($_GET['id']);
$amount = isset($_GET['amount']) ? intval($_GET['amount']) : 2500;
?>


<!DOCTYPE html>
<html>
<head>
<title>Payment Portal</title>
<style>
body { font-family:Poppins; background: #3f87ada8; }
.container {
    width:400px; margin:50px auto; background:white; padding:25px;
    border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1);
}
input, select {
    width:100%; padding:10px; margin:7px 0; border-radius:6px;
    border:1px solid #ccc;
}
button {
    width:100%; padding:12px; background:#28a745; color:white;
    border:none; border-radius:6px; cursor:pointer;
}
</style>
</head>
<body>

<div class="container">
<h2>Payment Portal</h2>
<p>Appointment ID: <?php echo $appointment_id; ?></p>
<p>Amount: Rs. <?php echo $amount; ?></p>

<form method="POST" action="process_payment.php">
    <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
    <input type="hidden" name="amount" value="<?php echo $amount; ?>">

    <label>Card Number</label>
    <input type="text" name="card_number" required>

    <label>Expiry</label>
    <input type="text" name="expiry" placeholder="MM/YY" required>

    <label>CVV</label>
    <input type="password" name="cvv" required>

    <button type="submit">Pay Now</button>
</form>
</div>

</body>
</html>
