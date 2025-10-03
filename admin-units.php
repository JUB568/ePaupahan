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
    editUnit($_POST["id"], $_POST["unit_no"], $_POST["type"], $_POST["rent"], $_POST["availability"], $_POST["tenant_id"]);
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
    <style>
        /* Simple Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
        }
        .close {
            float: right;
            font-size: 20px;
            cursor: pointer;
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
                                        <button type="button" 
                                                class="btn-edit"
                                                onclick="openEditModal(<?= $unit['id'] ?>, '<?= $unit['unit_no'] ?>', '<?= $unit['type'] ?>', <?= $unit['rent'] ?>, '<?= $unit['availability'] ?>')">
                                            ✏️ Edit
                                        </button>
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

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Unit</h2>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">

                <label>Unit No.</label>
                <input type="text" name="unit_no" id="edit_unit_no" required><br><br>

                <label>Type</label>
                <input type="text" name="type" id="edit_type" required><br><br>

                <label>Monthly Rent</label>
                <input type="number" step="0.01" name="rent" id="edit_rent" required><br><br>

                <label>Availability</label>
                <select name="availability" id="edit_availability">
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                </select><br><br>

                <label>Tenant (ID)</label>
                <input type="number" name="tenant_id" id="edit_tenant_id" placeholder="Tenant ID"><br><br>

                <button type="submit">💾 Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, unit_no, type, rent, availability) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_unit_no").value = unit_no;
            document.getElementById("edit_type").value = type;
            document.getElementById("edit_rent").value = rent;
            document.getElementById("edit_availability").value = availability;
            document.getElementById("editModal").style.display = "block";
        }

        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Close modal if user clicks outside
        window.onclick = function(event) {
            let modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
