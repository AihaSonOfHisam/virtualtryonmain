<?php
session_start();

// Include the database connection
include 'connection.php';

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['custID'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Fetch user data based on custID
$custID = $_SESSION['custID'];
$query = "SELECT custName, email, birthday FROM customer WHERE custID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $custID);
$stmt->execute();
$stmt->bind_result($custName, $email, $birthday);
$stmt->fetch();
$stmt->close();

// Check if the form is submitted and update user profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newCustName = htmlspecialchars($_POST['custName']);
    $newEmail = htmlspecialchars($_POST['email']);
    $newBirthday = htmlspecialchars($_POST['birthday']);
    $newPassword = htmlspecialchars($_POST['password']); // Handle password securely

    // Optionally, you can update the user's data here
    $updateQuery = "UPDATE customer SET custName = ?, email = ?, birthday = ?, password = ? WHERE custID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $newCustName, $newEmail, $newBirthday, $newPassword, $custID);
    
    if ($stmt->execute()) {
        echo '<script>alert("Profile updated successfully!"); window.location.href = "userprofile.php";</script>';
    } else {
        echo "Error updating profile.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="userprofile-style.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        
        <div class="profile-box">
            <div class="form-section">
                <h1>User Profile</h1>
                <form action="userprofile.php" method="POST">
                    <label for="custName">Username</label>
                    <input type="text" id="custName" name="custName" value="<?php echo htmlspecialchars($custName); ?>">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <label for="birthday">Date of Birth</label>
                    <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>">

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="********">

                    <button type="submit" class="update-btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
