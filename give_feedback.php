<?php
session_start();
require_once('config/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: give_feedback.php");
    exit();
}

$patient_id = $_SESSION['user_id'];
$doctor_id = $_GET['doctor_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Give Feedback</title>
<style>
body { font-family: Poppins; background:#f7f9fb; padding:40px; }
form {
    align-items: center;
    background:white; padding:25px; border-radius:12px; width:400px;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
}
label { font-weight:600; margin-top:10px; display:block; }
button { background:#008080; color: #1dc9c9c6; border:none; padding:10px 15px; border-radius:6px; cursor:pointer; }
</style>
</head>
<body>

<h2>Give Feedback to Your Doctor</h2>

<form action="submit_feedback.php" method="POST">
    <input type="hidden" name="doctor_id" value="<?php echo $_GET['doctor_id']; ?>">
    
    <label>Rating</label>
    <select name="rating" required>
        <option value="1">1 - Poor</option>
        <option value="2">2</option>
        <option value="3">3 - Average</option>
        <option value="4">4</option>
        <option value="5">5 - Excellent</option>
    </select>

    <label>Comment</label>
    <textarea name="comment"></textarea>

    <button type="submit">Submit Feedback</button>
</form>


</body>
</html>
