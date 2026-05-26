<?php
session_start();
require_once('config/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['full_name'];

// Handle reply form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_message'], $_POST['patient_id'])) {
    $patient_id = intval($_POST['patient_id']);
    $reply_message = trim($_POST['reply_message']);
    
    if(!empty($reply_message)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $doctor_id, $patient_id, $reply_message);
        $stmt->execute();
        $stmt->close();
        $success = "✅ Reply sent successfully!";
    }
}

// Fetch messages sent to this doctor
$messages_sql = "
    SELECT m.*, u.full_name AS patient_name
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    WHERE m.receiver_id = ?
    ORDER BY m.sent_at DESC
";

$stmt = $conn->prepare($messages_sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$messages_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Messages from Patients | Doctor Dashboard</title>
<style>
body { font-family: Arial,sans-serif; background:#f4f7f9; padding:20px; }
h1 { color:#008080; }
table { width:100%; border-collapse: collapse; background:white; margin-top:20px; }
th, td { padding:10px; border:1px solid #ddd; text-align:left; }
th { background:#008080; color:white; }
tr:nth-child(even) { background:#f2f2f2; }
form { margin-top:10px; }
textarea { width:100%; padding:8px; margin:5px 0; border-radius:5px; border:1px solid #ccc; }
button { background:#008080; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; }
.success { color: green; font-weight:bold; }
</style>
</head>
<body>

<h1>📨 Messages from Patients</h1>
<p>Doctor: <?php echo htmlspecialchars($doctor_name); ?></p>

<?php if(!empty($success)) echo '<p class="success">'.$success.'</p>'; ?>

<?php if($messages_result->num_rows > 0): ?>
<table>
<tr>
    <th>Patient</th>
    <th>Message</th>
    <th>Sent At</th>
    <th>Reply</th>
</tr>
<?php while($msg = $messages_result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($msg['patient_name']); ?></td>
    <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
    <td><?php echo htmlspecialchars($msg['sent_at']); ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="patient_id" value="<?php echo $msg['sender_id']; ?>">
            <textarea name="reply_message" rows="2" placeholder="Type your reply..." required></textarea>
            <button type="submit">Send Reply</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No messages from patients yet.</p>
<?php endif; ?>

<p><a href="doctor_dashboard.php">← Back to Dashboard</a></p>

</body>
</html>
