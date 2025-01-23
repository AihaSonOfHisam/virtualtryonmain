<?php
// Include the database connection file
include '../component/connect.php';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $categoryID = $_POST['categoryID'];
    $description = $_POST['description'];
    $itemImage = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];

    // Define the upload directory
    $uploadDir = 'resources/img/';
    $targetFile = $uploadDir . basename($itemImage);
    
    // Validate inputs
    if (empty($categoryID) || empty($description) || empty($itemImage)) {
        echo "All fields are required!";
        exit;
    }

    // Validate the image type and size
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExtension = strtolower(pathinfo($itemImage, PATHINFO_EXTENSION));

    // Check if the file has a valid extension
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        exit;
    }

    // Check the file size (5MB max)
    if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
        echo "The image file is too large. Maximum size is 5MB.";
        exit;
    }

    // Fetch categoryName based on categoryID
    $categoryQuery = "SELECT categoryName FROM category WHERE categoryID = ?";
    $stmtCategory = $conn->prepare($categoryQuery);
    $stmtCategory->bind_param("i", $categoryID);
    $stmtCategory->execute();
    $stmtCategory->bind_result($categoryName);
    $stmtCategory->fetch();
    $stmtCategory->close();

    if (!$categoryName) {
        echo "Invalid category selected.";
        exit;
    }

    // Upload the image
    if (move_uploaded_file($imageTmp, $targetFile)) {
        // Insert data into the database
        $sql = "INSERT INTO item (categoryID, categoryName, description, itemImage) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $categoryID, $categoryName, $description, $itemImage);

        if ($stmt->execute()) {
            // Redirect to manage-item.php with a success status
            header("Location: manage-item.php?status=success");
            exit;
        } else {
            echo "Error inserting item: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($conn);
?>
