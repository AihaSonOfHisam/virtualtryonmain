<?php
// Include your database connection file
include '../component/connect.php'; 

// Fetch itemID from URL query string (GET request)
if (isset($_GET['item-id'])) {
    $itemID = $_GET['item-id'];
    
    // Query to get item details based on itemID
    $sql = "SELECT * FROM item WHERE itemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemID);  // "i" stands for integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if item exists
    if ($result->num_rows > 0) {
        // Fetch the item details
        $item = $result->fetch_assoc();
        $categoryName = $item['categoryName']; // category name
        $categoryID = $item['categoryID'];
        $itemImage = $item['itemImage'];  // Assuming itemImage field exists
        $description = $item['description'];
    } else {
        echo "Item not found.";
        exit;
    }
} else {
    echo "Item ID is required.";
    exit;
}

// Fetch categories for the dropdown menu
$categoryQuery = "SELECT * FROM category";
$categories = $conn->query($categoryQuery);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryID = $_POST['category'];
    $description = $_POST['description'];

    // Handle image upload
    $imagePath = $itemImage; // Keep the old image if no new one is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = '../resources/img/';
        $imageFileName = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageFileName;

        // Move the uploaded file to the resources/img folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'resources/img/' . $imageFileName; // Set the image path for the database
        } else {
            echo "Error uploading image.";
        }
    }

    // Update the item in the database
    $updateQuery = "UPDATE item SET categoryID = ?, description = ?, itemImage = ? WHERE itemID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("isss", $categoryID, $description, $imagePath, $itemID);

    if ($stmt->execute()) {
        
        echo "<script>
                alert('Item edited successfully!');
                window.location.href = 'manage-item.php';
              </script>";
    } else {
        echo "Error updating item: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="resources/css/edit-item.css">
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
            <h1>Edit Item</h1>
        </header>
        <form class="edit-item-form" action="edit-item.php?item-id=<?php echo $itemID; ?>" method="POST" enctype="multipart/form-data">
            <h2>Edit Existing Item</h2>
            <!-- Item ID -->
            <div class="form-group">
                <label for="item-id">Item ID</label>
                <input type="text" id="item-id" name="item-id" value="<?php echo $itemID; ?>" readonly>
            </div>
            
            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $category['categoryID']; ?>" <?php echo ($category['categoryID'] == $categoryID) ? 'selected' : ''; ?>>
                            <?php echo $category['categoryName']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <p class="hint">Leave blank if you don't want to change the image.</p>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="save-btn">Save Changes</button>
                <a href="manage-item.php" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-On Admin</p>
    </footer>

</body>
</html>
