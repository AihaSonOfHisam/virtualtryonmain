<?php
// Get the shirt color from the query parameter
$shirtColor = $_GET['shirt'] ?? 'whiteTshirt'; // Default to 'whiteTshirt' if no color is provided

// Define the image sources based on the shirt color
$shirtImages = [
    'whiteTshirt' => 'images/T-shirt.png',
    'blackTshirt' => 'images/black-tshirt.png',
    'blueTshirt' => 'images/blue-tshirt.png',
    'blackHoodie' => 'images/Hoodie.png',
    'blueHoodie' => 'images/Blue-Hoodie.png',
    'whiteHoodie' => 'images/White-Hoodie.png',
    'whiteCasual' => 'images/Casual.png',
    'blackCasual' => 'images/Black-Casual.png',
    'blueCasual' => 'images/Blue-Casual.png'
];

// Set the image source for the selected shirt
$shirtImageSrc = isset($shirtImages[$shirtColor]) ? $shirtImages[$shirtColor] : $shirtImages['whiteTshirt'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try On</title>
    <link rel="stylesheet" href="tryon_style.css">
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
            <li><a href="index.html">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php" class="active">Virtual Try On</a></li>
            <li><a href="#">Review</a></li>
        </ul>
    </nav>

    <!-- Main Content Section -->
    <main>
        <div class="model-display">
            <div class="model">
                <button class="upload-btn">Upload Image</button>
            </div>
            <div class="model" id="shirt-image">
                <img id="shirt-img" src="<?php echo $shirtImageSrc; ?>" alt="Shirt" />
            </div>
            <div class="model">
                <button class="upload-btn">Upload Different Cloth</button>
                <button class="run-btn">Run</button>
            </div>
        </div>
    </main>
</body>
</html>
