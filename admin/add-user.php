<?php
// Include the database connection file if necessary
include '../component/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Hash the password before storing it for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert new account
    $query = "INSERT INTO account (name, birthday, email, password, status) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("sssss", $name, $birthday, $email, $hashed_password, $status);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to manage-users.php after success
           echo  "<script>
                alert('Add account successfully.');
                window.location.href = 'manage-users.php';
              </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Account</title>
    <link rel="stylesheet" href="resources/css/add-user.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <h1>Admin</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage-users.php" class="active">Account</a></li>
                <li><a href="manage-category.php">Category</a></li>
                <li><a href="manage-item.php">Item</a></li>
                <li><a href="manage-review.php">Review</a></li>
                <li><a href="tryon.php">Try On</a></li>
                <li><a href="../user/login.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Add New Account</h1>
        </header>

        <!-- Add User Form -->
        <section id="add-user">
            <div class="add-user-form">
                <form action="add-user.php" method="POST">
                    <!-- Name -->
                    <div class="input-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <!-- Birthday -->
                    <div class="input-group">
                        <label for="birthday">Birthday:</label>
                        <input type="date" id="birthday" name="birthday" required>
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <!-- Status -->
                    <div class="input-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                    <button type="submit" class="submit-btn">Add Account</button>
                    <a href="manage-users.php" class="cancel-link">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
    
    <footer>
        <p>&copy; 2024 Virtual Try-on Admin</p>
    </footer>
</body>
</html>
