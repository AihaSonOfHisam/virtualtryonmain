<?php
// Include the database connection file
include '../component/connect.php';
session_start();

// Check if itemID is passed in the URL and sanitize it
if (isset($_GET['itemID']) && is_numeric($_GET['itemID'])) {
    $itemID = $_GET['itemID'];

    // Query to fetch item details
    $query = "
        SELECT 
            item.itemID, 
            item.description, 
            item.itemImage, 
            category.categoryName 
        FROM item 
        INNER JOIN category 
        ON item.categoryID = category.categoryID 
        WHERE item.itemID = $itemID";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching item details: " . mysqli_error($conn));
    }

    // Fetch the item details
    $item = mysqli_fetch_assoc($result);

    // Check if the item exists
    if (!$item) {
        echo "Item not found.";
        exit;
    }
} else {
    // Redirect to categories page if no valid itemID is provided
    header("Location: category.php");
    exit();
}

// Handle Add to Try-On action
if (isset($_POST['add_to_tryon'])) {
    // Get the itemID of the item being added to the try-on session
    $itemID = $item['itemID'];  // Get the itemID
    $clothImage = $item['itemImage'];  // The item image being added to the try-on session (cloth image)

    // Insert the item into the tryon table with the itemID and clothImage (tryonID is auto-incremented by DB)
    $tryonQuery = "
        INSERT INTO tryon (itemID, clothImage) 
        VALUES ('$itemID', '$clothImage')
    ";

    if (mysqli_query($conn, $tryonQuery)) {
        // Redirect to tryon.php after adding the item, and fetch the tryonID (auto-incremented)
        $tryonID = mysqli_insert_id($conn);  // Get the auto-incremented tryonID

        // Redirect with tryonID to tryon.php
        header("Location: tryon.php?tryonID=$tryonID");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details - <?php echo htmlspecialchars($item['description']); ?></title>
    <link rel="stylesheet" href="item-detail.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo">
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search By Typing Keywords...">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="account">
            <a href="userprofile.php" class="account-link">
                <img src="images/account-logo.png" alt="Account Icon">
                <a href="userprofile.php"><span>Account</span> </a>
            </a>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>

    <main>
        <h1>Item Details</h1>
        
        <div class="item-details">
            <img src="../admin/resources/img/<?php echo $item['itemImage']; ?>" alt="Item Image" class="item-image">
            <div class="item-info">
                <h2><?php echo htmlspecialchars($item['description']); ?></h2>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($item['categoryName']); ?></p>
                <div class="item-description">
                    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                </div>
            </div>
        </div>

        <!-- Add to Try-On Button -->
        <form method="post" action="item-detail.php?itemID=<?php echo $item['itemID']; ?>">
            <input type="hidden" name="itemImage" value="<?php echo $item['itemImage']; ?>" />
            <button type="submit" name="add_to_tryon">Add to Try-On</button>
        </form>

        <!-- Back Button -->
        <div class="action-buttons">
            <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="back-btn">Back to Previous Page</a>
        </div>
    </main>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
