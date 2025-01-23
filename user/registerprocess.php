<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <center>

    <?php
    require_once('../../connection.php');

    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'];

    // Insert the new user into the accounts table
    $query = "INSERT INTO account (name, email, birthday, password, status) VALUES ('$fullname', '$email', '$birthdate', '$password', 'user')";
    if (mysqli_query($connection, $query)) {
        // Start session and set session variables
        session_start();
        $_SESSION['email'] = $email;

        // Redirect to user index page
        header("Location: /virtual-try-on/user/index.php");
        exit();
    } else {
        // Error occurred, display an error message
        echo '<script>alert("Registration failed! Please try again."); window.location.href = "login.html";</script>';
    }
    ?>

    </center>
</body>
</html>