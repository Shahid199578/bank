<?php
require_once("cred/config.php");

try {
    // Establishing a connection to MySQL database using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Constructing SQL query to calculate total number of accounts and total balance
    $sql = "SELECT COUNT(*) AS total_accounts, SUM(balance) AS total_balance FROM $table";

    // Executing the SQL query
    $stmt = $conn->query($sql);

    // Fetching the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_accounts = $row['total_accounts'];
    $total_balance = $row['total_balance'];

} catch(PDOException $e) {
    // Handling errors
    echo "Error: " . $e->getMessage();
}

// Closing the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Management System - Dashboard</title>
   <link rel="stylesheet" href="style/styles.css">
</head>
<body>

<div class="dashboard">
    <h1>Bank Management System - Dashboard</h1>
    <p>Total Accounts: <?php echo $total_accounts; ?></p>
    <p>Total Balance: ₹<?php echo number_format($total_balance, 2); ?></p>
    <a href="all_accounts.php" class="button">View All Accounts</a>
</div>

</body>
</html>

