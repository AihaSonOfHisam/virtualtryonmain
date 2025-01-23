<?php
include '../component/connect.php'; // Include the database connection

// Get the category ID from the URL
if (isset($_GET['id'])) {
    $categoryID = $_GET['id'];
    
    // Check if the category exists in the database
    $checkQuery = "SELECT * FROM category WHERE categoryID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the category
        $deleteQuery = "DELETE FROM category WHERE categoryID = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $categoryID);
        if ($deleteStmt->execute()) {
            // Redirect with a success message
            header("Location: manage-category.php?status=deleted");
            exit;
        } else {
            echo "Error deleting category.";
        }
    } else {
        echo "Category not found.";
    }
}
?>
