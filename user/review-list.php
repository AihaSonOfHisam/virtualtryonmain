<?php
// Start session and include the database connection file
session_start();
include 'connection.php';

// Fetch all reviews from the database
$query = "SELECT * FROM review";
$result = $conn->query($query);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review List Page</title>
    <link rel="stylesheet" href="index-style.css">
    <link rel="stylesheet" href="review.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search By Typing Keywords...">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="account">
            <img src="images/account-logo.png" alt="Account">
            <a href="userprofile.php"><span>Account</span> </a>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php" class="active">Review</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        <section class="review-list">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="review-card">
                        <div class="user-info">
                            <span><?php echo htmlspecialchars($row['custName']); ?></span>
                        </div>
                        <div class="stars">
                            <?php 
                            // Display the rating as stars
                            for ($i = 0; $i < $row['rating']; $i++) {
                                echo "★";
                            }
                            ?>
                        </div>
                        <img class="review-image" src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Review Image">
                        <p><?php echo htmlspecialchars($row['descReview']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
