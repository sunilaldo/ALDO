<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are provided
    $email = !empty($_POST["email"]) ? $_POST["email"] : null;
    $password = !empty($_POST["password"]) ? $_POST["password"] : null;

    if ($email !== null && $password !== null) {
        // Prepare and execute statement
        $stmt = $conn->prepare("SELECT email, password, username, hostel_id FROM details WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch email, username, and hostel_id from the result
            $row = $result->fetch_assoc();
            $storedEmail = $row["email"];
            $storedPassword = $row["password"];
            $storedUsername = $row["username"];
            $storedHostelId = $row["hostel_id"];

            // Verify password
            if ($password === $storedPassword) {
                // Check if the user is an admin
                if ($storedEmail === 'admin@gmail.com' && $password === 'adminpassword') { // Change 'adminpassword' to your admin password
                    // Admin login
                    $_SESSION['email'] = $storedEmail;
                    $_SESSION['username'] = $storedUsername;
                    $_SESSION['hostel_id'] = $storedHostelId;

                    // Redirect to admin dashboard or any other admin page
                    header("Location: admin1.php");
                    exit; // Stop further execution
                } else {
                    // Regular user login
                    $_SESSION['email'] = $storedEmail;
                    $_SESSION['username'] = $storedUsername;
                    $_SESSION['hostel_id'] = $storedHostelId;

                    // Redirect to dashboard or any other page for regular users
                    header("Location: dashboard.php");
                    exit; // Stop further execution
                }
            } else {
                // Password is incorrect, redirect to login.html
                echo "<script>alert('Incorrect password'); window.location = 'login.html';</script>";
                exit; // Stop further execution
            }
        } else {
            // Email does not exist
            echo "<script>alert('Email does not exist or incorrect password.'); window.location = 'login.html';</script>";
            exit; // Stop further execution
        }
    } else {
        // If email or password is empty
        echo "<script>alert('Please enter both email and password.'); window.location = 'login.html';</script>";
        exit; // Stop further execution
    }
}

// Close database connection
$conn->close();
?>
