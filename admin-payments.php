<?php
include "conn.php"; // database connection

// Fetch all payments with tenant + unit info
$sql = "SELECT tr.transaction_id, t.full_name, u.unit_no, tr.amount_due, tr.due_date, tr.status
        FROM transactions tr
        JOIN tenants t ON tr.tenant_id = t.tenant_id
        JOIN units u ON tr.unit_id = u.unit_id
        ORDER BY tr.due_date ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Management - ePaupahan</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard">
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
                <li><a href="admin-payments.php" class="active"><i class="fas fa-credit-card"></i> Payments</a></li>
                <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Payments Management</h1>
            </header>

            <div class="content">
                <div class="table-container">
                    <div class="table-header">
                        <h2>All Payments</h2>
                        <a href="add-payment.php" class="btn-add">➕ Add Payment</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Tenant Name</th>
                                <th>Unit</th>
                                <th>Amount Due</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["full_name"]) ?></td>
                                        <td><?= htmlspecialchars($row["unit_no"]) ?></td>
                                        <td>₱<?= number_format($row["amount_due"], 2) ?></td>
                                        <td><?= date("M d, Y", strtotime($row["due_date"])) ?></td>
                                        <td>
                                            <?php if ($row["status"] === "Paid"): ?>
                                                <span class="status-badge status-paid">Paid</span>
                                            <?php elseif ($row["status"] === "Overdue"): ?>
                                                <span class="status-badge status-unpaid">Overdue</span>
                                            <?php else: ?>
                                                <span class="status-badge status-unpaid">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="notify-tenant.php?id=<?= $row['transaction_id'] ?>" class="btn-notify">🛎️ Remind</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No payment records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
