<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Opening</title>
    <link rel="stylesheet" href="style/account.css"> <!-- Link to the CSS file -->
</head>
<body>

<div class="container">
    <h2>Account Opening Form</h2>
    <form action="process_account_opening.php" method="post" enctype="multipart/form-data">
        <div class="form-box">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" required><br>

            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" required><br>

            <label for="dob">Date of Birth:</label><br>
            <input type="date" id="dob" name="dob" required><br>

            <label for="address">Address:</label><br>
            <textarea id="address" name="address" rows="4" required></textarea><br>

            <!-- Other fields... -->

            <label for="profile_picture">Profile Picture:</label><br>
<div class="file-upload">
    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required onchange="previewImage(this, 'profile_picture_preview')">
    <span class="file-upload-btn">Choose File</span></div>
<br>
<div class="file-upload">
    <button type="button" class="upload-btn" onclick="uploadFile('profile_picture')">Upload</button>
</div><br>
<img id="profile_picture_preview" src="#" alt="Preview" style="display: none;"><br>

            <!-- Other fields... -->

            <label for="signature">Signature:</label><br>
<div class="file-upload">
    <input type="file" id="signature" name="signature" accept="image/*" required onchange="previewImage(this, 'signature_preview')">
    <span class="file-upload-btn">Choose File</span>
</div><br>
<div class="file-upload">
    <button type="button" class="upload-btn" onclick="uploadFile('signature')">Upload</button>
</div><br>
<img id="signature_preview" src="#" alt="Preview" style="display: none;"><br>

            <label for="mobile_number">Mobile Number:</label><br>
            <input type="tel" id="mobile_number" name="mobile_number" pattern="[0-9]{10}" required><br>

            <label for="aadhaar_number">Aadhaar Number:</label><br>
            <input type="text" id="aadhaar_number" name="aadhaar_number" pattern="[0-9]{12}" required><br>

            <label for="pan_number">PAN Number:</label><br>
            <input type="text" id="pan_number" name="pan_number" required><br>

            <input type="submit" value="Open Account">
        </div>
    </form>
</div>

<script src="script.js"></script> <!-- Link to the JavaScript file -->

</body>
</html>

