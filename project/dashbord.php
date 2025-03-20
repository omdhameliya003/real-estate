
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
  <?php
   session_name("USER_SESSION");
    session_start();
    if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
  }
    $user_id=$_SESSION['user_id'];
    include("components/header.php");
    include("components/connect.php");

    $query = "SELECT * FROM postproperty where user_id='$user_id' ORDER BY date DESC";
    $result = mysqli_query($conn, $query);

    $select_user = mysqli_query($conn, "SELECT * FROM user_ragister WHERE user_id ='$user_id'");
    $fetch_user = mysqli_fetch_assoc($select_user);

    $request_sent_query="SELECT * from request where user_id='$user_id'";
    $request_sent_result=mysqli_query($conn, $request_sent_query);

    $request_recieve_query="SELECT * from request where owener_id='$user_id'";
    $request_recieve_result=mysqli_query($conn, $request_recieve_query);
    
    $saved_property_query="SELECT * FROM saved_properties where user_id ='$user_id'";
    $saved_property_result=mysqli_query($conn, $saved_property_query);

?>
    <div class="dashbord-container">
      <h1>Dashbord</h1>
      <div class="dashbord-cards">
        <div class="dashbord-card">
          <div>
            <h3>welcome!</h3>
          </div>
          <div class="deshbord-desc">
            <p><?php echo htmlspecialchars( $fetch_user['fname']); ?></p>
          </div>
          <div>
            <button class="btndashbord"><a href="updateprofile.php">update profile</a></button>
          </div>
        </div>
        <div class="dashbord-card">
          <div>
            <h3>filter search</h3>
          </div>
          <div class="deshbord-desc">
            <p>search your dream property</p>
          </div>
          <div>
            <button class="btndashbord"><a href="filter.php">serch now</a></button>
          </div>
        </div>
        <div class="dashbord-card">
          <div>
            <h3><?php echo htmlspecialchars( mysqli_num_rows($result)); ?></h3>
          </div>
          <div class="deshbord-desc">
            <p>properties listed</p>
          </div>
          <div>
            <button class="btndashbord">
              <a href="my_listing.php">view all my listings</a>
            </button>
          </div>
        </div>
        <div class="dashbord-card">
          <div>
            <h3><?php echo htmlspecialchars( mysqli_num_rows($request_recieve_result)); ?></h3>
          </div>
          <div class="deshbord-desc">
            <p>request received</p>
          </div>
          <div>
            <button class="btndashbord">
              <a href="request_recieve.php">view received requests</a>
            </button>
          </div>
        </div>
        <div class="dashbord-card">
          <div>
            <h3><?php echo htmlspecialchars( mysqli_num_rows($request_sent_result)); ?></h3>
          </div>
          <div class="deshbord-desc">
            <p>requests sent</p>
          </div>
          <div>
            <button class="btndashbord">
              <a href="request_send.php">view your requests</a>
            </button>
          </div>
        </div>
        <div class="dashbord-card">
          <div>
            <h3><?php echo htmlspecialchars( mysqli_num_rows($saved_property_result)); ?></h3>
          </div>
          <div class="deshbord-desc">
            <p>properties saved</p>
          </div>
          <div>
            <button class="btndashbord">
              <a href="saved_property.php">view saved propertis </a>
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php  include("components/footer.php")?>
    <script src="js/script.js"></script>
  </body>
</html>
