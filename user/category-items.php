<?php
// Include the database connection file
include '../component/connect.php';

// Check if categoryID is passed in the URL
if (isset($_GET['categoryID'])) {
    $categoryID = $_GET['categoryID'];

    // Fetch category name
    $categoryQuery = "SELECT categoryName FROM category WHERE categoryID = $categoryID";
    $categoryResult = mysqli_query($conn, $categoryQuery);

    if (!$categoryResult) {
        die("Error fetching category: " . mysqli_error($conn));
    }

    $category = mysqli_fetch_assoc($categoryResult);
    $categoryName = $category['categoryName'];

    // Fetch items for the selected category
    $query = "
        SELECT 
            item.itemID, 
            item.description, 
            item.itemImage 
        FROM item 
        WHERE item.categoryID = $categoryID";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching items: " . mysqli_error($conn));
    }
} else {
    // Redirect to categories page if no category selected
    header("Location: category.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items in <?php echo htmlspecialchars($categoryName); ?> Category</title>
    <link rel="stylesheet" href="category-items.css">
</head>
<body>
    <header>
        <!-- Your header content -->
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

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php" class="active">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>

    <main>
        <h1><?php echo htmlspecialchars($categoryName); ?> Category</h1>

        <div class="items-display">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="item">
                    <img src="../admin/resources/img/<?php echo $row['itemImage']; ?>" alt="Item Image" width="150">
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <a href="item-detail.php?itemID=<?php echo $row['itemID']; ?>&categoryID=<?php echo $categoryID; ?>">View Details</a>

                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
