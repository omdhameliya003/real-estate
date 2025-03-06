<?php
session_name("ADMIN_SESSION");
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include "../components/connect.php";
include('../smtp/PHPMailerAutoload.php');

if (!isset($_GET['message_id'])) {
    header("Location: messages.php");
    exit;
}

$message_id = $_GET['message_id'];
$message_query = $conn->query("SELECT * FROM messages WHERE id='$message_id'");
$message_data = $message_query->fetch_assoc();

if (!$message_data) {
    die("Message not found!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_reply = $conn->real_escape_string($_POST['reply']);
    $user_email = $message_data['email'];
    $user_message = $message_data['message'];
    $subject = "Reply to Your Message - Admin Response from Wonder Property";

    // Construct email body
    $email_body = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        .message-box {
            background: #f9f9f9;
            padding: 10px;
            border-left: 5px solid #007BFF;
            margin: 10px 0;
            font-style: italic;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Admin Response to Your Inquiry</h2>
        <p>Dear User,</p>
        <p>Thank you for reaching out to us. Below is your message and our response:</p>
        <div class="message-box">
            <strong>Your Message:</strong> <br>
            ' . nl2br(htmlspecialchars($user_message)) . '
        </div>
        <p><strong>Admin Response:</strong></p>
        <div class="message-box">
            ' . nl2br(htmlspecialchars($admin_reply)) . '
        </div>
        <p>If you have any further questions, feel free to contact us.</p>
        <p>Best Regards,<br><strong>Admin Team</strong><br><strong>Wonder Property</strong></p>
        <div class="footer">
            &copy; ' . date("Y") . ' Your Company | All Rights Reserved
        </div>
    </div>
</body>
</html>';

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "omdhameliya003@gmail.com";
    $mail->Password = "pekhrgxqptmucmcn";
    $mail->SetFrom("omdhameliya003@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $email_body;
    $mail->AddAddress($user_email);
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
       $_SESSION['success_msg'][] = "mail sent successfully!";
        header("Location: messages.php");
    } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reply to Message</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="content email-form">
            <h2>Reply to User Message</h2>
            <form method="post">
                <label>User Email:</label>
                <input type="email" name="email" value="<?php echo $message_data['email']; ?>" readonly>

                <label>User Message:</label>
                <textarea readonly><?php echo $message_data['message']; ?></textarea>

                <label>Your Reply:</label>
                <textarea name="reply" required></textarea>

                <button type="submit">Send Email</button>
            </form>
        </div>
    </div>
</body>

</html>