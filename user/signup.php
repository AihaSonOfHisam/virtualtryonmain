<?php
// Database connection settings
include 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Prepare and insert into account table
    $stmt1 = $conn->prepare("INSERT INTO account (name, email, birthday, password, status) VALUES (?, ?, ?, ?, 'user')");
    $stmt1->bind_param("ssss", $fullname, $email, $birthday, $password);

    // Prepare and insert into customer table
    $stmt2 = $conn->prepare("INSERT INTO customer (custName, email, birthday, password) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $fullname, $email, $birthday, $password);

    if ($stmt1->execute() && $stmt2->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Virtual Try On</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="images/logo.png" alt="Virtual Try On Logo" class="logo">
            <h1>Virtual Try On</h1>
        </div>
        <div class="right-section">
            <h2>Sign Up</h2>
            <form action="signup.php" method="POST">
                <label for="fullname">Full Name*</label>
                <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>
                
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" placeholder="Email Address" required>
                
                <label for="birthday">Birthdate</label>
                <input type="date" id="birthday" name="birthday" placeholder="dd/mm/yyyy">
                
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                
                <button type="submit" class="btn">Register</button>
                <a href="login.php" class="guest-link" style="align-self: center;">Back to Login</a>
            </form>
        </div>
    </div>
</body>
</html>
