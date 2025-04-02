<?php
// Include database connection
include_once("components/connect.php");

// Check if the session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_name("USER_SESSION");
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if user exists in the database
    $check_user = mysqli_query($conn, "SELECT user_id FROM user_ragister WHERE user_id = '$user_id'");

    if (mysqli_num_rows($check_user) == 0) {
  
      $_SESSION['account_deleted'] = true;
     
  }

  if (isset($_SESSION['account_deleted'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Account Deleted",
            text: "Your account has been removed. Please contact support.",
            confirmButtonColor: "#d33"
        }).then(() => {
            window.location.href = "logout.php"; 
        });
    </script>';
    exit();
}
}
?>


<div class="header-container">
  <header class="header-section">
    <div class="header-logo">
      <!-- <img src="./images/logo2.png" alt=""height=40px width=40px class="logo-img"> -->
      <a href="home.php" class="logo">
        <i class="fa fa-home" aria-hidden="true"></i>
         Wonder Property</a>
    </div>

    <div class="header-post-property">
      <a href="post_property.php">Post Property<i class="fa fa-paper-plane"></i></a>
    </div>
  </header>
  <nav class="nav-container">
    <div class="toggle-div">
      <!-- <div class="toggle-close">
            <p id="close">close</p>
          </div> -->
      <div class="toggle crose">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="menu-left">
      <ul>
        <li>
          <div class="dropdown">
            <button class="btnmy_listings">
              my listings<i class="fa fa-angle-down" aria-hidden="true"></i>
            </button>
            <div class="dropdown-content">
              <a href="dashbord.php">dashboard</a>
              <a href="post_property.php">post property</a>
              <a href="my_listing.php">my listings</a>
            </div>
          </div>
        </li>
        <li>
          <div class="dropdown">
            <button class="btnoption">
              options<i class="fa fa-angle-down" aria-hidden="true"></i>
            </button>
            <div class="dropdown-content">
              <a href="filter.php">filter search</a>
              <a href="all_listing.php">all listings</a>
            </div>
          </div>
        </li>
        <li>
          <div class="dropdown">
            <button class="btnhelp">
              help<i class="fa fa-angle-down" aria-hidden="true"></i>
            </button>
            <div class="dropdown-content">
              <a href="about.php">about us</a>
              <a href="contactus.php">contact us</a>
              <a href="faq.php">FAQ</a>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <div class="menu-right">
      <ul>
        <li>
          <a href="saved_property.php">Saved <i class="fa fa-heart-o" aria-hidden="true"></i></a>
        </li>
        <li>
          <div class="dropdown">
            <button class="btnaccount">
              account <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            </button>
            <div class="dropdown-content">
              <!-- <a href="login.php">login now</a> -->
              <!-- <a href="ragister.php">ragister new</a> -->
              <a href="updateprofile.php">update profile</a>
              <a href="logout.php">logout</a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="menu-hide">
    <div class="hide-item">
      <div class="list-item">
        <div class="close-div">
          <p class="close">close</p>
          <div class="toggle toggle-crose">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <h3>my listings</h3>

        <a href="dashbord.php">dashboard</a>
        <a href="post_property.php">post property</a>
        <a href="my_listing.php">my listings</a>
        <h3>options</h3>
        <a href="filter.php">filter search</a>
        <a href="all_listing.php">all listings</a>
        <h3>help</h3>
        <a href="about.php">about us</a>
        <a href="contactus.php">contact us</a>
        <a href="faq.php">FAQ</a>
      </div>
    </div>
  </div>
</div>


<!-- -- ----------------------------------------------- -->
