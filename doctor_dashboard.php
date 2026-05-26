<?php
session_start();
require_once('config/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_name = $_SESSION['full_name'];

// Fetch all patients
$patients_query = "SELECT user_id, full_name, email, phone FROM users WHERE role='patient'";
$patients_result = mysqli_query($conn, $patients_query);

// Fetch feedback for this doctor
$doctor_id = $_SESSION['user_id'];

$feedback_sql = "
    SELECT f.rating, f.comment, f.created_at, u.full_name AS patient_name
    FROM feedback f
    JOIN patients p ON f.patient_id = p.patient_id
    JOIN users u ON p.user_id = u.user_id
    WHERE f.doctor_id = ?
    ORDER BY f.created_at DESC
";

$stmt = $conn->prepare($feedback_sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$feedback_result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Dashboard | MediCare+</title>
<link rel="stylesheet" href="style.css">
<style>
body {
  font-family: 'Poppins', sans-serif;
  background-color: #f7f9fb;
  color: #333;
  margin: 0;
  padding: 0;
}
header {
  background-color: #008080;
  color: white;
  padding: 15px 25px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
nav a {
  color: white;
  margin-left: 20px;
  text-decoration: none;
  font-weight: 500;
}
.container {
  padding: 40px;
}
h1, h3 {
  color: #008080;
}
.card {
  background: white;
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  margin-bottom: 25px;
}
button, .btn {
  background-color: #008080;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
}
table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  margin-top: 30px;
}
th, td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
}
th {
  background-color: #008080;
  color: white;
}
tr:hover {
  background-color: #f1f1f1;
}
</style>
</head>
<body>
<header>
  <h2>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></h2>
  <nav>
    <a href="doctor_dashboard.php">Dashboard</a>
    <a href="view_lab_results.php">View Lab Reports</a>
    <a href="update_lab_reports.php">Update Reports</a>
    <a href="view_messages.php">Messages</a>
    <a href="login.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h1>Doctor Dashboard</h1>

  <!-- Feature cards -->
  <div class="card">
    <h3>🧾 View Patient Lab Reports</h3>
    <p>Check and manage the reports submitted by lab staff.</p>
    <a href="view_lab_results.php"><button>View Reports</button></a>
  </div>

  <div class="card">
    <h3>📈 Update Patient Reports</h3>
    <p>Upload or update patient diagnosis and lab results.</p>
    <a href="update_lab_reports.php"><button>Update Reports</button></a>
  </div>

  <div class="card">
    <h3>💬 Messages from Patients</h3>
    <p>Read messages or inquiries from your patients.</p>
    <a href="view_messages.php"><button>View Messages</button></a>
  </div>

  <!-- Patients Table -->
  <h2>👥 All Patients</h2>
  <?php if(mysqli_num_rows($patients_result) > 0): ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Action</th>
    </tr>
    <?php while($patient = mysqli_fetch_assoc($patients_result)): ?>
    <tr>
      <td><?php echo $patient['user_id']; ?></td>
      <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
      <td><?php echo htmlspecialchars($patient['email']); ?></td>
      <td><?php echo htmlspecialchars($patient['phone']); ?></td>
      <td>
        <a class="btn" href="view_lab_results.php?id=<?php echo $patient['user_id']; ?>">View Reports</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  <?php else: ?>
    <p>No patients found.</p>
  <?php endif; ?>
  <h2>⭐ Patient Feedback</h2>
<?php if ($feedback_result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Patient</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $feedback_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($row['rating']); ?></td>
            <td><?php echo htmlspecialchars($row['comment']); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No feedback found.</p>
<?php endif; 

// Fetch appointments made for this doctor
$appointments_sql = "
    SELECT a.*, u.full_name AS patient_name, u.email AS patient_email
    FROM appointments a
    JOIN users u ON a.patient_id = u.user_id
    WHERE a.doctor_id = ?
    ORDER BY a.appointment_date DESC, a.appointment_time ASC
";

$stmt2 = $conn->prepare($appointments_sql);
$stmt2->bind_param("i", $doctor_id);
$stmt2->execute();
$appointments_result = $stmt2->get_result();
?>
<h2>📅 Appointments Booked by Patients</h2>
<?php if($appointments_result->num_rows > 0): ?>
<table>
<tr>
    <th>ID</th>
    <th>Patient</th>
    <th>Email</th>
    <th>Date</th>
    <th>Time</th>
    <th>Notes</th>
</tr>
<?php while($appt = $appointments_result->fetch_assoc()): ?>
<tr>
    <td><?php echo $appt['appointment_id']; ?></td>
    <td><?php echo htmlspecialchars($appt['patient_name']); ?></td>
    <td><?php echo htmlspecialchars($appt['patient_email']); ?></td>
    <td><?php echo $appt['appointment_date']; ?></td>
    <td><?php echo $appt['appointment_time']; ?></td>
    <td><?php echo htmlspecialchars($appt['notes']); ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No appointments booked yet.</p>
<?php endif; 

// Fetch messages sent to this doctor by patients
$messages_sql = "
    SELECT m.*, u.full_name AS patient_name
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    WHERE m.receiver_id = ?
    ORDER BY m.sent_at DESC
";

$stmt3 = $conn->prepare($messages_sql);
$stmt3->bind_param("i", $doctor_id);
$stmt3->execute();
$messages_result = $stmt3->get_result();
?>
<!--
<h2>💬 Messages from Patients</h2>
<?php if($messages_result->num_rows > 0): ?>
<table>
<tr>
    <th>Patient</th>
    <th>Message</th>
    <th>Sent At</th>
</tr>
<?php while($msg = $messages_result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($msg['patient_name']); ?></td>
    <td><?php echo htmlspecialchars($msg['message']); ?></td>
    <td><?php echo $msg['sent_at']; ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No messages from patients yet.</p>-->
<?php endif; ?>





</div>
</body>
</html>
