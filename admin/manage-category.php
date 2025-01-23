<?php
include '../component/connect.php'; // Include your database connection

// Fetch data from the category table
$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching categories: " . mysqli_error($conn));
}

// Check for success status in the URL
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo "<script>alert('Category added successfully!');</script>";
}

// Check for success status in the URL
if (isset($_GET['status']) && $_GET['status'] == 'updated') {
    echo "<script>alert('Category updated successfully!');</script>";
}

// Check for success status in the URL
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'deleted') {
        echo "<script>alert('Category deleted successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="resources/css/manage-category.css"> <!-- Adjust path as necessary -->
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
            <h1>Manage Categories</h1>
        </header>

        <main>
            <!-- Add Category Button -->
            <div class="add-category-btn">
                <a href="add-category.php" class="add-category-link">Add New Category</a>
            </div>

            <!-- Category Table -->
            <table class="category-table">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['categoryID']; ?></td>
                            <td><?php echo $row['categoryName']; ?></td>
                            <td><img src="resources/img/<?php echo $row['categoryImage']; ?>" alt="Category Image" width="50"></td>
                            <td>
                                <a href="edit-category.php?categoryID=<?php echo $row['categoryID']; ?>">
                                    <button class="edit-btn">Edit</button>
                                </a>
                                <button class="delete-btn" onclick="deleteCategory(<?php echo $row['categoryID']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </main>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-on Admin</p>
    </footer>

    <script>
        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                window.location.href = 'delete-category.php?id=' + id;
            }
        }
    </script>
</body>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>
