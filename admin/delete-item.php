<?php
// Start the session
session_start();

// Include the database connection file
include '../component/connect.php'; 

// Check if itemID is set and valid
if (isset($_GET['item-id']) && filter_var($_GET['item-id'], FILTER_VALIDATE_INT)) {
    $itemID = (int)$_GET['item-id'];

   

    // Proceed with deletion if no dependencies found
    $sql = "DELETE FROM item WHERE itemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemID);

    if ($stmt->execute()) {
        echo "<script>
                alert('Item deleted successfully.');
                window.location.href = 'manage-item.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting item: " . addslashes($conn->error) . "');
                window.location.href = 'manage-item.php';
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Invalid item ID.');
            window.location.href = 'manage-item.php';
          </script>";
}

// Close the database connection
$conn->close();
?>
