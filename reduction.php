<?php
session_start();
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "test"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO rdetails (name, hostelid, block, roomno, assistantdirector, daysLeaving) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $hostelid, $block, $roomno, $assistantdirector, $daysLeaving);

    // Sanitize and validate form data
    $name = $_POST['name'];
    $hostelid = $_POST['hostel_id'];
    $block = $_POST['block'];
    $roomno = $_POST['roomno'];
    $assistantdirector = $_POST['assistantdirector'];
    $daysLeaving = $_POST['daysLeaving'];

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Output success message using JavaScript alert
        echo '<script>alert("Applied Reduction successfully"); window.location.href = "dashboard.html"</script>';
    } else {
        // Output error message using JavaScript alert
        echo '<script>alert("Error: ' . $stmt->error . '");</script>';
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Reduction</title>
    <link rel="stylesheet" href="reduction.css">
</head>
<body>
    <div class="container">
        <h2>Mess Reduction</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" readonly><br><br>
            </div>
            <div class="form-group">
                <label for="hostelid">Hostel ID:</label>
                <input type="text" id="hostel_id" name="hostel_id" value="<?php echo isset($_SESSION['hostel_id']) ? htmlspecialchars($_SESSION['hostel_id']) : ''; ?>" readonly><br><br>
            </div>
             <div class="form-group">
                <label for="block">Block:</label>
                <select id="block" name="block" required>
                    <option value="">Select Block</option>
                    <option value="Licet">Licet</option>
                    <option value="A Block">A Block</option>
                    <option value="Common Block">Common Block</option>
                </select>
            </div>
            <div class="form-group">
                <label for="roomno">Room Number:</label>
                <input type="text" id="roomno" name="roomno" required>
            </div>
            <div class="form-group">
                <label for="assistantdirector">Assistant Director:</label>
                <input type="text" id="assistantdirector" name="assistantdirector" required>
            </div>
            <div class="form-group">
                <label for="daysLeaving">Number of Days Leaving:</label>
                <input type="number" id="daysLeaving" name="daysLeaving" min="1" max="10" required>
            </div>
           
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
