<?php
require_once("cred/config.php");

try {
    // Establishing a connection to MySQL database using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if account_number parameter is provided in the URL
    if(isset($_GET['account_number'])) {
        $account_number = $_GET['account_number'];
        
        // Constructing SQL query to select user details based on account_number
        $sql = "SELECT u.account_number, u.first_name, u.last_name, u.dob, u.address, u.mobile_number, u.aadhaar_number, u.pan_number, a.account_type, a.balance 
                FROM users u 
                JOIN accounts a ON u.account_number = a.account_number
                WHERE u.account_number = :account_number";
        
        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);
        
        // Bind the account_number parameter
        $stmt->bindParam(':account_number', $account_number, PDO::PARAM_STR);
        
        // Execute the SQL statement
        $stmt->execute();
        
        // Fetch the user details
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Display user details
        if ($user) {
            // If the form is submitted for editing
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve form data
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $dob = $_POST['dob'];
                $address = $_POST['address'];
                $mobile_number = $_POST['mobile_number'];
                $aadhaar_number = $_POST['aadhaar_number'];
                $pan_number = $_POST['pan_number'];

                // Update user details in the database
                $update_sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, dob = :dob, address = :address, mobile_number = :mobile_number, aadhaar_number = :aadhaar_number, pan_number = :pan_number WHERE account_number = :account_number";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindParam(':first_name', $first_name);
                $update_stmt->bindParam(':last_name', $last_name);
                $update_stmt->bindParam(':dob', $dob);
                $update_stmt->bindParam(':address', $address);
                $update_stmt->bindParam(':mobile_number', $mobile_number);
                $update_stmt->bindParam(':aadhaar_number', $aadhaar_number);
                $update_stmt->bindParam(':pan_number', $pan_number);
                $update_stmt->bindParam(':account_number', $account_number);
                
                // Execute the update statement
                if ($update_stmt->execute()) {
                    echo "<script>alert('User details updated successfully');</script>";
                    // Refresh the page to reflect the updated details
                    echo "<script>window.location.href='view_user_details.php?account_number=$account_number';</script>";
                } else {
                    echo "<script>alert('Error updating user details');</script>";
                }
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

<h1>User Details</h1>

<form action="" method="post">
    <table border="1">
        <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="first_name" value="<?php echo $user["first_name"]; ?>" required></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last_name" value="<?php echo $user["last_name"]; ?>" required></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><input type="date" name="dob" value="<?php echo $user["dob"]; ?>" required></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><textarea name="address" rows="4" required><?php echo $user["address"]; ?></textarea></td>
            </tr>
            <tr>
                <td>Mobile Number:</td>
                <td><input type="tel" name="mobile_number" pattern="[0-9]{10}" value="<?php echo $user["mobile_number"]; ?>" required></td>
            </tr>
            <tr>
                <td>Aadhaar Number:</td>
                <td><input type="text" name="aadhaar_number" pattern="[0-9]{12}" value="<?php echo $user["aadhaar_number"]; ?>" required></td>
            </tr>
            <tr>
                <td>PAN Number:</td>
                <td><input type="text" name="pan_number" value="<?php echo $user["pan_number"]; ?>" required></td>
            </tr>
            <tr>
                <td>Account Number:</td>
                <td><?php echo $user["account_number"]; ?></td>
            </tr>
            <tr>
                <td>Account Type:</td>
                <td><?php echo $user["account_type"]; ?></td>
            </tr>
            <tr>
                <td>Balance:</td>
                <td>₹<?php echo $user["balance"]; ?></td>
            </tr>
        </tbody>
    </table>
    <input type="submit" value="Save Changes">
</form>

</body>
</html>
<?php
        } else {
            echo "<p>User with account number $account_number not found.</p>";
        }
    } else {
        echo "<p>No account number provided.</p>";
    }
} catch(PDOException $e) {
    // Handling errors
    echo "Error: " . $e->getMessage();
}

// Closing the database connection
$conn = null;
?>

