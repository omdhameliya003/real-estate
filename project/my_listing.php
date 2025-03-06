<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
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
  $user_id=$_SESSION['user_id'];

  include("components/header.php");
  include("components/connect.php");
  
  $query = "SELECT * FROM postproperty where user_id='$user_id' ORDER BY date DESC";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) { 
  
  ?>
  
    <div class="my_listingcontainer">
      <h2>My Listing</h2>
      <div class="my_listing_flex">
      <?php while ($row = mysqli_fetch_assoc($result)) { 
             $user_id = $row['user_id'];
            ?>
        <div class="list_item">
          <div class="my_listing_img">
            <img src="uploads/<?php echo htmlspecialchars($row['image_01']); ?>" alt="">
          </div>
          <div class="listing-data">
            <div>
              <p>
                <i class="fa fa-inr" aria-hidden="true"></i><span><?php echo number_format($row['price']); ?></span>
              </p>
            </div>
            <div>
              <h3><?php echo htmlspecialchars($row['property_name']); ?></h3>
            </div>
            <div>
              <p>
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                 <?php 
                    $address = htmlspecialchars($row['address']);
                      echo (mb_strlen($address) > 25) ? mb_strimwidth($address, 0, 35, "...") : $address; 
                   ?>
                 </span>
                 </p>
            </div>
            <div class="my_listing_buttons">
               <div class="my_list_btn_flex">
                 <button class="btnupdate">
                     <a href="update_property.php?id=<?php echo $row['id']; ?>">Update</a>
                 </button>
                 <button class="btndelete">
                     <a href="delete_property.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
                 </button>
               </div>
               <div>
                <button class="btnview_property"><a href="view_property.php?id=<?php echo $row['id']; ?>">view property</a></button>
               </div>

            </div>
            </div>
            </div>
            <?php } ?>
          </div>
          </div>
          <?php } else{
              echo'
                <div class="no_property">
                <p>
                  No listings found. Be the first to post a property!
                </p>
                <button class="add_mylisting_btn"><a href="post_property.php"> Add New </a></button>
                </div>
              ';
          } ?>
        
    <?php  include("components/footer.php")?>
    <script src="js/script.js"></script>
  </body>
</html>