<?php
require_once("cred/config.php");

try {
    // Establishing a connection to MySQL database using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Constructing SQL query to select all accounts
    $sql = "SELECT accounts.account_number, accounts.name, accounts.account_type, accounts.balance 
        FROM accounts
        JOIN users ON users.account_number = accounts.account_number";

    // Executing the SQL query
    $stmt = $conn->query($sql);

    // Fetching and displaying all accounts
    if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Accounts</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

<h1>All Accounts</h1>

<table border="1">
    <thead>
        <tr>
            <th>Account Number</th>
	    <th>Name</th>
            <th>Account Type</th>
            <th>Balance</th>
            <th>Edit/view</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Looping through the fetched data and displaying it in a table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>".$row["account_number"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["account_type"]."</td>";
                echo "<td>₹".$row["balance"]."</td>"; // Displaying balance in Indian Rupees
                echo "<td><a href='view_user_details.php?account_number=".$row["account_number"]."'>View Details</a></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

</body>
</html>
<?php
    } else {
        echo "<p>No accounts found.</p>";
    }
} catch(PDOException $e) {
    // Handling errors
    echo "Error: " . $e->getMessage();
}

// Closing the database connection
$conn = null;
?>

