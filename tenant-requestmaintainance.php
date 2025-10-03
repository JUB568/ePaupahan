<?php
session_start();
include("conn.php");

// ✅ Check if tenant is logged in
if (!isset($_SESSION["user_id"]) || $_SESSION["user_level"] !== "tenant") {
    header("Location: login.php");
    exit;
}

$tenant_id = $_SESSION["user_id"];
$message = "";

// ✅ Fetch tenant details + their unit
$sql = "SELECT t.full_name, u.unit_id, u.unit_no 
        FROM tenants t 
        JOIN units u ON u.current_tenant = t.tenant_id 
        WHERE t.tenant_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();
$tenant = $result->fetch_assoc();

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST["issue"];
    $unit_id = $tenant["unit_id"];
    $today = date("Y-m-d");

    $insert_sql = "INSERT INTO maintenance_requests (tenant_id, unit_id, request_date, description) 
                   VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    if (!$insert_stmt) {
        die("SQL Error: " . $conn->error);
    }
    $insert_stmt->bind_param("iiss", $tenant_id, $unit_id, $today, $description);

    if ($insert_stmt->execute()) {
        $message = "✅ Maintenance request submitted successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Maintenance - ePaupahan</title>
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
                <h5>Tenant Portal</h5>
            </div>
            <ul class="sidebar-nav">
                <li><a href="tenant-dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="tenant-payments.php"><i class="fas fa-credit-card"></i> Payment History</a></li>
                <li><a href="tenant-requestmaintainance.php" class="active"><i class="fas fa-tools"></i> Request Maintenance</a></li>
                <li><a href="tenant-rulespolicies.php"><i class="fas fa-gavel"></i> Rules and Policies</a></li>
                <li><a href="tenant-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-bar">
                <h1>Request Maintenance</h1>
            </header>

            <div class="maintainance">
                <div class="table-container">
                    <div class="table-header">
                        <h2>Fill the request form</h2>
                    </div>

                    <?php if ($message): ?>
                        <p style="font-weight: bold; color: green;"><?= htmlspecialchars($message) ?></p>
                    <?php endif; ?>

                    <form method="POST" class="maintainance-card">
                        <p><strong>Tenant Name:</strong></p>
                        <input type="text" value="<?= htmlspecialchars($tenant['full_name']) ?>" disabled><br>

                        <p><strong>Unit Number:</strong></p>
                        <input type="text" value="<?= htmlspecialchars($tenant['unit_no']) ?>" disabled><br>

                        <p><strong>Issue Description:</strong></p>
                        <textarea name="issue" placeholder="Describe the Problem..." required></textarea><br>

                        <button type="submit">Submit Request</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
