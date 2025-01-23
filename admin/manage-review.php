<?php
// Include the database connection file
include '../component/connect.php';

// Fetch all reviews from the database
$query = "SELECT reviewID, custName, rating, image, descReview FROM review";
$result = mysqli_query($conn, $query);



if (!$result) {
    die("Error fetching reviews: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="resources/css/manage-review.css">
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
                <li><a href="manage-review.php" class="active">Review</a></li>
                <li><a href="tryon.php">Try On</a></li>
                <li><a href="../user/login.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Manage Reviews</h1>
        </header>

        <!-- Review Table -->
        <table class="review-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Rating</th>
                    <th>Image</th>
                    <th>Review</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['reviewID']; ?></td>
                        <td><?php echo htmlspecialchars($row['custName']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        <td>
                            <?php if ($row['image']) { ?>
                                <img src="resources/img/<?php echo htmlspecialchars($row['image']); ?>" alt="Review Image" style="width: 60px; height: auto; border-radius: 5px;">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['descReview']); ?></td>
                        <td>
                            <div class="actions">
                             <a href="delete-review.php?id=<?php echo (int)$row['reviewID']; ?>" 
                             onclick="return confirm('Are you sure you want to delete this review?')">
                             <button class="delete-btn">Delete</button>
</a>

                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Admin Panel</p>
    </footer>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
