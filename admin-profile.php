<?php
session_start();
include("conn.php");

// Check if admin is logged in
if (!isset($_SESSION["user_id"]) || $_SESSION["user_level"] !== "admin") {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION["user_id"];
$message = "";

// Fetch admin data
$sql = "SELECT username, full_name, contact FROM admins WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL error: " . $conn->error);
}
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username   = $_POST["username"];
    $full_name  = $_POST["full_name"];
    $contact    = $_POST["contact"];
    $password   = $_POST["password"];

    if (!empty($password)) {
        // Update including password
        $update_sql = "UPDATE admins SET username=?, full_name=?, contact=?, user_password=? WHERE admin_id=?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $username, $full_name, $contact, $password, $admin_id);
    } else {
        // Update without password
        $update_sql = "UPDATE admins SET username=?, full_name=?, contact=? WHERE admin_id=?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $username, $full_name, $contact, $admin_id);
    }

    if ($update_stmt->execute()) {
        $message = "Profile updated successfully!";

        // Refresh admin data
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - ePaupahan</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="white.png" alt="Sidebar Logo" class="sidebar-image">
            <h2>ePaupahan</h2>
            <h5>Admin Portal</h5>
        </div>
        <ul class="sidebar-nav">
            <li><a href="admin-dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="admin-tenants.php"><i class="fas fa-users"></i> Tenants</a></li>
            <li><a href="admin-units.php"><i class="fas fa-home"></i> Units</a></li>
            <li><a href="admin-payments.php"><i class="fas fa-credit-card"></i> Payments</a></li>
            <li><a href="admin-profile.php" class="active"><i class="fas fa-user"></i> Profile</a></li>
        </ul>
        <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-bar">
            <h1>Update Profile</h1>
        </header>

        <div class="maintainance">
            <div class="table-container">
                <div class="table-header">
                    <h2>Fill in your information</h2>
                </div>

                <?php if ($message): ?>
                    <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>

                <form method="POST" class="maintainance-card">
                    <p><strong>Username</strong></p>
                    <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required><br>

                    <p><strong>Full Name</strong></p>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($admin['full_name']) ?>" required><br>

                    <p><strong>Contact</strong></p>
                    <input type="text" name="contact" value="<?= htmlspecialchars($admin['contact']) ?>" required><br>

                    <p><strong>New Password (leave blank if not changing)</strong></p>
                    <input type="password" name="password" placeholder="Enter new password"><br>

                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
