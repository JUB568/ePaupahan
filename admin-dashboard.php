<?php
include "functions.php";

// Load tenants
$tenants = loadTenants();

// Get counts
$totalTenants = countTenants();
$totalUnits = countUnits();
$occupiedUnits = countOccupiedUnits();
$availableUnits = countAvailableUnits();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ePaupahan</title>
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
                <li><a href="admin-dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin-tenants.php"><i class="fas fa-users"></i> Tenants</a></li>
                <li><a href="admin-units.php"><i class="fas fa-home"></i> Units</a></li>
                <li><a href="admin-payments.php"><i class="fas fa-credit-card"></i> Payments</a></li>
                <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Dashboard</h1>
                <span class="action-buttons">
                    <a href="admin-notif.html" class="btn-notif"><i class="fas fa-bell"></i> Notification</a>
                </span>
            </header>

            <div class="content">
                <div class="summary-cards">
                    <div class="summary-card">
                        <h3>Total Units</h3>
                        <div class="number"><?= $totalUnits ?></div>
                    </div>
                    <div class="summary-card">
                        <h3>Occupied Units</h3>
                        <div class="number"><?= $occupiedUnits ?></div>
                    </div>
                    <div class="summary-card">
                        <h3>Available Units</h3>
                        <div class="number"><?= $availableUnits ?></div>
                    </div>
                    <div class="summary-card">
                        <h3>Total Tenants</h3>
                        <div class="number"><?= $totalTenants ?></div>
                    </div>
                </div>


                <div class="table-container">
                    <div class="table-header">
                        <h2>Recent Payments</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Contact</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tenants as $tenant): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tenant["name"]) ?></td>
                                    <td><?= htmlspecialchars($tenant["unit"]) ?></td>
                                    <td><?= htmlspecialchars($tenant["contact"]) ?></td>
                                    <td>
                                        <?php if ($tenant["status"] === "Active"): ?>
                                            <span class="status-badge status-paid">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge status-unpaid">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
