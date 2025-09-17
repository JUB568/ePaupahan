<?php
session_start();
include("conn.php"); // db connection

$message = "";

// ------------------- LOGIN -------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $login_type = $_POST["login-type"];

    if ($login_type === "admin") {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND user_password = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM tenants WHERE username = ? AND user_password = ?");
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Save session
        $_SESSION["user_id"] = ($login_type === "admin") ? $row["admin_id"] : $row["tenant_id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["full_name"] = $row["full_name"];
        $_SESSION["contact"] = $row["contact"];
        $_SESSION["user_level"] = $login_type;

        if ($login_type === "admin") {
            header("Location: admin-dashboard.php");
            exit;
        } elseif ($login_type === "tenant") {
            header("Location: tenant-dashboard.php");
            exit;
        }
    } else {
        $message = "Invalid email or password!";
    }
}

// ------------------- ADMIN SIGNUP -------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup_admin"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $fullname = $_POST["fullname"];
    $contact = $_POST["contact"];

    $stmt = $conn->prepare("INSERT INTO admins (username, user_password, full_name, contact) 
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $fullname, $contact);

    if ($stmt->execute()) {
        $message = "Admin account created successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePaupahan - Login</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .signup-btn {
            display: block;
            margin-top: 10px;
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        .signup-btn:hover { background: #45a049; }

        /* Modal styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%; background: rgba(0,0,0,0.6);
            justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 20px; width: 400px;
            border-radius: 10px; position: relative; }
        .close { position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer; }
        .modal-content input { margin: 8px 0; width: 100%; padding: 10px; }
        .modal-content button { width: 100%; padding: 10px; margin-top: 10px;
            background: #4CAF50; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img class="black" src="black.png" alt="">
                <h1>ePaupahan</h1>
                <p>Tenant & Rental Management System</p>
            </div>

            <form class="vessel" method="POST" action="">
                <div class="login-toggle">
                    <input type="radio" id="admin-login" name="login-type" value="admin" checked onclick="toggleSignup(true)">
                    <label for="admin-login">Admin</label>
                    
                    <input type="radio" id="tenant-login" name="login-type" value="tenant" onclick="toggleSignup(false)">
                    <label for="tenant-login">Tenant</label>
                </div>

                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" name="login">Log In</button>
                <button type="button" id="signupBtn" class="signup-btn" onclick="openModal()">Sign Up (Admin)</button>
            </form>

            <?php if (!empty($message)) { ?>
                <script>alert("<?php echo $message; ?>");</script>
            <?php } ?>
        </div>
    </div>

    <!-- Admin Signup Modal -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Create Admin Account</h2>
            <form method="POST" action="">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="text" name="contact" placeholder="Contact" required>
                <input type="email" name="username" placeholder="Email/Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="signup_admin">Sign Up</button>
            </form>
        </div>
    </div>

    <script>
        function toggleSignup(isAdmin) {
            document.getElementById("signupBtn").style.display = isAdmin ? "block" : "none";
        }
        function openModal() {
            document.getElementById("signupModal").style.display = "flex";
        }
        function closeModal() {
            document.getElementById("signupModal").style.display = "none";
        }
    </script>
</body>
</html>
