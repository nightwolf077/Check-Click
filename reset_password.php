<?php
// Include the connection file
require "./PHP/connection.php";
// require "./PHP/Mail/phpmailer/PHPMailerAutoload.php";
require "./PHP/functions.php";

// Check if the 'customer_id' parameter is set in the URL
if (isset($_GET['customer_id'])) {
    // Get the customer ID from the URL
    $userID = $_GET['customer_id'];

    // Establish database connection
    $conn = DB(); // Make sure DB() function returns a valid database connection

    // Check connection
    if ($conn === null) {
        die("Database connection failed");
    }

    // Function to get customer by ID
    function getCustomerById($customerID, $conn) {
        $customerID = mysqli_real_escape_string($conn, $customerID); // Sanitize input

        $sql = "SELECT * FROM consumer WHERE customer_id = $customerID";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    // Get customer information
    $customer = getCustomerById($userID, $conn);

    if (!$customer) {
        // Handle the case where the customer is not found
        echo "Invalid customer ID.";
        exit();
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"])) {
        $newPassword = $_POST["new_password"];

        // Update the password in the database without encryption
        $updateQuery = "UPDATE consumer SET customer_password = '$newPassword' WHERE customer_id = $userID";

        if ($conn->query($updateQuery) === true) {
            // Redirect to register.php
            header("Location: http://localhost/e-shop-c/register.php");
            exit();
        } else {
            echo "Error updating password: " . $conn->error;
            exit();
        }
    }
} else {
    // Handle the case where 'customer_id' is not set in the URL
    echo "Invalid request. 'customer_id' not set.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style_nightwolf/login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="./style/search.css">
    <link rel="stylesheet" href="style.css">
    
    <title>reset_password</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        

        
        <?php include "style.css" ?>
        <?php include "./style/search.css" ?>
        <?php include "https://pro.fontawesome.com/releases/v5.10.0/css/all.css" ?>
        <?php include "style_nightwolf/login.css" ?>
        <?php include "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" ?>



    </style>
</head>
<body>



<section class="second">
    <div class="container" id="container">
        <div class="form-container sign-up">
            <!-- Register -->
          
        </div>

        <!-- mark -->
        <!-- Log in -->
        <div class="form-container sign-in">
         
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?customer_id=' . $userID; ?>">
    <h1>Update Password</h1>
    <label for="new_password" style="color:white;" >New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <button type="submit">Update Password</button>
    </form>

            <!-- mark -->
            <!-- Forgot Password -->
          
        </div>

        <div class="toggle-container">
            <div class="toggle">
          
            </div>
        </div>
    </div>
</section>

<script src="login.js"></script>
<script src="script.js"></script>
<script src="script/search.js"></script>
<script src="script/main.js"></script>
<script>
document.getElementById("forgotPasswordLink").addEventListener("click", function() {
    document.getElementById("signinForm").style.display = "none";
    document.getElementById("forgotPasswordForm").style.display = "flex";
});

document.getElementById("cancelReset").addEventListener("click", function() {
    document.getElementById("forgotPasswordForm").style.display = "none";
    document.getElementById("signinForm").style.display = "flex";
});

document.getElementById("resetPasswordSubmit").addEventListener("click", function() {
    document.getElementById("forgotPasswordForm").submit();
});
</script>

<?php scripts() ?>
</body>
</html>
