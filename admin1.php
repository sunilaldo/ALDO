<?php
session_start();

// Set admin access flag to false initially if not set
if (!isset($_SESSION['admin_allowed'])) {
    $_SESSION['admin_allowed'] = false;
}

// Check if the admin has clicked the button to allow access to coupon.php
if(isset($_POST['allow_access'])) {
    $_SESSION['admin_allowed'] = true;
}

// Check if the admin has clicked the button to disallow access to coupon.php
if(isset($_POST['disallow_access'])) {
    $_SESSION['admin_allowed'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="admin1.css">
</head>
<body>
    <center>
    <h1>Admin Control Panel</h1>

    <?php if($_SESSION['admin_allowed']): ?>
    <!-- If admin has allowed access, show button to disallow access -->
    <form method="post">
        <input type="submit" name="disallow_access" value="Disallow Access">
    </form>
    <?php else: ?>
    <!-- If admin has not allowed access, show button to allow access -->
    <form method="post">
        <input type="submit" name="allow_access" value="Allow Access">
    </form>
    </center>

    <?php endif; ?>

    <div class="dashboard">
    
        <div class="button-container">
            <a href="signup.php"><button class="button button-new" button type="button">Add New Student</button></a>  
            <button id="couponButton" class="button button-coupon">Coupon Registrations</button>          
            <button class="button button-reduction">Mess Reductions</button>
            <button class="button button-feedback">Queries/Feedbacks</button>
            <button onclick="confirmLogout()" class="logout-btn">Logout</button>
        </div>
    </div>

    <script>
        // Function to display confirmation dialog for logout
        function confirmLogout() {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                logout(); // If confirmed, proceed with logout
            }
        }

        // Function to perform logout action
        function logout() {
            window.location.href = "login.html";
        }

        // Add event listener to the Coupon Registrations button
        document.getElementById("couponButton").addEventListener("click", function() {
            window.location.href = "admin_dashboard.php";
        });
    </script>
</body>
</html>
