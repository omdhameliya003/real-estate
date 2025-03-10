<?php
session_name("USER_SESSION");
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include("components/connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ - Frequently Asked Questions</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>
  <?php include("components/header.php"); ?>

  <div class="faq-container">
    <h2>Frequently Asked Questions</h2>

    <div class="faq-item">
      <h3>What types of properties are available? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>We offer a variety of properties, including flats, houses, shops, and office spaces, tailored to meet your needs.</p>
    </div>

    <div class="faq-item">
       <h3>Is this platform available only for Gujarat properties? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
       <p>Yes, our platform specializes in property listings exclusively within Gujarat. We focus on providing the best real estate opportunities in this region.</p>
    </div>

    <div class="faq-item">
      <h3>Which cities are covered on this platform? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>Currently, we offer property listings in **Surat, Ahmedabad, Bhavnagar, Rajkot, and Vadodara**. More cities will be added in the future.</p>
   </div>

    <div class="faq-item">
      <h3>How can I list my property on your website? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
       <p>You can list your property by creating an account, clicking on the "Post Property" button, and filling in the required details.</p>
     </div>

     <div class="faq-item">
     <h3>Can I edit or remove my property listing? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>Yes, you can manage your listings from your account dashboard or my listing, where you can edit or remove your properties at any time.</p>
   </div>

    <div class="faq-item">
      <h3>How do I search for a property? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>You can use our search tool on the filter serch page to filter properties by type, location, and price range.</p>
    </div>

    <div class="faq-item">
      <h3>How do I contact a property owner? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
       <p>You can contact the property owner directly through the contact details provided on each listing.</p>
    </div>

    <div class="faq-item">
      <h3>Is there a fee for property listings? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>No, listing properties on our platform is absolutely free of charge.</p>
    </div>

    <div class="faq-item">
      <h3>Do I need to pay any commission? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>No, we do not charge any commission for property transactions. You can buy, sell, or rent properties without extra fees.</p>
    </div>

    <div class="faq-item">
      <h3>Are the properties verified? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>Yes, we verify all property listings to ensure accuracy and reliability before making them available to users.</p>
    </div>

    <div class="faq-item">
      <h3>Can I schedule a property visit? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
      <p>Yes, you can contact the property owner directly to schedule a visit. Contact details are available on each listing.</p>
    </div>
    <div class="faq-item">
  <h3>Is my personal information secure on your platform? <span class="faq-toggle-icon"><i class="fa fa-chevron-down"></i></span></h3>
  <p>Yes, we prioritize user privacy and use encryption methods to protect your personal and transaction data.</p>
</div>
  </div>
  <?php
       include("./components/footer.php");
   ?>
  <script>
    // FAQ Accordion Toggle
    document.querySelectorAll('.faq-item h3').forEach((question) => {
      question.addEventListener('click', () => {
        const parent = question.parentElement;

        if (parent.classList.contains('active')) {
          parent.classList.remove('active');
        } else {
          document.querySelectorAll('.faq-item').forEach((item) => item.classList.remove('active'));
          parent.classList.add('active');
        }
      });
    });
  </script>

<script src="js/script.js"></script>
</body>
</html>

