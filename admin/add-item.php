<?php
// Include the database connection file
include '../component/connect.php';

// Fetch all categories from the database
$query = "SELECT categoryID, categoryName FROM category";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching categories: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="resources/css/add-item.css">>
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
                <li><a href="manage-users.php">Account</a></li>
                <li><a href="manage-category.php">Category</a></li>
                <li><a href="manage-item.php" class="active">Item</a></li>
                <li><a href="manage-review.php">Review</a></li>
                <li><a href="tryon.php">Try On</a></li>
                <li><a href="../user/login.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Add Item</h1>
        </header>
        <form class="add-item-form" action="save-item.php" method="POST" enctype="multipart/form-data">
            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="categoryID" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['categoryID']; ?>">
                            <?php echo htmlspecialchars($row['categoryName']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Enter item description" required></textarea>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="save-btn">Add</button>
                <a href="manage-item.php" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Admin Panel</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
