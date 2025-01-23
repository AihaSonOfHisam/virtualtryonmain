<?php
include '../component/connect.php'; // Include your database connection

// Start the session
session_start();

$isLoggedIn = isset($_SESSION['id']);

// Fetch some data for the dashboard (example: total categories, total items, etc.)
$queryCategories = "SELECT COUNT(*) as totalCategories FROM category";
$resultCategories = mysqli_query($conn, $queryCategories);
$totalCategories = mysqli_fetch_assoc($resultCategories)['totalCategories'];

$queryItems = "SELECT COUNT(*) as totalItems FROM item";
$resultItems = mysqli_query($conn, $queryItems);
$totalItems = mysqli_fetch_assoc($resultItems)['totalItems'];

$queryReviews = "SELECT COUNT(*) as totalReviews FROM review";
$resultReviews = mysqli_query($conn, $queryReviews);
$totalReviews = mysqli_fetch_assoc($resultReviews)['totalReviews'];

$queryUsers = "SELECT COUNT(*) as totalUsers FROM account";
$resultUsers = mysqli_query($conn, $queryUsers);
$totalUsers = mysqli_fetch_assoc($resultUsers)['totalUsers'];

// Query for total try-ons
$queryTryOns = "SELECT COUNT(*) as totalTryOns FROM tryon";
$resultTryOns = mysqli_query($conn, $queryTryOns);
$totalTryOns = mysqli_fetch_assoc($resultTryOns)['totalTryOns'];

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="manage-users.php">Account</a></li>
                <li><a href="manage-category.php">Category</a></li>
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
            <h1>Admin Dashboard</h1>
        </header>

        <main>
            <!-- Dashboard Overview -->
            <div class="dashboard-overview">
                <table class="overview-item">
                    <tr>
                        <td>
                            <h2>Total Categories</h2>
                            <p><?php echo $totalCategories; ?></p>
                        </td>
                    </tr>
                </table>
                <table class="overview-item">
                    <tr>
                        <td>
                            <h2>Total Items</h2>
                            <p><?php echo $totalItems; ?></p>
                        </td>
                    </tr>
                </table>
                <table class="overview-item">
                    <tr>
                        <td>
                            <h2>Total Reviews</h2>
                            <p><?php echo $totalReviews; ?></p>
                        </td>
                    </tr>
                </table>
                <table class="overview-item">
                    <tr>
                        <td>
                            <h2>Total Account</h2>
                            <p><?php echo $totalUsers; ?></p>
                        </td>
                    </tr>
                </table>
                <!-- New Try-On Count Section -->
                <table class="overview-item">
                    <tr>
                        <td>
                            <h2>Total Try-Ons</h2>
                            <p><?php echo $totalTryOns; ?></p>
                        </td>
                    </tr>
                </table>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2024 Virtual Try-on Admin</p>
    </footer>
</body>
</html>
