<?php
session_name("USER_SESSION");
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include("components/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Insert the data into the `messages` table
    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
      $_SESSION['success_msg'][] = "Your message has been sent successfully!";
    } else {
      $_SESSION['error_msg'][] = "Unable to send your message. Please try again.";
    }
    // Redirect back to the contact page after displaying the alert
    echo "<script>window.location.href = 'contactus.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
  <?php include("components/header.php"); ?>

  <div class="contact-container">
    <h2>Contact Us</h2>

    <form action="#" method="POST">
    <div class="contact-info">
      <div class="info-box">
        <i class="fa fa-phone"></i>
        <p><strong>Phone:</strong></p>
        <p>+91 999 98 98 111</p>
      </div>
      <div class="info-box">
        <i class="fa fa-envelope"></i>
        <p><strong>Email:</strong></p>
        <p>support@wonderproperties.com</p>
      </div>
      <div class="info-box">
        <i class="fa fa-map-marker"></i>
        <p><strong>Address:</strong></p>
        <p>A-121 High-Street Vesu Surat-395010</p>
      </div>
    </div>

    <div class="contact-form">
      <form action="send_message.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="message" placeholder="Your Message" required></textarea>
        <input type="submit" value="Send Message" class="btn" />
      </form>
    </div>
  </div>
    </form>
    <?php
    include("./components/footer.php");
?>
  <script src="./js/script.js"></script>
</body>
</html>
