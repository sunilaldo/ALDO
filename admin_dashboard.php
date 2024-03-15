<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <h2><center>Coupon Registrations</center></h2>
    <form method="GET">
        <label for="hostelid">Search by Hostel ID:</label>
        <input type="text" id="hostelid" name="hostelid">
        <button type="submit">Search</button>
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th class="blue-background">Hostel ID</th>
                <th class="blue-background">Name</th>
                <th class="blue-background">Mess Type</th>
                <th class="blue-background">Registration Date</th>
                <th class="blue-background">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
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

            // Check if a search query is submitted
            if(isset($_GET['hostelid']) && !empty($_GET['hostelid'])) {
                $search_hostelid = $_GET['hostelid'];
                // Construct SQL query with search condition
                $sql = "SELECT hostelid, name, messType, registration_date FROM cdetails WHERE hostelid LIKE '%$search_hostelid%'";
            } else {
                // Construct SQL query without search condition
                $sql = "SELECT hostelid, name, messType, registration_date FROM cdetails";
            }

            // Execute the query
            $result = $conn->query($sql);

            // Output results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["hostelid"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["messType"] . "</td>";
                    echo "<td>" . ($row["registration_date"] ? $row["registration_date"] : "N/A") . "</td>"; // Check if the date is empty
                    echo "<td><form method='POST'><input type='hidden' name='hostelid' value='" . $row["hostelid"] . "'><button type='submit' name='delete'>Delete</button></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }

            // Delete record if delete button is clicked
            if(isset($_POST['delete'])) {
                $delete_hostelid = $_POST['hostelid'];
                $sql_delete = "DELETE FROM cdetails WHERE hostelid = '$delete_hostelid'";
                if ($conn->query($sql_delete) === TRUE) {
                    echo "Record deleted successfully";
                    // Refresh the page after deletion
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }

            // Close database connection
            $conn->close();
            ?>
        </tbody>
    </table>
    <script>
        function redirectAdmin() {
            window.location.href = "admin1.php";
        }
    </script>
    <button onclick="redirectAdmin()" class="logout-btn">Back</button>
</body>
</html>
