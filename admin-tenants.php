<?php
include "functions.php";

// Handle add
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
    addTenant($_POST["full_name"], $_POST["username"], $_POST["password"], $_POST["contact"]);
    header("Location: admin-tenants.php");
    exit;
}

// Handle edit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "edit") {
    editTenant($_POST["id"], $_POST["full_name"], $_POST["username"], $_POST["password"], $_POST["contact"]);
    header("Location: admin-tenants.php");
    exit;
}

// Handle delete
if (isset($_GET["delete"])) {
    deleteTenant($_GET["delete"]);
    header("Location: admin-tenants.php");
    exit;
}

// Load tenants
$tenants = loadTenants();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenants Management - ePaupahan</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 400px;
        }
        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
        .modal form input {
            width: 100%;
            margin: 5px 0;
            padding: 8px;
        }
        .modal form button {
            margin-top: 10px;
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
                <li><a href="admin-tenants.php" class="active"><i class="fas fa-users"></i> Tenants</a></li>
                <li><a href="admin-units.php"><i class="fas fa-home"></i> Units</a></li>
                <li><a href="admin-payments.php"><i class="fas fa-credit-card"></i> Payments</a></li>
                <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Tenants Management</h1>
            </header>

            <div class="content">
                <div class="table-container">
                    <div class="table-header">
                        <h2>All Tenants</h2>
                        <button type="button" class="btn-add" onclick="openAddModal()">➕ Add Tenant</button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tenants as $tenant): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tenant["name"]) ?></td>
                                    <td><?= htmlspecialchars($tenant["username"]) ?></td>
                                    <td><?= htmlspecialchars($tenant["contact"]) ?></td>
                                    <td>
                                        <?php if ($tenant["status"] === "Active"): ?>
                                            <span class="status-badge status-paid">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge status-unpaid">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="action-buttons">
                                        <button type="button" class="btn-edit" 
                                            onclick="openEditModal(<?= $tenant['id'] ?>, '<?= htmlspecialchars($tenant['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($tenant['username'], ENT_QUOTES) ?>', '<?= htmlspecialchars($tenant['contact'], ENT_QUOTES) ?>')">
                                            ✏️ Edit
                                        </button>
                                        <a href="?delete=<?= $tenant['id'] ?>" class="btn-delete" onclick="return confirm('Delete this tenant?')">🗑️ Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add Tenant</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <label>Full Name</label>
                <input type="text" name="full_name" required>

                <label>Username</label>
                <input type="text" name="username" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <label>Contact</label>
                <input type="text" name="contact" required>

                <button type="submit" class="btn-add">Save Tenant</button>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Tenant</h2>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="editId">

                <label>Full Name</label>
                <input type="text" name="full_name" id="editName" required>

                <label>Username</label>
                <input type="text" name="username" id="editUsername" required>

                <label>Password (leave blank if unchanged)</label>
                <input type="password" name="password" id="editPassword">

                <label>Contact</label>
                <input type="text" name="contact" id="editContact" required>

                <button type="submit" class="btn-edit">💾 Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById("addModal").style.display = "flex";
        }
        function closeAddModal() {
            document.getElementById("addModal").style.display = "none";
        }
        function openEditModal(id, name, username, contact) {
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editUsername").value = username;
            document.getElementById("editContact").value = contact;
            document.getElementById("editModal").style.display = "flex";
        }
        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }
    </script>
</body>
</html>
