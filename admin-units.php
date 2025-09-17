<?php
include "unitFunction.php";

// Handle add
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
    addUnit($_POST["unit_no"], $_POST["type"], $_POST["rent"]);
    header("Location: admin-units.php");
    exit;
}

// Handle edit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "edit") {
    editUnit($_POST["id"], $_POST["unit_no"], $_POST["type"], $_POST["rent"], $_POST["availability"]);
    header("Location: admin-units.php");
    exit;
}

// Handle delete
if (isset($_GET["delete"])) {
    deleteUnit($_GET["delete"]);
    header("Location: admin-units.php");
    exit;
}

// Load units
$units = loadUnits();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Units Management - ePaupahan</title>
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
                <li><a href="admin-units.php" class="active"><i class="fas fa-home"></i> Units</a></li>
                <li><a href="admin-payments.php"><i class="fas fa-credit-card"></i> Payments</a></li>
                <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Units Management</h1>
            </header>

            <div class="content">
                <div class="table-container">
                    <div class="table-header">
                        <h2>All Rental Units</h2>
                        <!-- Add Form -->
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="action" value="add">
                            <input type="text" name="unit_no" placeholder="Unit No." required>
                            <input type="text" name="type" placeholder="Type" required>
                            <input type="number" step="0.01" name="rent" placeholder="Monthly Rent" required>
                            <button type="submit" class="btn-add">➕ Add Unit</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Unit No.</th>
                                <th>Type</th>
                                <th>Monthly Rent</th>
                                <th>Availability</th>
                                <th>Current Tenant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($units as $unit): ?>
                                <tr>
                                    <td><?= htmlspecialchars($unit["unit_no"]) ?></td>
                                    <td><?= htmlspecialchars($unit["type"]) ?></td>
                                    <td>₱<?= number_format($unit["rent"], 2) ?></td>
                                    <td>
                                        <?php if ($unit["availability"] === "Available"): ?>
                                            <span class="status-badge status-paid">Available</span>
                                        <?php else: ?>
                                            <span class="status-badge status-unpaid">Occupied</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($unit["tenant"]) ?></td>
                                    <td class="action-buttons">
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="id" value="<?= $unit["id"] ?>">
                                            <input type="hidden" name="unit_no" value="<?= $unit["unit_no"] ?>">
                                            <input type="hidden" name="type" value="<?= $unit["type"] ?>">
                                            <input type="hidden" name="rent" value="<?= $unit["rent"] ?>">
                                            <input type="hidden" name="availability" value="<?= $unit["availability"] ?>">
                                            <button type="submit" class="btn-edit">✏️ Edit</button>
                                        </form>
                                        <a href="?delete=<?= $unit['id'] ?>" class="btn-delete" onclick="return confirm('Delete this unit?')">🗑️ Delete</a>
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
