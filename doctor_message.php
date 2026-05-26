<?php
session_start();
require_once('config/db_connect.php');

// Check if the user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['full_name'];

// Fetch all messages between this doctor and patients (both directions)
$messages_query = "
    SELECT 
        m.*, 
        CASE 
            WHEN m.sender_role = 'patient' THEN u.full_name 
            ELSE 'You' 
        END AS sender_name
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    WHERE 
        (m.sender_id = '$doctor_id' AND m.sender_role = 'doctor')
        OR (m.receiver_id = '$doctor_id' AND m.receiver_role = 'doctor')
    ORDER BY m.sent_at DESC
";

$messages_result = mysqli_query($conn, $messages_query);

if (!$messages_result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages | Doctor Dashboard</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background:#f4f7f9; padding:20px; }
        h1 { color:#008080; }
        .message-box { background:white; border-radius:10px; padding:15px; margin-bottom:12px; box-shadow:0 3px 6px rgba(0,0,0,0.1); }
        .from-patient { border-left:5px solid #008080; }
        .from-you { border-left:5px solid #999; background:#f8f8f8; }
        .meta { font-size:13px; color:#666; margin-bottom:5px; }
        textarea { width:100%; padding:8px; border:1px solid #ccc; border-radius:5px; margin-top:8px; resize:none; }
        button { background:#008080; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; margin-top:5px; }
        button:hover { background:#006666; }
        a { color:#008080; text-decoration:none; }
    </style>
</head>
<body>

<h1>💬 Patient–Doctor Messages</h1>
<p>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></p>

<?php if(mysqli_num_rows($messages_result) > 0): ?>
    <?php while($msg = mysqli_fetch_assoc($messages_result)): ?>
        <div class="message-box <?php echo $msg['sender_role'] === 'patient' ? 'from-patient' : 'from-you'; ?>">
            <div class="meta">
                <strong><?php echo htmlspecialchars($msg['sender_name']); ?></strong> 
                <em>(<?php echo ucfirst($msg['sender_role']); ?>)</em> 
                • <?php echo $msg['sent_at']; ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>

            <?php if($msg['sender_role'] === 'patient'): ?>
                <!-- Reply form appears under patient messages -->
                <form method="POST" action="send_reply.php">
                    <input type="hidden" name="receiver_id" value="<?php echo $msg['sender_id']; ?>">
                    <input type="hidden" name="receiver_role" value="patient">
                    <textarea name="message_text" rows="2" placeholder="Reply to patient..." required></textarea>
                    <button type="submit">Send Reply</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No messages yet.</p>
<?php endif; ?>

<p><a href="doctor_dashboard.php">← Back to Dashboard</a></p>

</body>
</html>
