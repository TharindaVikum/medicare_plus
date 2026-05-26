<?php
session_start();

// Ensure only doctors can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.html");
    exit();
}

include 'config/db_connect.php';

// Get doctor info from session
$doctor_id = $_SESSION['user_id'];
$doctor_name = $_SESSION['full_name'];

// Execute query to fetch lab reports for this doctor
$query = "SELECT * FROM lab_reports WHERE doctor_id = '$doctor_id' ORDER BY report_date DESC";
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("❌ Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Lab Reports | MediCare+</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f9;
      color: #333;
      margin: 0;
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
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      text-align: left;
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #008080;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .btn {
      background-color: #008080;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <header>
    <h2>Welcome, Dr. <?php echo htmlspecialchars($doctor_name); ?></h2>
    <nav>
      <a href="doctor_dashboard.php">Dashboard</a>
      <a href="view_lab_reports.php">View Reports</a>
      <a href="update_lab_reports.php">Update Reports</a>
      <a href="view_messages.php">Messages</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
    <h1>🧾 Your Patient Lab Reports</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <table>
        <tr>
          <th>ID</th>
          <th>Patient Name</th>
          <th>Test Type</th>
          <th>Report Date</th>
          <th>Results</th>
          <th>Doctor Comments</th>
          <th>File</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo $row['report_id']; ?></td>
            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($row['test_type']); ?></td>
            <td><?php echo $row['report_date']; ?></td>
            <td><?php echo htmlspecialchars($row['results']); ?></td>
            <td><?php echo htmlspecialchars($row['doctor_comments']); ?></td>
            <td>
              <?php if (!empty($row['file_path'])): ?>
                <a class="btn" href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank">View File</a>
              <?php else: ?>
                <span>No file</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No lab reports found for your patients.</p>
    <?php endif; ?>
  </div>
</body>
</html>
