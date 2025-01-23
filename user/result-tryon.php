<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try On</title>
    <link rel="stylesheet" href="tryon-style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search By Typing Keywords...">
        </div>
        <div class="account">
            <a href="userprofile.php" class="account-link">
                <img src="images/account-logo.png" alt="Account Icon">
                <span>Account</span>
            </a>
        </div>
    </header>

    <!-- Navigation Section -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php" class="active">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>

    <!-- Main Content Section -->
    <div class="display">
        <div class="image-container">
            <img src="images/images.jpg" alt="Result" class="models-image">
            <!-- Save Button under the image, aligned to the right -->
            <a href="images/images.jpg" download="virtual_try_on_result.jpg">
               <button class="save-btn">Save Image</button>
            </a>
        </div>
    </div>
</body>
</html>
