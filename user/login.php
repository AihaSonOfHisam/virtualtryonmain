<?php
// Assuming you have a database connection file included
include 'connection.php';
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the account table to get the password, id, and status
    $stmt = $conn->prepare("SELECT id, password, status FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the email exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password']; // The hashed password stored in the database
        $status = $row['status']; // User status (e.g., admin or customer)

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // Store session variables
            $_SESSION['id'] = $row['id']; // Store the account ID in the session
            $_SESSION['status'] = $status; // Store the user status (admin or customer)
            // After successful login
            $_SESSION['id'] = $userData['custID'];  // Set customer ID to session


            // Redirect based on user status
            if ($status === 'admin') {
                header("Location: ../admin/index.php"); // Admin page
                exit();
            } else {
                header("Location: index.php"); // Regular user page
                exit();
            }
        } else {
            $error_message = "Invalid email or password!";
        }
    } else {
        $error_message = "Invalid email or password!";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try On - Login</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">

        <div class="form-box login">

            <form action="login.php" method="post">

                <div class="logo">
                    <img src="images/logo.png" />
                </div>

                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="email" placeholder="Email Address" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bx-lock-alt'></i>
                </div>
              

                <button type="submit" class="btn">Login</button>
                
                <?php
                if (isset($error_message)) {
                    echo "<p style='color:red;'>$error_message</p>";
                }
                ?>

            </form>
        </div>

        <div class="form-box register">
            <form action="signup.php" method="POST">
                <div class="logo">
                    <img src="images/logo.png" />
                </div>

                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" name="fullname" placeholder="Full Name" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <input type="text" name="email" placeholder="Email Address" required>
                    <i class='bx bxs-envelope'></i>
                </div>

                <div class="input-box">
                    <input type="date" name="birthdate" placeholder="dd/mm/yyyy" required>
                    <i class='bx bxs-calendar'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bx-lock-alt'></i>
                </div>
                
                <button type="submit" class="btn">Register</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Welcome!</h1>
                <p>Don't have an account?</p>
                <a href="signup.php">
                    <button class="btn register-btn">Register</button>
                </a>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Welcome!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>

    </div>

    <script src="login.js"></script>
</body>
</html>
