<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - ePaupahan</title>
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
                <li><a href="admin-payments.php"><i class="fas fa-credit-card"></i> Payments</a></li>
                <li><a href="admin-profile.php" class="active"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Update Profile</h1>
            </header>

            <div class="profile">
                <div class="table-container">
                    <div class="table-header">
                        <h2>Fill with your information</h2>
                    
            </div class="profile-container">
                <div class="profile-card">
                    <div class="profile-header">
                    </div>

                    <div>
                        <p><strong>Update Name</strong><p>
                        <input type="text" id="tenant" name="tenant" placeholder="Enter your name" required><br>

                        <p><strong>Update Password</strong><p>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <label for="password"></label>

                        <button type="submit">Update</button>
                    </div>
                    <script>
                        document.getElementById("loginForm").addEventListener("submit", function(event) {
                            event.preventDefault();

                            let name = document.getElementById("name").value;
                            let password = document.getElementById("password").value;                            
                        });
                    </script>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
