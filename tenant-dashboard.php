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
        <nav class="sidebar">
            <div class="sidebar-header">
                <img src="white.png" alt="Sidebar Logo" class="sidebar-image">
                <h2>ePaupahan</h2>
                <h5>Tenant Portal</h5>
            </div>
            <ul class="sidebar-nav">
                <li><a href="tenant-dashboard.html" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="tenant-payments.html"><i class="fas fa-credit-card"></i> Payment History</a></li>
                <li><a href="tenant-requestmaintainance.html"><i class="fas fa-tools"></i> Request Maintenance</a></li>
                <li><a href="tenant-rulespolicies.html" ><i class="fas fa-gavel"></i> Rules and Policies</a></li>
                <li><a href="tenant-profile.html" ><i class="fas fa-user"></i> Profile</a></li>
                
            </ul>
            <li class="logout-li"><a href="login.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Tenant Dashboard</h1>
                <span class="action-buttons">
                    <a href="tenant-notif.html" class="btn-notif"><i class="fas fa-bell"></i> Notification</a>
                </span>
            </header>

            <div class="content">
                <div class="tenant-info">
                    <div class="rental-info">
                        <h3>Your Rental Information</h3>
                        <p><strong>Unit:</strong> Unit 2A</p>
                        <p><strong>Monthly Rent:</strong> ₱8,000</p>                                               
                    </div>

                    <div class="payment-info">
                        <h3>Your Payment Information</h3>                       
                        <p><strong>Payment Date:</strong> Dec 5, 2023</p>
                        <p><strong>Amount Paid:</strong> ₱8,000</p>
                    </div>
                </div>
                <div class="tenant-dashboard">

                    <div class="table-history">
                    <div class="table-header">
                        <h2>Request History</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Tenant Name</th>
                                <th>Unit No.</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>Unit 2A</td>
                                <td>2023</td>
                                <td>Done</td>
                                <td><span class="status-badge status-service"></span></td>
                            </tr>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Unit 3B</td>
                                <td>2022</td>
                                <td>Done</td>
                                <td><span class="status-badge status-service"></span></td>
                            </tr>
                            <tr>
                                <td>Pedro Reyes</td>
                                <td>Unit 1C</td>
                                <td>2025</td>
                                <td>Done</td>
                                <td><span class="status-badge status-service"></span></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
