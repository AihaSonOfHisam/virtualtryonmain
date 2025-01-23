<?php
// Include the database connection file
include '../component/connect.php';

// Function to validate image files
function validate_image($image) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    $file_ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $file_size = $image['size'];
    $file_tmp = $image['tmp_name'];

    // Validate file type
    if (!in_array(strtolower($file_ext), $allowed_extensions)) {
        return 'Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.';
    }

    // Validate file size
    if ($file_size > $max_size) {
        return 'File size exceeds the 5MB limit.';
    }

    // Validate the file content (this is optional for added security)
    if (getimagesize($file_tmp) === false) {
        return 'File is not a valid image.';
    }

    return null; // No errors
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = '../admin/resources/img/';
    
    // Handle user image upload
    $userImage = !empty($_FILES['user-image']['name']) ? basename($_FILES['user-image']['name']) : '';
    if ($userImage) {
        $userImagePath = $uploadDir . $userImage;
        move_uploaded_file($_FILES['user-image']['tmp_name'], $userImagePath);
    }

    // Handle clothing image upload and replacement
    $clothImageError = null;
    if (!empty($_FILES['clothing-image']['name'])) {
        $clothImageError = validate_image($_FILES['clothing-image']);
        
        if ($clothImageError === null) {
            // Fetch the current clothing image path from the database using tryonID
            if (isset($_POST['tryonID']) && is_numeric($_POST['tryonID'])) {
                $tryonID = $_POST['tryonID'];

                // Remove the old clothImage from the database
                $updateQuery = "UPDATE tryon SET clothImage = NULL WHERE tryonID = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("i", $tryonID);
                $stmt->execute();
                $stmt->close();
            }

            // Sanitize and upload the new clothing image
            $clothImage = basename($_FILES['clothing-image']['name']);
            $clothImage = preg_replace("/[^a-zA-Z0-9\-_\.]/", "_", $clothImage); // Sanitize file name
            $clothImagePath = $uploadDir . $clothImage;

            // Move the uploaded file to the server
            move_uploaded_file($_FILES['clothing-image']['tmp_name'], $clothImagePath);

            // Update the tryon table with the new image path
            $updateQuery = "UPDATE tryon SET clothImage = ? WHERE tryonID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("si", $clothImage, $tryonID);
            $stmt->execute();
            $stmt->close();
        } else {
            echo $clothImageError; // Show error if the image is invalid
        }
    }

    // Handle other form data such as itemID (optional)
    $itemID = isset($_POST['itemID']) && is_numeric($_POST['itemID']) ? $_POST['itemID'] : 'NULL';

    // Insert the data into the tryon table if a new record is created
    $query = "INSERT INTO tryon (photoImage, clothImage, itemID) VALUES ('$userImage', '$clothImage', $itemID)";
    if (mysqli_query($conn, $query)) {
        // Get the tryonID of the newly inserted record
        $newTryonID = mysqli_insert_id($conn);
        // Redirect to the same page with the tryonID in the URL
        header("Location: tryon.php?tryonID=" . $newTryonID);
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Check if tryonID is passed in the URL for retrieving the image
if (isset($_GET['tryonID']) && is_numeric($_GET['tryonID'])) {
    $tryonID = $_GET['tryonID'];

    // Fetch the clothImage corresponding to the tryonID from the tryon table
    $query = "SELECT clothImage FROM tryon WHERE tryonID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tryonID);
    $stmt->execute();
    $stmt->bind_result($clothImage);
    $stmt->fetch();
    $stmt->close();

    // Check if a clothImage was found
    if ($clothImage) {
        $clothImagePath = '../admin/resources/img/' . $clothImage;
    } else {
        $clothImagePath = ''; // Set a default or error path if no image found
    }
}
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
    <main>
        <div class="model-display">
            <!-- User Image Upload -->
            <div class="model">
                <input type="file" id="user-image" name="user-image" accept="image/*" />
                <img id="uploaded-img" alt="Uploaded User Image" />
            </div>

            <!-- Clothing Image Upload -->
            <div class="model">
                <input type="file" id="clothing-image" name="clothing-image" accept="image/*" />
                <img id="clothing-img-preview" alt="Clothing Image" />

                <!-- Display the fetched clothing image if it exists -->
                <?php if (isset($clothImagePath) && !empty($clothImagePath)): ?>
                    <img src="<?php echo $clothImagePath; ?>" alt="Selected Clothing" />
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="model">
            
                    <a href="result-tryon.php">
                    <input type="submit" class="run-btn" value="Save & Try On" />
            
                </a>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Preview uploaded user image
        document.getElementById('user-image').addEventListener('change', function(event) {
            const img = document.getElementById('uploaded-img');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Preview uploaded clothing image
        document.getElementById('clothing-image').addEventListener('change', function(event) {
            const img = document.getElementById('clothing-img-preview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
