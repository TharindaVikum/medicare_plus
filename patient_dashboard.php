<?php
session_start();
require_once('config/db_connect.php'); // connect to DB

// Redirect if not logged in or not a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Get patient details from session
$patient_id = $_SESSION['user_id'];
$patient_name = $_SESSION['full_name'];

// Prefill doctor if provided via GET (optional)
$prefill_doctor = isset($_GET['prefill_doctor']) ? $_GET['prefill_doctor'] : '';

// Fetch doctors for dropdown
$doctors_query = "SELECT user_id, full_name, email FROM users WHERE role='doctor'";
$doctors_result = mysqli_query($conn, $doctors_query);

// Fetch Lab Reports
$lab_reports_query = "SELECT * FROM lab_reports WHERE patient_id='$patient_id' ORDER BY report_date DESC";
$lab_reports_result = mysqli_query($conn, $lab_reports_query);

// Fetch Appointments
$appointments_query = "SELECT a.*, d.full_name AS doctor_name
                       FROM appointments a
                       JOIN users d ON a.doctor_id = d.user_id
                       WHERE a.patient_id='$patient_id'
                       ORDER BY a.appointment_date DESC";
$appointments_result = mysqli_query($conn, $appointments_query);

// Fetch Messages
$messages_query = "SELECT m.*, d.full_name AS sender_name
                   FROM messages m
                   JOIN users d ON m.sender_id = d.user_id
                   WHERE m.receiver_id='$patient_id'
                   ORDER BY m.sent_at DESC";
