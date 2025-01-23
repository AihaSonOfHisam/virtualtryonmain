<?php
// Include the database connection file
include '../component/connect.php';

// Check if the review ID is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $reviewID = $_GET['id'];

    // Prepare the delete query using prepared statements for security
    $stmt = $conn->prepare("DELETE FROM review WHERE reviewID = ?");
    $stmt->bind_param("i", $reviewID);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        echo "<script>
                alert('Review deleted successfully!');
                window.location.href = 'manage-review.php';
              </script>";
        exit();
    } else {
        $stmt->close();
        mysqli_close($conn);
        echo "<script>
                alert('Failed to delete review. Please try again.');
                window.location.href = 'manage-review.php';
              </script>";
        exit();
    }
} else {
    // If no valid ID, show error message and redirect
    echo "<script>
            alert('Invalid review ID.');
            window.location.href = 'manage-review.php';
          </script>";
    exit();
}
?>
