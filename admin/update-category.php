<?php
// Include the database connection file
require_once '../component/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryID = $_POST['categoryID'];
    $categoryName = $_POST['categoryName'];
    $categoryImage = $_FILES['categoryImage']['name'];
    $categoryImageTmp = $_FILES['categoryImage']['tmp_name'];

    // Check if a new image is uploaded
    if (!empty($categoryImage)) {
        $uploadDir = 'resources/img/';
        $targetFile = $uploadDir . basename($categoryImage);

        // Move uploaded image
        if (move_uploaded_file($categoryImageTmp, $targetFile)) {
            $imagePath = $categoryImage;
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        // Retain the current image if no new one is uploaded
        $sql = "SELECT categoryImage FROM category WHERE categoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryID);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $imagePath = $category['categoryImage'];
    }

    // Update the category in the database
    $sql = "UPDATE category SET categoryName = ?, categoryImage = ? WHERE categoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $categoryName, $imagePath, $categoryID);

    if ($stmt->execute()) {
        // Redirect with success message
        header('Location: manage-category.php?status=updated');
        exit;
    } else {
        echo "Error updating category: " . $conn->error;
    }
}

$conn->close();
?>

