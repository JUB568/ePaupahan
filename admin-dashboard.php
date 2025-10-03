<?php
include "functions.php";
include "conn.php"; // make sure conn.php has $conn defined

// Load tenants
$tenants = loadTenants();

// Get counts
$totalTenants = countTenants();
$totalUnits = countUnits();
$occupiedUnits = countOccupiedUnits();
$availableUnits = countAvailableUnits();

// Get pending maintenance requests
$sql = "SELECT mr.request_id, mr.request_date, mr.description, t.full_name AS tenant, u.unit_no 
        FROM maintenance_requests mr
        JOIN tenants t ON mr.tenant_id = t.tenant_id
        JOIN units u ON mr.unit_id = u.unit_id
        WHERE mr.status = 'Pending'
        ORDER BY mr.request_date DESC";
$result = $conn->query($sql);

$requests = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}
$pendingCount = count($requests);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ePaupahan</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Notification ping */
        .notif-icon {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .notif-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 50%;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 12px;
            width: 600px;
            max-height: 80%;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h2 {
            margin: 0;
        }
        .close-btn {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            border: none;
            background: none;
        }
        .request-card {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .request-card h4 {
            margin: 0 0 6px 0;
        }
        .request-card p {
            margin: 4px 0;
        }
    </style>
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
                    <span class="btn-notif notif-icon" id="notifBtn">
                        <i class="fas fa-bell"></i> Notification
                        <?php if ($pendingCount > 0): ?>
                            <span class="notif-badge"><?= $pendingCount ?></span>
                        <?php endif; ?>
                    </span>
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

    <!-- Modal -->
    <div id="notifModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Pending Maintenance Requests</h2>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>
            <?php if ($pendingCount > 0): ?>
                <?php foreach ($requests as $req): ?>
                    <div class="request-card">
                        <h4>Tenant: <?= htmlspecialchars($req['tenant']) ?> (Unit <?= htmlspecialchars($req['unit_no']) ?>)</h4>
                        <p><strong>Date:</strong> <?= htmlspecialchars($req['request_date']) ?></p>
                        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($req['description'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No pending requests 🎉</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const notifBtn = document.getElementById('notifBtn');
        const modal = document.getElementById('notifModal');
        const closeBtn = document.getElementById('closeModal');

        notifBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
