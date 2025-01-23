<?php
// Include the database connection file
include '../component/connect.php';

// Check if tryonID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $tryonID = $_GET['id'];

    // Prepare delete statement to avoid SQL injection
    $query = "DELETE FROM tryon WHERE tryonID = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $tryonID);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back with a success message
            echo "<script>
            alert('tryon deleted successfully.');
            window.location.href = 'tryon.php';
          </script>";
        } else {
            // Redirect back with an error message
            header("Location: tryon.php?message=Error deleting try-on record.");
            exit();
        }
    } else {
        // Redirect back if there's an issue preparing the statement
        header("Location: tryon.php?message=Database query failed.");
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect if no valid ID is provided
    header("Location: tryon.php?message=Invalid request.");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
