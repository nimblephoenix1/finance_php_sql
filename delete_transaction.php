<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financial_transactions";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recordNumber = $_POST['recordNumber'];

$sql = "DELETE FROM transactions WHERE recNum = $recordNumber";

if ($conn->query($sql) === TRUE) {
     // JavaScript code to reload the page and display a message
    echo '<script>';
    echo 'alert("1 record deleted in transactions database");';
    echo 'window.location.href = "financial5.php";'; // Redirect to your main page
    echo '</script>';
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
