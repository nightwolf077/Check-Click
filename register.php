<?php
require "./PHP/connection.php";
require "./PHP/Mail/phpmailer/PHPMailerAutoload.php";
require "./PHP/functions.php";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle registration
    if (isset($_POST['signup_email'], $_POST['signup_name'], $_POST['signup_password'])) {
        $signup_email = $_POST["signup_email"];
        $signup_name = $_POST["signup_name"];
        $signup_password = $_POST["signup_password"];
        
        $sql2 = "SELECT customer_name FROM consumer WHERE customer_name='$signup_name'";
        $result = DB()->query($sql2);
        
        if ($result->num_rows > 0) {
            echo '<script>alert("Customer Already Exists");</script>';
        } else {
            $sql = "INSERT INTO consumer (customer_name, customer_email, customer_password)
                    VALUES ('$signup_name', '$signup_email', '$signup_password')";
            
            if (DB()->query($sql) === true) {
                echo '<script>alert("Account Created Successfully");</script>';
                
                // Send email logic
                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465; // Using SSL
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';

                $mail->Username = 'mohmmademad17654@gmail.com';
                $mail->Password = 'vczvclxztlvdltnb';

                $mail->setFrom('mohmmademad17654@gmail.com', 'Mohammed Emad');
                $mail->addAddress($signup_email);

                $UserID = getIdFromName($signup_name);

                $mail->isHTML(true);
                $mail->Subject = "Welcome";
                $mail->Body = "<p>Dear user $signup_name,</p><h3><a href='http://localhost/e-shop-c/redirect.php/?customer_id=$UserID'>Please click here to confirm your email</a><br></h3>";

                if (!$mail->send()) {
                    echo '<script>alert("Register Failed: ' . $mail->ErrorInfo . '");</script>';
                }
            } else {
                echo '<script>alert("Error: Could not create account.");</script>';
            }
        }
    }

    // Handle password reset request
    if (isset($_POST["forgotEmail"])) {
        $forgotEmail = $_POST["forgotEmail"];

        // Check if the email exists in the database
        $sql = "SELECT customer_name FROM consumer WHERE customer_email = '$forgotEmail'";
        $result = DB()->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customerName = $row['customer_name'];

            // Send reset password email logic
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';

            $mail->Username = 'mohmmademad17654@gmail.com';
            $mail->Password = 'vczvclxztlvdltnb';

            $mail->setFrom('mohmmademad17654@gmail.com');
            $mail->addAddress($forgotEmail);

            $userID = getIdFromName($customerName);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset";
            $mail->Body = "
                <html>
                    <head>
                        <title>Password Reset</title>
                    </head>
                    <body>
                        <p>Dear $customerName,</p>
                        <p>You have requested to reset your password. Click the link below to reset your password:</p>
                        <p><a href='http://localhost/e-shop-c/reset_password.php/?customer_id=$userID'>Reset Password</a></p>
                        <p>If you did not request this password reset, please ignore this email.</p>
                        <p>Best regards,</p>
                        <p>Your Company Name</p>
                    </body>
                </html>
            ";

            if (!$mail->send()) {
                echo '<script>';
                echo 'alert("Password reset email failed: ' . $mail->ErrorInfo . '")';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'alert("Password reset email sent successfully")';
                echo '</script>';
            }
        } else {
            echo '<script>';
            echo 'alert("Email not found in the database")';
            echo '</script>';
        }
    }
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
    <title>Login</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<section id="header">
    <a href="index.php"><img src="img/logo-main-word.png" alt="" class="logo" width="200px"></a>
    <ul id="navbar">
        <li id="contact"><a href="http://localhost/e-shop-c/index.php">Enter as guest</a></li>
    </ul>
</section>

<section class="second">
    <div class="container" id="container">
        <div class="form-container sign-up">
            <!-- Register -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1>Create Account</h1>
                <span>or use your email for registration</span>
                <input name="signup_email" id="email_signup" type="email" class="form-control" placeholder="Enter your email" autocomplete="off" required>
                <small id="emailHelp" class="form-text text-muted mb-3 d-block">Enter a valid Email</small>
                <input name="signup_name" id="name_signup" type="text" class="form-control" placeholder="Enter your username" autocomplete="off" required>
                <small id="userHelp" class="form-text text-muted mb-3 d-block">3 characters at least and contains no spaces</small>
                <input name="signup_password" id="password_signup" type="password" class="form-control" placeholder="Enter your password" autocomplete="off" required>
                <small id="passwordHelp" class="form-text text-muted mb-3 d-block">Password must be at least 8 characters long and contain a letter</small>
                <input id="password_conf" type="password" class="form-control mb-3" placeholder="Repeat password" autocomplete="off" required>
                <button id="signup_submit" type="submit">Sign Up</button>
            </form>
        </div>

        <!-- mark -->
        <!-- Log in -->
        <div class="form-container sign-in">
            <form method="POST" action="PHP/account_login.php" id="signinForm">
                <h1>Sign In</h1>
                <span>Or use your Email</span>
                <input name="name" id="email_login" type="text" placeholder="User Name" required>
                <input name="password" id="password_login" type="password" placeholder="Password" required>
                <a href="#" id="forgotPasswordLink">Forget Your Password?</a>
                <button id="login_submit" type="submit">Sign In</button>
            </form>

            <!-- mark -->
            <!-- Forgot Password -->
            <form id="forgotPasswordForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: none;">
                <h1>Forgot Your Password?</h1>
                <span>Enter your email to reset your password</span>
                <input name="forgotEmail" id="forgotEmail" type="text" placeholder="Email">
                <button id="resetPasswordSubmit">Reset Password</button>
                <a href="#" id="cancelReset">Cancel</a>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
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
