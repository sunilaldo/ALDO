<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer autoloader
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'test';

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $enteredFullName = $_POST['username'];
    $enteredEmail = $_POST['email'];
    $enteredPassword = $_POST['password'];
    $enteredConfirmPassword = $_POST['confirm-password'];
    $enteredhostelid = $_POST['hostel_id'];

    // Basic input validation - you should implement more robust validation/sanitization
    if (!empty($enteredFullName) && !empty($enteredEmail) && !empty($enteredPassword) && ($enteredPassword == $enteredConfirmPassword)) {
        // Check if the hostel_id already exists in the database
        $checkQuery = "SELECT * FROM details WHERE hostel_id = '$enteredhostelid'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            // If the hostel_id already exists, display a JavaScript alert message
            echo '<script>alert("Hostel ID already exists in the database."); window.location.href = "signup.php";</script>';
        } else {
            // If the hostel_id doesn't exist, proceed with user registration
            $query = "INSERT INTO details (username, email, password, hostel_id) VALUES ('$enteredFullName', '$enteredEmail', '$enteredPassword', '$enteredhostelid')";
            session_start();
            $_SESSION['username'] = $enteredFullName;
            $_SESSION['hostel_id'] = $enteredhostelid;

            if ($conn->query($query) === TRUE) {
                // Sending email using PHPMailer
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';  // Specify SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'ndkisan51@gmail.com';  // SMTP username
                    $mail->Password = 'emdsgyqnuhgnwarh';  // SMTP password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;  // TCP port to connect to

                    //Recipients
                    $mail->setFrom('ndkisan51@gmail.com', 'SUNIL ALDO S A');
                    $mail->addAddress($enteredEmail);  // Add a recipient

                    // Content
                    $mail->isHTML(true);  // Set email format to HTML
                    $mail->Subject = 'Find Your Hostel Webpage Credentials';
                    $mail->Body    = 'Hello ' . $enteredFullName . ',<br><br>Your credentials for the hostel webpage:<br>Hostel ID: ' . $enteredhostelid . '<br>Name: ' . $enteredFullName . '<br>Email: ' . $enteredEmail . '<br>Password: ' . $enteredPassword;

                    $mail->send();
                    echo '<script>alert("Account created successfully! Check your email for login credentials."); window.location.href = "admin1.php";</script>';
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Please fill in all the fields and make sure the passwords match.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css"> <!-- Include your existing stylesheet -->

    <script>
        // JavaScript function to validate password match
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please enter matching passwords.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

    <div class="main">
        <div class="navbar">
            <!-- ... (unchanged) ... -->
        </div>

        <div class="content">
            <h1>Sign Up for Loho Mess</h1>

            <div class="form">
                <h2>Create an Account</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validatePassword()">
                    <input type="text" name="hostel_id" placeholder="Enter Hostel ID" required>
                    <input type="text" name="username" placeholder="Enter Name" required>
                    <input type="email" name="email" placeholder="Enter Email" required>
                    <input type="password" id="password" name="password" placeholder="Create Password" required>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                    <button type="submit" class="btnn">Sign Up</button>
                </form>
                <br><p class="link">Already have an account? <a href="login.html">Log in here</a></p>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>
