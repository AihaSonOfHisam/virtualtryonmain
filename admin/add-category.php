<?php
// Include the database connection file
require_once '../component/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $category_name = $_POST['category_name'];
    $category_image = $_FILES['category_image']['name'];
    $category_image_tmp = $_FILES['category_image']['tmp_name'];

    // Set the upload directory
    $upload_dir = 'resources/img/';
    $target_file = $upload_dir . basename($category_image);
    


    // Upload the image
    if (move_uploaded_file($category_image_tmp, $target_file)) {
        // Insert the data into the database
        $sql = "INSERT INTO category (categoryName, categoryImage) 
                VALUES ('$category_name', '$category_image')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to manage category page with a success message
            header('Location: manage-category.php?status=success');
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your image.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="resources/css/add-category.css">
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
            <h1>Add Category</h1>
        </header>
        <form class="add-category-form" action="add-category.php" method="POST" enctype="multipart/form-data">
            <h2>Add New Category</h2>
            
            <div class="form-group">
                <label for="category-name">Category Name</label>
                <input type="text" id="category-name" name="category_name" placeholder="Enter category name" required>
            </div>
            <div class="form-group">
                <label for="category-image">Category Image</label>
                <input type="file" id="category-image" name="category_image" accept="image/*" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="save-btn">Add</button>
                <a href="manage-category.php" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-On Admin</p>
    </footer>
</body>
</html>
