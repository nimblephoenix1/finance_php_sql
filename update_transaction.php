<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financial_transactions";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize POST data
$recordNumber = $_POST['recordNumber'];
$date = $_POST['date'];
$description = $_POST['description'];
$posNeg = $_POST['posNeg'];
$amount = $_POST['amount'];

// Prepare the SQL query with placeholders
$sql = "UPDATE transactions SET dateTim=?, Description=?, posNeg=?, Amount=? WHERE recNum=?";

// Prepare the statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in prepared statement: " . $conn->error);
}

// Bind parameters and execute the statement
$stmt->bind_param("ssdsi", $date, $description, $posNeg, $amount, $recordNumber);

if ($stmt->execute()) {
      // JavaScript code to reload the page and display a message
    echo '<script>';
    echo 'alert("1 record upded in transactions database");';
    echo 'window.location.href = "financial5.php";'; // Redirect to your main page
    echo '</script>';
} else {
    echo json_encode(['success' => false]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
