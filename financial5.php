<!DOCTYPE html>
<html>
<head>
    <title>Financial Transactions Table</title>
    <style>
           body {
            background-color: darkblue;
            color: #FFEEBB; /* Use the hexadecimal color code for light pink */
}

        table {
            border: none;
            width: 70%;
            margin: 20px auto;
        }
        th, td {
            border: none;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: darkcyan;
        }
        tr:nth-child(even) {
            background-color: darkslateblue;
        }
	h1 {
	   text-align: center;
	   font-family: "Helvetica Neue",  sans-serif;
	}
    </style>
</head>
<body>

    <h1>Financial Transactions Table</h1>

    <table>
        <tr>
            <th>Record #</th>
            <th>Date/Time</th>
            <th>Description</th>
            <th>Positive/Negative</th>
            <th>Amount</th>
            <th>Total</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "financial_transactions";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM transactions";
        $result = $conn->query($sql);

        $total = 0; // Initialize the total balance

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["recNum"] . "</td>";
                echo "<td>" . $row["dateTim"] . "</td>";
                echo "<td>" . $row["Description"] . "</td>";
                echo "<td>" . ($row["posNeg"] == 1 ? "Positive" : "Negative") . "</td>";
                echo "<td>$" . $row["Amount"] . "</td>";

                // Update total balance based on posNeg and Amount columns
                if ($row["posNeg"] == 1) {
                    $total += $row["Amount"];
                } else {
                    $total -= $row["Amount"];
                }

                echo "<td>$" . $total . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
<table>
<tr><td>
 <h2>Add a New Transaction</h2>
    <form method="post" action="insert_transaction.php">
        <label for="date">Date/Time:</label>
        <input type="datetime-local" id="date" name="date" required><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br>
        <label for="posNeg">Positive/Negative:</label>
        <select id="posNeg" name="posNeg" required>
            <option value="1">Positive</option>
            <option value="0">Negative</option>
        </select><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br>
        <input type="submit" value="Add to Database">
    </form>
</td>
<td>
    <h2>Delete a Transaction</h2>
    <form method="post" action="delete_transaction.php">
        <label for="recordNumber">Record Number:</label>
        <input type="number" id="recordNumber" name="recordNumber" required><br>
        <input type="submit" value="Delete from Database">
    </form>
</td>
<td>
<h2>Edit Transaction</h2>
    <form method="post" action="update_transaction.php">
        <label for="recordNumber">Record Number:</label>
        <input type="number" id="recordNumber" name="recordNumber" required><br>
        <label for="date">Date/Time:</label>
        <input type="datetime-local" id="date" name="date" required><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br>
        <label for="posNeg">Positive/Negative:</label>
        <select id="posNeg" name="posNeg" required>
            <option value="1">Positive</option>
            <option value="0">Negative</option>
        </select><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br>
        <input type="submit" value="Update Record">
    </form>
</td>
</tr>
</table>

</body>
</html>
