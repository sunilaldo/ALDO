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
    <title>Admin Control Panel</title>
</head>
<body>
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
    <?php endif; ?>
</body>
</html>
