<?php
session_start();
include("conn.php");

// Check if tenant is logged in
if (!isset($_SESSION["user_id"]) || $_SESSION["user_level"] !== "tenant") {
    header("Location: login.php");
    exit;
}

$tenant_id = $_SESSION["user_id"];

// Fetch tenant info with unit
$sql = "SELECT t.full_name, t.contact, u.unit_no, u.monthly_rent 
        FROM tenants t
        LEFT JOIN units u ON u.current_tenant = t.tenant_id
        WHERE t.tenant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$tenant_info = $stmt->get_result()->fetch_assoc();

// Fetch payment history (latest)
$sql2 = "SELECT tr.*, u.unit_no 
         FROM transactions tr
         JOIN units u ON tr.unit_id = u.unit_id
         WHERE tr.tenant_id = ?
         ORDER BY tr.due_date DESC";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $tenant_id);
$stmt2->execute();
$transactions = $stmt2->get_result();
$latest_payment = $transactions->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard - ePaupahan</title>
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
                <li><a href="tenant-dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="tenant-payments.php"><i class="fas fa-credit-card"></i> Payment History</a></li>
                <li><a href="tenant-requestmaintainance.php"><i class="fas fa-tools"></i> Request Maintenance</a></li>
                <li><a href="tenant-rulespolicies.php"><i class="fas fa-gavel"></i> Rules and Policies</a></li>
                <li><a href="tenant-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <!-- Main -->
        <main class="main-content">
            <header class="top-bar">
                <h1>Welcome, <?= htmlspecialchars($tenant_info['full_name'] ?? "Tenant") ?>!</h1>
                <span class="action-buttons">
                    <a href="tenant-notif.html" class="btn-notif"><i class="fas fa-bell"></i> Notification</a>
                </span>
            </header>

            <div class="content">
                <!-- Rental + Payment Info -->
                <div class="tenant-info">
                    <div class="rental-info">
                        <h3>Your Rental Information</h3>
                        <?php if ($tenant_info) { ?>
                            <p><strong>Unit:</strong> <?= htmlspecialchars($tenant_info['unit_no'] ?? "N/A") ?></p>
                            <p><strong>Monthly Rent:</strong> ₱<?= number_format($tenant_info['monthly_rent'] ?? 0, 2) ?></p>
                        <?php } else { ?>
                            <p>No rental information found.</p>
                        <?php } ?>
                    </div>

                    <div class="payment-info">
                        <h3>Your Payment Information</h3>
                        <?php if ($latest_payment) { ?>
                            <p><strong>Payment Date:</strong> <?= htmlspecialchars($latest_payment['due_date']) ?></p>
                            <p><strong>Amount Paid:</strong> ₱<?= number_format($latest_payment['amount_due'], 2) ?></p>
                        <?php } else { ?>
                            <p>No payments yet.</p>
                        <?php } ?>
                    </div>
                </div>

                <!-- Table History -->
                <div class="tenant-dashboard">
                    <div class="table-history">
                        <div class="table-header">
                            <h2>Payment History</h2>
                        </div>
                        <?php if ($transactions->num_rows > 0) { ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $transactions->data_seek(0);
                                    while ($row = $transactions->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['unit_no']) ?></td>
                                            <td><?= htmlspecialchars($row['due_date']) ?></td>
                                            <td>₱<?= number_format($row['amount_due'], 2) ?></td>
                                            <td><?= htmlspecialchars($row['status']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p>No transactions found.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
