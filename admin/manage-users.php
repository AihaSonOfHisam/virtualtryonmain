<?php
// Include the database connection file
include '../component/connect.php';

// Fetch all accounts
$query = "SELECT id, name, birthday, email, password, status FROM account";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching users: " . mysqli_error($conn));
}

if (isset($_GET['message'])) {
    echo "<p>" . $_GET['message'] . "</p>";
}

if (isset($_GET['message'])) {
    echo "<script>
                alert('edit successfully!');
                window.location.href = 'manage-users.php';
              </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="resources/css/manage-users.css">
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
            <h1>Manage Account</h1>
        </header>

        <main>
            <!-- Add User Button -->
            <div class="add-user-btn">
                <a href="add-user.php" class="add-user-link">Add New Account</a>
            </div>

          

            <!-- User Table -->
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['birthday']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['password']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="edit-user.php?id=<?php echo $row['id']; ?>">
                                    <button class="edit-btn">Edit</button>
                                </a>
                                <a href="delete-user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <button class="delete-btn">Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </main>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-On Admin</p>
    </footer>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
