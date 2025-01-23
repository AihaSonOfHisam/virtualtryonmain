<?php
// Include the database connection file
include '../component/connect.php';

// Fetch all try-on records
$query = "SELECT tryonID, photoImage, clothImage, itemID FROM tryon";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching try-on data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Try-On</title>
    <link rel="stylesheet" href="resources/css/tryon.css">
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
                <li><a href="manage-item.php">Item</a></li>
                <li><a href="tryon.php" class="active">Try-On</a></li>
                <li><a href="manage-review.php">Review</a></li>
                <li><a href="../user/login.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Manage Try-On</h1>
        </header>

        <main>

            <!-- Try-On Table -->
            <table class="item-table">
                <thead>
                    <tr>
                        <th>Try-On ID</th>
                        <th>Photo Image</th>
                        <th>Cloth Image</th>
                        <th>Item ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['tryonID']; ?></td>
                            <td>
                                <img src="resources/img/<?php echo htmlspecialchars($row['photoImage']); ?>" alt="Photo">
                            </td>
                            <td>
                                <img src="resources/img/<?php echo htmlspecialchars($row['clothImage']); ?>" alt="Cloth">
                            </td>
                            <td><?php echo htmlspecialchars($row['itemID']); ?></td>
                            <td>
                                
                                <a href="delete-tryon.php?id=<?php echo $row['tryonID']; ?>" onclick="return confirm('Are you sure you want to delete this try-on record?')">
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
