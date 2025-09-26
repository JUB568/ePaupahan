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
                <li><a href="admin-dashboard.php" ><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
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
                        <a href="#" class="btn-add">➕ Add Payment</a>
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
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>Unit 2A</td>
                                <td>₱8,000</td>
                                <td>Dec 5, 2023</td>
                                <td><span class="status-badge status-paid">Paid</span></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn-notify">🛎️ Remind</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Unit 3B</td>
                                <td>₱10,000</td>
                                <td>Dec 5, 2023</td>
                                <td><span class="status-badge status-paid">Paid</span></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn-notify">🛎️ Remind</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Pedro Reyes</td>
                                <td>Unit 1C</td>
                                <td>₱7,500</td>
                                <td>Dec 10, 2023</td>
                                <td><span class="status-badge status-unpaid">Unpaid</span></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn-notify">🛎️ Remind</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Ana Rodriguez</td>
                                <td>Unit 4A</td>
                                <td>₱9,000</td>
                                <td>Dec 5, 2023</td>
                                <td><span class="status-badge status-paid">Paid</span></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn-notify">🛎️ Remind</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Carlos Mendoza</td>
                                <td>Unit 5B</td>
                                <td>₱12,500</td>
                                <td>Dec 15, 2023</td>
                                <td><span class="status-badge status-unpaid">Unpaid</span></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn-notify">🛎️ Remind</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
