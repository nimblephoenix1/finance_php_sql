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
$date = $conn->real_escape_string($_POST['date']);
$description = $conn->real_escape_string($_POST['description']);
$posNeg = $conn->real_escape_string($_POST['posNeg']);
$amount = floatval($_POST['amount']); // Make sure amount is a float

// Prepare the SQL query with placeholders
$sql = "INSERT INTO transactions (dateTim, Description, posNeg, Amount) VALUES (?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in prepared statement: " . $conn->error);
}

// Bind parameters and execute the statement
$stmt->bind_param("sssd", $date, $description, $posNeg, $amount);

if ($stmt->execute()) {
    // JavaScript code to reload the page and display a message
    echo '<script>';
    echo 'alert("1 record inserted into transactions database");';
    echo 'window.location.href = "financial5.php";'; // Redirect to your main page
    echo '</script>';
} else {
    echo json_encode(['success' => false]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
