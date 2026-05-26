<?php
session_start();
include 'config/db_connect.php';

// Only allow doctors
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['full_name'];
$message = "";

// Fetch patients for dropdown from users table
$patients_result = mysqli_query($conn, "SELECT user_id, full_name FROM users WHERE role='patient' ORDER BY full_name ASC");

// Insert into lab_reports
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
    $test_type = mysqli_real_escape_string($conn, $_POST['test_type']);
    $report_date = mysqli_real_escape_string($conn, $_POST['report_date']);
    $results = mysqli_real_escape_string($conn, $_POST['results']);
    $doctor_comments = mysqli_real_escape_string($conn, $_POST['doctor_comments']);

    // Get patient name
    $patient_query = mysqli_query($conn, "SELECT full_name FROM users WHERE user_id='$patient_id'");
    $patient_row = mysqli_fetch_assoc($patient_query);
    $patient_name = $patient_row['full_name'] ?? 'Unknown';

    // File upload handling
$file_path = "";

if (isset($_FILES['report_file']) && $_FILES['report_file']['error'] === 0) {
    $uploadDir = "uploads/";
    $fileName = time() . "_" . basename($_FILES["report_file"]["name"]); // unique name
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["report_file"]["tmp_name"], $targetPath)) {
        $file_path = $targetPath;
    }
}
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}



    $insert_query = "
        INSERT INTO lab_reports 
        (patient_id, patient_name, doctor_id, test_type, report_date, results, doctor_comments, file_path)
        VALUES ('$patient_id', '$patient_name', '$doctor_id', '$test_type', '$report_date', '$results', '$doctor_comments', '$file_path')
    ";

    if (!mysqli_query($conn, $insert_query)) {
        die("Error inserting report: " . mysqli_error($conn));
    } else {
        echo "Lab report added successfully!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Lab Report</title>
<style>
body { font-family: 'Poppins', sans-serif; background:#f4f7f9; margin:0; color:#333; }
header { background:#008080; color:white; padding:15px 25px; display:flex; justify-content:space-between; align-items:center; }
nav a { color:white; margin-left:20px; text-decoration:none; font-weight:500; }
.container { max-width:700px; margin:40px auto; padding:30px; background:white; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); }
input, textarea, select { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:6px; }
button { background:#008080; color:white; border:none; padding:10px 20px; border-radius:6px; cursor:pointer; font-weight:500; }
.message { font-weight:bold; margin-bottom:15px; color:green; }
</style>
</head>
<body>
<header>
    <h2>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></h2>
    <nav>
        <a href="doctor_dashboard.php">Dashboard</a>
        <a href="view_lab_reports.php">View Reports</a>
        <a href="update_lab_reports.php">Add Reports</a>
        <a href="view_messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
<h1>🩺 Add New Lab Report</h1>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Patient:</label>
    <select name="patient_id" required>
        <option value="">-- Select Patient --</option>
        <?php
        mysqli_data_seek($patients_result, 0); // reset pointer
        while ($p = mysqli_fetch_assoc($patients_result)): ?>
            <option value="<?php echo $p['user_id']; ?>"><?php echo htmlspecialchars($p['full_name']); ?></option>
        <?php endwhile; ?>
    </select>

    <label>Test Type:</label>
    <input type="text" name="test_type" required>

    <label>Report Date:</label>
    <input type="date" name="report_date" required>

    <label>Results:</label>
    <textarea name="results" rows="4" required></textarea>

    <label>Doctor Comments:</label>
    <textarea name="doctor_comments" rows="3"></textarea>

    <label>Attach Report File (optional):</label>
    <input type="file" name="report_file" accept=".pdf,.jpg,.jpeg,.png">
    

    <button type="submit">Submit Report</button>
</form>
</div>
</body>
</html>
