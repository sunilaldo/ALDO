<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">LOHO</h2>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="dashboard.php">HOME</a></li>
                    <li><a href="menu.html">MENU</a></li> <!-- Updated link to Menu page -->
                    <?php if(isset($_SESSION['admin_allowed']) && $_SESSION['admin_allowed']): ?>
                    <li><a href="coupon.php">COUPON</a></li>
                    <?php endif; ?>
                    <li><a href="reduction.php">REDUCTION</a></li>
                    <li><a href="gallery.html">GALLERY</a></li>
                    <li><a href="about.html">ABOUT</a></li> <!-- Updated link to About Us page -->
                    <li><a href="contact.html">CONTACT</a></li>
                    <li><a href="logout.php" id="logout">LOG OUT</a></li> <!-- Added an ID for logout link -->
                </ul>
            </div>

            <div class="search">
                <input class="srch" type="search" name="" placeholder="Type To text">
                <a href="#"> <button class="btn">Search</button></a>
            </div>
        </div> 

        <div class="content">
            <h1>Loho Mess<br><span>Management</span> <br>Welcomes you !</h1>
            <p class="par">
               <br><button class="cn"><a href="about.html">About us</a></button>
            </p>
        </div>
    </div>
    
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>
