<?php
// Include the database connection file
include '../component/connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user data from the form
    $user_id = $_POST['user-id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $status = $_POST['status'];

    // Prepare the update query
    $query = "UPDATE account SET name = ?, email = ?, birthday = ?, status = ? WHERE id = ?";

    // Check if the query is prepared successfully
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("ssssi", $name, $email, $birthday, $status, $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the manage-users page after successful update
            header("Location: manage-users.php?message=User updated successfully");
            exit;
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
    echo "Invalid request method.";
    exit;
}
?>
