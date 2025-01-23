<?php
// Include the database connection file
include '../component/connect.php';

// Check if the user ID is provided
if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $user_id = $_GET['id'];

    // Prepare the delete query
    $query = "DELETE FROM account WHERE id = ?";

    // Check if the query is prepared successfully
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param("i", $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the manage-users page with a success message
            echo "<script>
                alert('delete successfully!');
                window.location.href = 'manage-users.php';
              </script>"; 
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No user ID provided!";
    exit;
}
?>
