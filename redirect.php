<?php
// Include the connection file
require "./PHP/connection.php";
// Check if the 'customer_id' parameter is set in the URL
if (isset($_GET['customer_id'])) {
    // Get the customer ID from the URL
    $userID = $_GET['customer_id'];

    // Establish database connection
    $conn = new mysqli("localhost", "root", "12345678", "CCC");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Debugging output
    echo "User ID: " . $userID;

    // Update the checker value in the database
    $query = "UPDATE consumer SET checker = 1 WHERE customer_id = $userID";

    if ($conn->query($query) === TRUE) {
        $conn->close();  // Close the connection before redirecting
        // Redirect back to register.php or another confirmation page
        header("Location: http://localhost/e-shop-c/register.php");
        exit();
    } else {
        $conn->close();  // Close the connection before displaying error
        echo "Error updating checker value: " . $conn->error;
        exit();
    }
} else {
    // Handle the case where 'customer_id' is not set in the URL
    echo "Invalid request. 'customer_id' not set.";
    exit();
}
?>
