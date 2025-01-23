<?php
// Include database connection
include '../component/connect.php'; // Adjust the path to include 'admin/'

// Fetch categories from the database
$query = "SELECT * FROM category";
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
    <title>Category Page</title>
    <link rel="stylesheet" href="category-styles.css"> <!-- Adjusted path to CSS -->
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo"> <!-- Adjusted path to logo -->
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search By Typing Keywords...">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="account">
            <a href="userprofile.php" class="account-link">
                <img src="images/account-logo.png" alt="Account Icon"> <!-- Adjusted path to account logo -->
                <a href="userprofile.php"><span>Account</span> </a>
            </a>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php" class="active">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
         <div class="category-display">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <a href="category-items.php?categoryID=<?php echo $row['categoryID']; ?>" class="category-item">
                    <img src="../admin/resources/img/<?php echo $row['categoryImage']; ?>" alt="<?php echo htmlspecialchars($row['categoryName']); ?>">
                    <p><?php echo htmlspecialchars($row['categoryName']); ?></p>
                </a>
            <?php } ?>
        </div>
    </main>

    <footer>
        <center><p>&copy; 2024 Virtual Try On</p></center>
    </footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
