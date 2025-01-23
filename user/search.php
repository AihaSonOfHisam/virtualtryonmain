<?php
// Include database connection
include '../component/connect.php'; // Adjust the path as needed

// Initialize search result
$result = false;
$query = "";

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = trim($_GET['query']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM category WHERE categoryName LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="category-styles.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo">
        </div>
        <div class="search-bar">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search By Typing Keywords..." value="<?php echo htmlspecialchars($query); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="account">
            <a href="userprofile.php" class="account-link">
                <img src="images/account-logo.png" alt="Account Icon">
                <span>Account</span>
            </a>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        <h2>Search Results</h2>
        <div class="category-display">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <a href="category-items.php?categoryID=<?php echo $row['categoryID']; ?>" class="category-item">
                        <img src="../admin/resources/img/<?php echo htmlspecialchars($row['categoryImage']); ?>" alt="<?php echo htmlspecialchars($row['categoryName']); ?>">
                        <p><?php echo htmlspecialchars($row['categoryName']); ?></p>
                    </a>
                <?php }
            } elseif (!empty($query)) {
                echo "<p>No results found for: <strong>" . htmlspecialchars($query) . "</strong>.</p>";
            } else {
                echo "<p>Type a keyword to search categories.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Virtual Try On</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
if ($result) {
    $stmt->close();
}
$conn->close();
?>
