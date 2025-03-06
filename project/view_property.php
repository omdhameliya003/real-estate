<?php
session_name("USER_SESSION");
session_start();
include("components/connect.php");

if (isset($_GET['id'])) {
  $property_id = $_GET['id'];

  $query = "SELECT * FROM postproperty WHERE id = '$property_id'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $property = $result->fetch_assoc();
    $user_id = $property['user_id'];
  } else {
    echo "<script>alert('Property not found!'); window.location.href='home.php';</script>";
    exit;
  }
} else {
  echo "<script>alert('Invalid request!'); window.location.href='home.php';</script>";
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Property</title>
  <link rel="stylesheet" href="css/view_property.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <section class="view-property">

    <h1 class="heading">Property Details</h1>
    <?php
    $select_user = mysqli_query($conn, "SELECT * FROM user_ragister WHERE user_id ='$user_id'");
    $fetch_user = mysqli_fetch_assoc($select_user); ?>

    <div class="details">
      <div class="slide-container">

        <?php
        $images = [];
        for ($i = 1; $i <= 5; $i++) {
          $imgKey = "image_0$i";
          if (!empty($property[$imgKey])) {
            $images[] = $property[$imgKey];
          }
        }

        if (!empty($images)) {
          foreach ($images as $image) {
            echo "<div class='slide'><img src='uploads/" . $image . "' alt='Property Image'></div>";
          }
        } else {

          echo "<div class='slide'><img src='images/placeholder.jpg' alt='No Image Available'></div>";
        }
        ?>


        <?php if (count($images) > 1): ?>
          <span class="arrow prev" onclick="controller(-1)">&#10094;</span>
          <span class="arrow next" onclick="controller(1)">&#10095;</span>
        <?php endif; ?>
      </div>


      <h3 class="name"><?php echo $property['property_name']; ?></h3>
      <p class="location">
        <i class="fas fa-map-marker-alt"></i>
        <span><?php echo $property['address'] . ', ' . $property['city'] . ', ' . $property['state']; ?></span>
      </p>
      <div class="info">
        <div>

          <p><i class="fas fa-indian-rupee-sign"></i><span><?php echo number_format($property['price']); ?></span></p>
          <p><i class="fas fa-user"></i><span><?php echo htmlspecialchars($fetch_user['fname']); ?></span></p>
          <p> <i class="fas fa-phone"></i><span><?php echo htmlspecialchars($fetch_user['mobile']); ?></span></p>
        </div>
        <div>
          <p>
            <?php
            $icon = '<i class="fas fa-home"></i>';

            if ($property['type'] == 'office') {
              $icon = '<i class="fas fa-building"></i>';
            } elseif ($property['type'] == 'shop') {
              $icon = '<i class="fas fa-store"></i>';
            } elseif ($property['type'] == 'flat') {
              $icon = '<i class="fas fa-city"></i>';
            } elseif ($property['type'] == 'house') {
              $icon = '<i class="fas fa-house"></i>';
            }
            echo $icon . " <span>" . ucfirst($property['type']) . "</span>";
            ?></p>
          <p><i class="fas fa-tag"></i><span><?php echo ucfirst($property['offer']); ?></span></p>
          <p><i class="fas fa-calendar"></i><span><?php echo date("F j, Y", strtotime($property['date'])); ?></span></p>
        </div>
      </div>

      <h3 class="title">Details</h3>
      <div class="flex">
        <div class="box">

          <p>State : <span><?php echo $property['state']; ?></span></p>
          <p>City : <span><?php echo $property['city']; ?></span></p>
          <p>Deposit Amount : <span>₹<?php echo number_format($property['deposite']); ?></span></p>
          <p>Status : <span><?php echo ucfirst($property['status']); ?></span></p>
          <p>Carpet Area : <span><?php echo $property['carpet']; ?> sqft</span></p>

          <?php if ($property['type'] !== 'office' && $property['type'] !== 'shop') : ?>
            <p>Rooms : <span><?php echo $property['bhk']; ?> BHK</span></p>
            <p>Bedroom : <span><?php echo $property['bedroom']; ?></span></p>
          <?php endif; ?>
        </div>

        <div class="box">
          <?php if ($property['type'] !== 'office' && $property['type'] !== 'shop') : ?>
            <p>Bathroom : <span><?php echo $property['bathroom']; ?></span></p>
            <p>Room Floor : <span><?php echo $property['room_floor']; ?></span></p>
          <?php endif; ?>
          <p>Total Floors : <span><?php echo $property['total_floors']; ?></span></p>
          <p>Age : <span><?php echo $property['age']; ?> years</span></p>
          <p>Balcony : <span><?php echo $property['balcony']; ?></span></p>
          <p>Furnished : <span><?php echo ucfirst($property['furnished']); ?></span></p>
          <p>Loan : <span><?php echo ucfirst($property['loan']); ?></span></p>
        </div>
      </div>
      <h3 class="title">Amenities</h3>
      <div class="flex">
        <div class="box">
          <p><i class="fas <?php echo ($property['lift'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Lifts</span></p>
          <p><i class="fas <?php echo ($property['security_guard'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Security Guards</span></p>
          <p><i class="fas <?php echo ($property['play_ground'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Play Ground</span></p>
          <p><i class="fas <?php echo ($property['garden'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Garden</span></p>
          <p><i class="fas <?php echo ($property['water_supply'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Water Supply</span></p>
          <p><i class="fas <?php echo ($property['power_backup'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Power Backup</span></p>
          <p><i class="fas <?php echo ($property['fire_security'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Fire Alarm</span></p>
        </div>
        <div class="box">
          <p><i class="fas <?php echo ($property['parking_area'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Parking Area</span></p>
          <p><i class="fas <?php echo ($property['gym'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Gym</span></p>
          <p><i class="fas <?php echo ($property['cctv_cameras'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>CCTV Cameras</span></p>
          <p><i class="fas <?php echo ($property['shopping_mall'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Shopping Mall</span></p>
          <p><i class="fas <?php echo ($property['hospital'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Hospital</span></p>
          <p><i class="fas <?php echo ($property['school'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>School</span></p>
          <p><i class="fas <?php echo ($property['market_area'] == 'yes') ? 'fa-check' : 'fa-times'; ?>"></i> <span>Market Area</span></p>
        </div>
      </div>


      <h3 class="title">Description</h3>
      <p class="description">
        <?php echo $property['description']; ?>
      </p>
      <div class="view-property-buttons">
        <button class="btn-goback" onclick="goBack()">← Go Back</button>  
        <button class="btnsendenquery"><a href="enquery.php?id=<?php echo $property['id']; ?>&user_id=<?php echo $_SESSION['user_id']; ?>&owener_id=<?php echo $property['user_id']; ?>">Send Enquiry</a></button>
      </div>
    </div>
  </section>

  <script>
    let flag = 0;

    function controller(x) {
      flag = flag + x;
      slideshow(flag);
    }

    slideshow(flag);

    function slideshow(num) {
      let slides = document.querySelectorAll(".slide");

      if (num == slides.length) {
        flag = 0;
        num = 0;
      }
      if (num < 0) {
        flag = slides.length - 1;
        num = slides.length - 1;
      }
      for (let y of slides) {
        y.style.display = "none";
      }
      slides[num].style.display = "block";
    }

    function goBack() {
      window.history.back();
    }
  </script>
</body>

</html>