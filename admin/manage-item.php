<?php
// Include the database connection file
include '../component/connect.php';

// Fetch all items and their category names
$query = "
    SELECT 
        item.itemID, 
        item.description, 
        item.itemImage,
        category.categoryName 
    FROM item 
    INNER JOIN category 
    ON item.categoryID = category.categoryID";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching items: " . mysqli_error($conn));
}

// Check if the status is set in the URL
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'success') {
        echo "<script>alert('Item successfully added!');</script>";
    } elseif ($status == 'error') {
        echo "<script>alert('Error adding item. Please try again.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <link rel="stylesheet" href="resources/css/manage-item.css">
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
            <h1>Manage Items</h1>
        </header>

        <!-- Success Notification -->
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
            <div class="notification success">
                <p>Item deleted successfully!</p>
            </div>
        <?php endif; ?>

        <div class="add-item-btn">
            <a href="add-item.php">Add New Item</a>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['itemID']; ?></td>
                        <td><?php echo htmlspecialchars($row['categoryName']); ?></td>
                        <td><img src="resources/img/<?php echo $row['itemImage']; ?>" alt="Item Image" width="100"></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <a href="edit-item.php?item-id=<?php echo $row['itemID']; ?>">
                                <button class="edit-btn">Edit</button>
                            </a>
                            <button class="delete-btn" onclick="deleteItem(<?php echo $row['itemID']; ?>)">Delete</button>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-on Admin</p>
    </footer>

    <script>
        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                window.location.href = 'delete-item.php?item-id=' + id;
            }
        }
    </script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
