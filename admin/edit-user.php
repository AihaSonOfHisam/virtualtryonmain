<?php
// Include the database connection file
include '../component/connect.php';

// Check if the user ID is provided
if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $user_id = $_GET['id'];

    // Fetch user details from the database
    $query = "SELECT * FROM account WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter and execute the query
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            // Fetch the user data
            $user = $result->fetch_assoc();
        } else {
            echo "User not found!";
            exit;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
        exit;
    }
} else {
    echo "No user ID provided!";
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
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
        <li><a href="index.html">Dashboard</a></li>
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
      <h1>Edit Account</h1>
    </header>

    <main>
      <!-- Edit User Form -->
      <form class="edit-user-form" action="save-user-edit.php" method="POST">
        <!-- User ID (readonly) -->
        <div class="form-group">
          <label for="user-id">User ID</label>
          <input type="text" id="user-id" name="user-id" value="<?php echo $user['id']; ?>" readonly>
        </div>

        <!-- Name -->
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>

        <!-- Birthday -->
        <div class="form-group">
          <label for="birthday">Birthday</label>
          <input type="date" id="birthday" name="birthday" value="<?php echo $user['birthday']; ?>" required>
        </div>

        <!-- Status -->
        <div class="form-group">
          <label for="status">Status</label>
          <select id="status" name="status" required>
            <option value="Admin" <?php echo ($user['status'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="User" <?php echo ($user['status'] == 'User') ? 'selected' : ''; ?>>User</option>
          </select>
        </div>

        <!-- Actions -->
        <div class="form-actions">
          <button type="submit" class="save-btn">Save Changes</button>
          <a href="manage-users.php" class="cancel-link">Cancel</a>
        </div>
      </form>
    </main>
  </div>

  <footer>
    <p>&copy; 2024 Virtual Try-On Admin</p>
  </footer>
</body>
</html>
