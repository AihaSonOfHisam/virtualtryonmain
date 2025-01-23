<?php
// Include the database connection file
include '../component/connect.php'; 

// Fetch category_id from URL query string (GET request)
if (isset($_GET['categoryID'])) {
    $categoryID = $_GET['categoryID'];
    
    // Query to get category details based on categoryID
    $sql = "SELECT * FROM category WHERE categoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryID);  // "i" stands for integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if category exists
    if ($result->num_rows > 0) {
        // Fetch the category details
        $category = $result->fetch_assoc();
        $categoryName = $category['categoryName'];
        $categoryImage = $category['categoryImage'];
    } else {
        echo "Category not found.";
        exit;
    }
} else {
    echo "Category ID is required.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="resources/css/edit-category.css">
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
                <li><a href="manage-category.php" class="active">Category</a></li>
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
            <h1>Edit Category</h1>
        </header>
        <form class="edit-category-form" action="update-category.php" method="POST" enctype="multipart/form-data">
            <h2>Edit Existing Category</h2>
            <div class="form-group">
                <label for="categoryID">Category ID</label>
                <input type="text" id="categoryID" name="categoryID" value="<?php echo $categoryID; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($categoryName); ?>" required>
            </div>
            <div class="form-group">
                <label for="categoryImage">Category Image</label>
                <input type="file" id="categoryImage" name="categoryImage" accept="image/*">
                <p class="hint">Leave blank if you don't want to change the image.</p>
            </div>
            <div class="form-actions">
                <button type="submit" class="save-btn">Save Changes</button>
                <a href="manage-category.php" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-On Admin</p>
    </footer>

    <?php $conn->close(); ?>
</body>
</html>
