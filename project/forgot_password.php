<?php
session_name("USER_SESSION");
session_start();
unset($_SESSION['temp_msg']);
include 'smtp/PHPMailerAutoload.php'; // Include your SMTP setup
include 'components/connect.php'; // Database connection

// $msg = ""; // Message for user feedback

//  Define the function before calling it
function verifyEmailExists($email)
{
    $host = "smtp.gmail.com";
    $port = 587;

    $connection = @fsockopen($host, $port, $errno, $errstr, 5);
    if (!$connection) {
        return false; // SMTP server not reachable
    }

    fclose($connection);
    return true; // SMTP is reachable, email likely exists
}

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];

    if (verifyEmailExists($email)) {
        // Check if email exists in the database
        $query = $conn->prepare("SELECT * FROM user_ragister WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['otp'] = rand(1000, 9999); // Generate OTP
            $_SESSION['email'] = $email; // Store email for verification

            // Send OTP via email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Username = 'omdhameliya003@gmail.com'; // Your SMTP email
            $mail->Password = 'pekhrgxqptmucmcn'; // Your SMTP password
            $mail->SetFrom("omdhameliya003@gmail.com");
            $mail->Subject = 'Your OTP Code for reset password';
            $mail->Body = 'Your OTP is: ' . $_SESSION['otp'];
            $mail->addAddress($email);
            $mail->SMTPOptions = array('ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => false
            ));

            if ($mail->send()) {
                $_SESSION['success_msg'][] = "OTP sent to your email!";
                header("Location: forgot_password.php"); // Ensure redirection happens after setting session
                exit();
                // $msg = "OTP sent to your email!";
            } else {
                $_SESSION['warning_msg'][] = "Failed to send OTP!";
                header("Location: forgot_password.php"); // Ensure redirection happens after setting session
                // $msg = "Failed to send OTP!";
                unset($_SESSION['otp']);
                exit();
            }
        } else {
            $_SESSION['error_msg'][] = "Email not registered!";
            header("Location: forgot_password.php"); // Ensure redirection happens after setting session
            // $msg = "Email not registered!";
            unset($_SESSION['otp']);
            exit();
        }
    } else {
        $_SESSION['error_msg'][] = "Invalid or non-existent email!";
    }
}

if (isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];

    if ($_SESSION['otp'] == $otp) {
        $_SESSION['otp_verified'] = true;
        $_SESSION['success_msg'][] = "OTP verified! You can now reset your password.";
        header("Location: forgot_password.php"); // Ensure redirection happens after setting session
        exit();
        // $msg = "OTP verified! You can now reset your password.";
    } else {
        $_SESSION['error_msg'][] = "Invalid OTP!";
        header("Location: forgot_password.php");
        // $msg = "Invalid OTP!";
    }
}

if (isset($_POST['reset_password'])) {
    if ($_SESSION['otp_verified']) {
        $new_password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email = $_SESSION['email'];

         // Validate password length
    if (strlen($new_password) < 8) {
        $_SESSION['warning_msg'][] = "Password must be at least 8 characters long!";
        header("Location: forgot_password.php");
        exit();
    }

    // Check if password and confirm password match
    if ($new_password !== $confirm_password) {
        $_SESSION['warning_msg'][] = "Passwords or confirm password must be the same!!";
        header("Location: forgot_password.php");
        exit();
    }

        $update_query = $conn->prepare("UPDATE user_ragister SET password = ? WHERE email = ?");
        $update_query->bind_param("ss", $new_password, $email);

        if ($update_query->execute()) {

            $_SESSION['success_msg'][] = "Password reset successful! You will be redirected to the login page.";
            unset($_SESSION['otp']);
            unset($_SESSION['otp_verified']);
            unset($_SESSION['email']);
            header("Location:login.php");
            exit();
        } else {
            $_SESSION['error_msg'][] = "Failed to reset password!";
            // $msg = "Failed to reset password!";
        }
    } else {
        $_SESSION['warning_msg'][] = "OTP verification required!";
        // $msg = "OTP verification required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- <link rel="stylesheet" href="css/forgot.css"> -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-container">
        <div class="my-form">
            <h2>Forgot Password</h2>
            <!-- <p><?php #echo $msg; 
                    ?></p> -->

            <?php if (!isset($_SESSION['otp'])) { ?>
                <!-- Email Input for Sending OTP -->
                <form method="POST">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <input type="submit" name="send_otp" value="Send OTP">
                </form>
            <?php } elseif (!isset($_SESSION['otp_verified'])) { ?>
                <!-- OTP Verification Form -->
                <form method="POST">
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                    <input type="submit" name="verify_otp" value="Verify OTP">
                </form>
            <?php } else { ?>
                <!-- Reset Password Form -->
                <form method="POST">
                    <input type="email" value="<?php echo $_SESSION['email']; ?>" readonly>
                    <input type="password" name="password" placeholder="New Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <input type="submit" name="reset_password" value="Reset Password">
                </form>
            <?php } ?>

            <div class="forgot-pass">
                <a href="login.php">← Back to Login</a>
            </div>
        </div>
    </div>
</body>

</html>