$messages_result = mysqli_query($conn, $messages_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Patient Dashboard | Medicare Plus</title>
<style>
body { font-family: 'Poppins', sans-serif; background: #f4f7f9; margin:0; }
header { background:#008080; color:white; padding:15px 25px; display:flex; justify-content:space-between; align-items:center; }
nav a { color:white; margin-left:20px; text-decoration:none; font-weight:500; }
.container { padding:40px; max-width:1000px; margin:auto; }
table { width:100%; border-collapse:collapse; background:white; margin-bottom:30px; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#008080; color:white; }
.btn { padding:8px 12px; border:none; border-radius:6px; background:#008080; color:white; text-decoration:none; cursor:pointer; }
form { background:white; padding:20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); margin-bottom:30px; }
input, select, textarea { width:100%; padding:10px; margin:5px 0 15px; border-radius:5px; border:1px solid #ccc; }
.scroll-btns { margin-bottom:20px; }
.scroll-btns button { margin-right:10px; }
</style>
</head>
<body>

<header>
    <h2>Welcome, <?php echo htmlspecialchars($patient_name); ?></h2>
    <nav>
        <a href="view_lab_results.php">Lab Reports</a>
        <a href="#appointments">Appointments</a>
        <a href="view_messages.php">Messages</a>
        <a href="login.php">Logout</a>
    </nav>
</header>

<div class="container">



<!-- Lab Reports Section -->
<h1 id="lab-reports">🧾 Your Lab Reports</h1>
<?php if(mysqli_num_rows($lab_reports_result) > 0): ?>
<table>
<tr><th>ID</th><th>Test Type</th><th>Report Date</th><th>Results</th><th>Doctor Comments</th><th>File</th></tr>
<?php while($row = mysqli_fetch_assoc($lab_reports_result)): ?>
<tr>
    <td><?php echo $row['report_id']; ?></td>
    <td><?php echo htmlspecialchars($row['test_type']); ?></td>
    <td><?php echo $row['report_date']; ?></td>
    <td><?php echo htmlspecialchars($row['results']); ?></td>
    <td><?php echo htmlspecialchars($row['doctor_comments']); ?></td>
    <td>
        <?php if(!empty($row['file_path'])): ?>
            <a class="btn" href="<?php echo htmlspecialchars($row['file_path']); ?>" download>Download</a>
        <?php else: ?>No file<?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No lab reports found.</p>
<?php endif; ?>


<!-- Book New Appointment Form -->
<h1>📅 Book a New Appointment</h1>
<form method="POST" action="book_appointment.php">
    <label for="doctor_id">Choose Doctor</label>
    <select name="doctor_id" id="doctor_id" required>
        <?php
        mysqli_data_seek($doctors_result, 0); // reset doctors result pointer
        while ($doctor = mysqli_fetch_assoc($doctors_result)) {
            $selected = ($doctor['user_id'] == $prefill_doctor) ? 'selected' : '';
            echo '<option value="'.$doctor['user_id'].'" '.$selected.'>'.htmlspecialchars($doctor['full_name']).'</option>';
        }
        ?>
    </select>

    <label for="appointment_date">Date</label>
    <input type="date" name="appointment_date" id="appointment_date" required>

    <label for="appointment_time">Time</label>
    <input type="time" name="appointment_time" id="appointment_time" required>

    <label for="notes">Notes (optional)</label>
    <textarea name="notes" id="notes" rows="3"></textarea>

    <button type="submit" class="btn">Book Appointment</button>
</form>

<!-- Appointments Section -->
<h1 id="appointments">📅 Your Appointments</h1>
<?php if(mysqli_num_rows($appointments_result) > 0): ?>
<table>
<tr><th>ID</th><th>Doctor</th><th>Date</th><th>Time</th><th>Notes</th><th>Action</th></tr>
<?php while($appt = mysqli_fetch_assoc($appointments_result)): ?>
<tr>
<td><?php echo $appt['appointment_id']; ?></td>
<td><?php echo htmlspecialchars($appt['doctor_name']); ?></td>
<td><?php echo $appt['appointment_date']; ?></td>
<td><?php echo $appt['appointment_time']; ?></td>
<td><?php echo htmlspecialchars($appt['notes']); ?></td>
<td>
   

    <!-- Delete Appointment Button -->
    <a class="btn" href="delete_appointment.php?id=<?php echo $appt['appointment_id']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete Appointment</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No appointments booked.</p>
<?php endif; ?>

<!-- Contact Doctors Section -->
<h2>👨‍⚕️ Contact a Doctor</h2>
<table>
<tr><th>Doctor</th><th>Email</th><th>Action</th></tr>
<?php
mysqli_data_seek($doctors_result, 0); // reset result pointer
while ($doc = mysqli_fetch_assoc($doctors_result)) { ?>
<tr>
<td><?php echo htmlspecialchars($doc['full_name']); ?></td>
<td><?php echo htmlspecialchars($doc['email']); ?></td>
<td>
    <!-- Send Message Form -->
    <form method="POST" action="send_message.php" style="display:inline-block; margin-bottom:5px;">
        <input type="hidden" name="doctor_id" value="<?php echo $doc['user_id']; ?>">
        <input type="text" name="message_text" placeholder="Type your message..." required style="width:200px; padding:5px; margin-right:5px;">
        <button type="submit" class="btn">Send Message</button>
    </form>

    <!-- Give Feedback Button -->
    <a class="btn" href="give_feedback.php?doctor_id=<?php echo $doc['user_id']; ?>" style="margin-left:5px;">Give Feedback</a>
</td>
</tr>
<?php } ?>
</table>

<!-- Messages Section -->
<h1 id="messages">📨 Messages from Doctors</h1>
<?php if(mysqli_num_rows($messages_result) > 0): ?>
<table>
<tr><th>From</th><th>Message</th><th>Sent At</th></tr>
<?php while($msg = mysqli_fetch_assoc($messages_result)): ?>
<tr>
<td><?php echo htmlspecialchars($msg['sender_name']); ?></td>
<td><?php echo htmlspecialchars($msg['message']); ?></td>
<td><?php echo $msg['sent_at']; ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No messages yet.</p>
<?php endif; ?>

</div>
</body>
</html>
