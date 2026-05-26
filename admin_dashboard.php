<?php
session_start();
require_once('config/db_connect.php');

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$admin_name = $_SESSION['full_name'];

// Flash message
$flash_message = '';
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// Fetch data
$doctor_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='doctor'"))['total'];
$patient_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='patient'"))['total'];

$doctors_result = mysqli_query($conn, "SELECT user_id, full_name, email, specialization, phone FROM users WHERE role='doctor' ORDER BY full_name ASC");
$patients_result = mysqli_query($conn, "SELECT user_id, full_name, email, phone FROM users WHERE role='patient' ORDER BY full_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | Medicare Plus</title>
<style>
body { font-family: Arial,sans-serif; background:#f4f7f9; margin:0; padding:0; }
header { background:#008080; color:white; padding:15px 25px; display:flex; justify-content:space-between; }
nav a { color:white; margin-left:15px; text-decoration:none; font-weight:500; }
.container { padding:30px; }
h1,h2,h3 { color:#008080; }
table { width:100%; border-collapse:collapse; margin-top:15px; background:white; }
th,td { padding:10px; border:1px solid #ddd; }
th { background:#008080; color:white; }
tr:nth-child(even) { background:#f2f2f2; }
.btn { padding:6px 10px; background:#008080; color:white; text-decoration:none; border-radius:5px; }
.flash { background:#d4edda; color:#155724; padding:10px; margin-bottom:15px; border-radius:5px; }
</style>
</head>
<body>
<header>
    <h2>Admin Dashboard</h2>
    <nav>
        <span>Welcome, <?php echo htmlspecialchars($admin_name); ?></span>
        <a href="login.php">Logout</a>
    </nav>
</header>

<div class="container">

<?php if($flash_message): ?>
<div class="flash"><?php echo htmlspecialchars($flash_message); ?></div>
<?php endif; ?>

<h3>📊 Quick Stats</h3>
<p>Total Doctors: <?php echo $doctor_count; ?> | Total Patients: <?php echo $patient_count; ?></p>

<h3>➕ Add New Doctor</h3>
<a class="btn" href="add_doctor.php">Add Doctor</a>

<h3>👨‍⚕️ Doctors List</h3>
<?php if(mysqli_num_rows($doctors_result) > 0): ?>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Specialization</th><th>Phone</th><th>Actions</th></tr>
<?php while($doc = mysqli_fetch_assoc($doctors_result)): ?>
<tr>
    <td><?php echo $doc['user_id']; ?></td>
    <td><?php echo htmlspecialchars($doc['full_name']); ?></td>
    <td><?php echo htmlspecialchars($doc['email']); ?></td>
    <td><?php echo htmlspecialchars($doc['specialization']); ?></td>
    <td><?php echo htmlspecialchars($doc['phone']); ?></td>
    <td>
        <a class="btn" href="edit_user.php?id=<?php echo $doc['user_id']; ?>">Edit</a>
        <a class="btn" href="delete_user.php?id=<?php echo $doc['user_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No doctors found.</p>
<?php endif; ?>

<h3>👥 Patients List</h3>
<?php if(mysqli_num_rows($patients_result) > 0): ?>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
<?php while($pat = mysqli_fetch_assoc($patients_result)): ?>
<tr>
    <td><?php echo $pat['user_id']; ?></td>
    <td><?php echo htmlspecialchars($pat['full_name']); ?></td>
    <td><?php echo htmlspecialchars($pat['email']); ?></td>
    <td><?php echo htmlspecialchars($pat['phone']); ?></td>
    <td>
        <a class="btn" href="edit_user.php?id=<?php echo $pat['user_id']; ?>">Edit</a>
        <a class="btn" href="delete_user.php?id=<?php echo $pat['user_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No patients found.</p>
<?php endif; ?>

</div>
</body>
</html>
