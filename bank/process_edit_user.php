<?php
require_once("cred/config.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $account_number = $_POST['account_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    // Retrieve other form data

    // Connect to MySQL database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update user information in the database
    $sql = "UPDATE users SET first_name=?, last_name=?, dob=?, address=? WHERE account_number=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $dob, $address, $account_number);
    if ($stmt->execute()) {
        // User information updated successfully
        echo "User information updated successfully";
    } else {
        // Error updating user information
        echo "Error updating user information: " . $conn->error;
    }

    // Close database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: index.html");
    exit();
}
?>
 
