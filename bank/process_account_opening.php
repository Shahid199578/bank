<?php
require_once("cred/config.php");

// Function to create an alert message
function showAlert($message) {
    echo "<script>alert('$message');</script>";
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];
    $aadhaar_number = $_POST['aadhaar_number'];
    $pan_number = $_POST['pan_number'];

    // Handle file uploads
    $profile_picture = $_FILES['profile_picture']['name'];
    $profile_picture_tmp = $_FILES['profile_picture']['tmp_name'];
    $signature = $_FILES['signature']['name'];
    $signature_tmp = $_FILES['signature']['tmp_name'];

    // Move uploaded files to a directory
    $upload_directory = 'uploads/';
    move_uploaded_file($profile_picture_tmp, $upload_directory . $profile_picture);
    move_uploaded_file($signature_tmp, $upload_directory . $signature);

    // Connect to MySQL database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert form data into the users table
    $sql = "INSERT INTO users (first_name, last_name, dob, address, mobile_number, aadhaar_number, pan_number, profile_picture, signature)
            VALUES ('$first_name', '$last_name', '$dob', '$address', '$mobile_number', '$aadhaar_number', '$pan_number', '$profile_picture', '$signature')";

    if ($conn->query($sql) === TRUE) {
        // Trigger to sync data with accounts table
        $trigger_sql = "INSERT INTO accounts (account_type, balance, Name)
                        VALUES ('Regular', 0, CONCAT('$first_name', ' ', '$last_name'))";
        if ($conn->query($trigger_sql) === TRUE) {
            // Trigger to update account number in users table
            $update_user_sql = "UPDATE users SET account_number = LAST_INSERT_ID() WHERE account_number IS NULL";
            if ($conn->query($update_user_sql) === TRUE) {
                showAlert("Triggers executed successfully");
                echo "<script>document.getElementById('accountOpeningForm').reset();</script>";
                echo "<script>window.location.href='account_opening.php';</script>";
                exit; // Ensure script stops executing after redirecting
            } else {
                showAlert("Error updating account number in users table: " . $conn->error);
            }
        } else {
            showAlert("Error executing accounts trigger: " . $conn->error);
        }
    } else {
        showAlert("Error inserting data into users table: " . $conn->error);
    }

    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: index.html");
    exit();
}
?>

