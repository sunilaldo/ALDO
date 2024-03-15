<?php
session_start(); // Start the session to access session variables

$host = "localhost";
$dbname = "test";
$username = "root";
$password = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a connection to the MySQL database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form values
    $hostelId = $_SESSION['hostel_id'];
    // Retrieve the name from the session variable instead of the form input
    $name = $_SESSION['username'];
    $messType = $_POST['messType'];

    // Get the current date and time
    $registrationDate = date("Y-m-d H:i:s");
    
    // Check if the student has already registered for the current month
    $checkRegistrationSql = "SELECT * FROM cdetails WHERE name = '$name' AND MONTH(registration_date) = MONTH(NOW())";
    $result = $conn->query($checkRegistrationSql);
    if ($result && $result->num_rows > 0) {
        // Output error message using JavaScript alert if already registered for the current month
        echo '<script>alert("You have already registered for this month"); window.location.href = "dashboard.php";</script>';
        exit; // Stop further execution
    }

    // Check available coupon count for the selected mess type
    $checkCountSql = "SELECT count FROM coupon_counts WHERE mess_type = '$messType'";
    $result = $conn->query($checkCountSql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        if ($count > 0) {
            // Prepare and execute SQL query to insert values into the database
            $sql = "INSERT INTO cdetails (hostelid, name, messType, registration_date) VALUES ('$hostelId', '$name', '$messType', '$registrationDate')";
            if ($conn->query($sql) === TRUE) {
                // Update coupon count
                $updateCountSql = "UPDATE coupon_counts SET count = count - 1 WHERE mess_type = '$messType'";
                $conn->query($updateCountSql);
                // Set session variable to indicate registration
                $_SESSION['registered'] = true;
                // Output success message using JavaScript alert
                echo '<script>alert("Coupon Registered successfully"); window.location.href = "dashboard.php"</script>';
            } else {
                // Output error message using JavaScript alert
                echo '<script>alert("Error: ' . $sql . '\\n' . $conn->error . '");</script>';
            }
        } else {
            // Output error message using JavaScript alert if no coupons available
            echo '<script>alert("No coupons available for selected mess type");</script>';
        }
    } else {
        // Output error message using JavaScript alert if coupon count query fails
        echo '<script>alert("Error checking coupon count");</script>';
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Monthly Mess Coupon Registration</title>
    <link rel="stylesheet" type="text/css" href="coupon.css">
</head>
<body>

    <h2>Monthly Mess Coupon Registration</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="hostelid">Hostel ID:</label><br>
        <input type="text" id="hostel_id" name="hostel_id" value="<?php echo isset($_SESSION['hostel_id']) ? htmlspecialchars($_SESSION['hostel_id']) : ''; ?>" readonly><br><br>
        <label for="name">Name:</label><br>
        <!-- Set the name field to read-only and populate its value with the username -->
        <input type="text" id="name" name="name" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" readonly><br><br>
        <label for="messType">Mess Type:</label><br>
        <select id="messType" name="messType" required>
            <?php
            // Retrieve remaining coupon count for each mess type
            $conn = new mysqli($host, $username, $password, $dbname);
            $getCouponCountSql = "SELECT mess_type, count FROM coupon_counts";
            $result = $conn->query($getCouponCountSql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $messType = $row['mess_type'];
                    $count = $row['count'];
                    echo '<option value="' . $messType . '">' . ucfirst($messType) . ' (' . $count . ' coupons left)</option>';
                }
            }
            ?>
        </select><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
