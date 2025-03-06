  <?php  
  session_name("USER_SESSION");
  session_start();
  $saveby_user=$_SESSION['user_id'];
  include("components/header.php");
  include("components/connect.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
    $state = $_GET['state'] ?? "";
    $city = $_GET['city'] ?? "";
    $offer = $_GET['offer'] ?? "";
    $type = $_GET['type']??"";
    $min_budget = $_GET['min-badget'] ?? "";
    $max_budget = $_GET['max-badget'] ?? "";
    $status = $_GET['status'] ?? "";
    $furnished = $_GET['furnished'] ?? ""; 

    // Construct SQL query
    // $query = "SELECT * FROM postproperty WHERE user_id='$user_id'";
      //  $query = "SELECT * FROM postproperty where";
      $query = "SELECT * FROM postproperty where 1";

    // Add conditions based on form inputs
    if (!empty($state)) {
        $query .= " AND state LIKE '%$state%'";
    }
    if (!empty($city)) {
        $query .= " AND city LIKE '%$city%'";
    }
    if (!empty($offer)) {
        $query .= " AND offer='$offer'";
    }
    if (!empty($type)) {
        $query .= " AND type='$type'";
    }
    if (!empty($min_budget)) {
        $query .= " AND price >= '$min_budget'";
    }
    if (!empty($max_budget)) {
        $query .= " AND price <= '$max_budget'";
    }
    if (!empty($status)) {
        $query .= " AND status='$status'";
    }
    if (!empty($furnished)) {
        $query .= " AND furnished='$furnished'";
    }

    // Order by date descending
    $query .= " ORDER BY date DESC";

    // Execute the query
    $result = mysqli_query($conn, $query);
  } else{
    $result=false;
  }
  ?>
  <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>filter</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
    <!-- <div class="filter-top-btn">
       <button class="btnfilter"><a href="">filter property</a></button>
    </div> -->
    <div class="form-container filter-form">
      <div class="my-form " id="property-form">
      <h3>filter your search</h3>
        <form action="" method="GET">
          <div class="property-flex">
            <div>
              <p>state<span>*</span></p>
              <input
                type="text"
                name="state"
                value="gujarat"
                readonly
                required
                placeholder="enter your state"
              />
            </div>
            <div>
              <p>city <span>*</span></p>
              <select name="city" required>
                  <option value="surat">surat</option>
                  <option value="ahmedabad">ahmedabad</option>
                  <option value="rajkot">rajkot</option>
                  <option value="bhavnagar">bhavnagar</option>
                  <option value="vadodara">vadodra</option>
                </select>
              <!-- <input
                type="text"
                name="city"
                required
                maxlength="100"
                placeholder="enter your city"
              /> -->
            </div>
            <div>
              <p>offer type <span>*</span></p>
              <select name="offer" required>
                <option value="sale">sale</option>
                <option value="resale">resale</option>
                <option value="rent">rent</option>
              </select>
            </div>
            <div>
              <p>property type <span>*</span></p>
              <select name="type" required>
                <option value="flat">flat</option>
                <option value="house">house</option>
                <option value="shop">shop</option>
                <option value="office">office</option>
              </select>
            </div>

            <div>
              <p>minimum budget<span>*</span></p>
              <input
                type="number"
                name="min-badget"
                required
                min="0"
                max="999999999"
                maxlength="10"
                placeholder="enter min badget"
              />
            </div>
            <div>
              <p>maximum budget<span>*</span></p>
              <input
                type="number"
                name="max-badget"
                required
                min="0"
                max="999999999"
                maxlength="10"
                placeholder="enter max badget"
              />
            </div>
            <div>
              <p>property status <span>*</span></p>
              <select name="status" required>
                <option value="ready to move">ready to move</option>
                <option value="under construction">under construction</option>
              </select>
            </div>
            <div>
              <p>furnished status <span>*</span></p>
              <select name="furnished" required>
                <option value="furnished">furnished</option>
                <option value="semi-furnished">semi-furnished</option>
                <option value="unfurnished">unfurnished</option>
              </select>
            </div>
          </div>
          <input type="submit" value="serch property" class="btn" name="post" />
        </form>
      </div>
    </div>
    <!-- ---------------------------------------------------------- -->
   
   <?php if (!isset($result) || !$result) {
    // $result = mysqli_query($conn, "SELECT * FROM postproperty ORDER BY date DESC"); // Default query
    $result=false;
}
   
   if ( $result && mysqli_num_rows($result) > 0) {  ?>
        
        <div class="listing-container">
          <h2>Your Search Results</h2>
       <?php while ($row = mysqli_fetch_assoc($result)) {
          $user_id=$row['user_id'];
          $property_id = $row['id'];


          $is_saved = false;
          if ($user_id) {
              $check_saved = mysqli_query($conn, "SELECT * FROM saved_properties WHERE user_id='$saveby_user' AND       property_id='$property_id'");
              $is_saved = mysqli_num_rows($check_saved) > 0;
          }

            ?>
                <div class="listing-main">
                <?php
            $select_user = mysqli_query($conn, "SELECT * FROM user_ragister WHERE user_id ='$user_id'");
            $fetch_user = mysqli_fetch_assoc($select_user); ?>

                    <div class="listing-flex">
                        <div class="listing-left">
                        <div class="listing-save-btn">

                        <button>
                              <a href="saved_insert.php?id=<?php echo $property_id; ?>&action=<?php echo $is_saved ? 'remove' : 'save'; ?>">
                                  <i class="fa <?php echo $is_saved ? 'fa-heart' : 'fa-heart-o'; ?>" aria-hidden="true" style="color:<?php echo $is_saved ? 'red' : 'black'; ?>;"></i>
                          <?php echo $is_saved ? 'Saved' : 'Save'; ?>
                              </a>
                        </button>

                        <button class="comment-button">
                               <a href="comments.php?property_id=<?php echo $property_id; ?>&prev=<?php echo urlencode($_SERVER['REQUEST_URI']. '#property-' . $property_id); ?>">
                                  <i class="fa fa-comments"></i> Comment
                               </a>
                        </button>

                   </div>
                            <!-- <div class="listing-save-btn">
                                <button><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> Save</a></button>
                            </div> -->
                            <div class="listing-img">
                                <img src="uploads/<?php echo htmlspecialchars($row['image_01']); ?>" alt="" />
                            </div>
                            <div class="listing-user">
                                <div>
                                    <h3 class="owner-logo"><?php echo substr($fetch_user['fname'], 0, 1); ?></h3>
                                </div>
                                <div class="owner-name">
                                    <p><?php echo htmlspecialchars( $fetch_user['fname']." ".$fetch_user['lname']); ?></p>
                                    <p><?php echo htmlspecialchars($row['date']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="listing-right">
                            <div class="listing-data">
                                <div>
                                    <p class="price">
                                        <i class="fa fa-inr" aria-hidden="true"></i><span><?php echo number_format($row['price']); ?></span>
                                    </p>
                                </div>
                                <div class="name">
                                    <h3><?php echo htmlspecialchars($row['property_name']); ?></h3>
                                </div>
                                <div class="address">
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i><span><?php echo htmlspecialchars($row['address'].",".$row["city"]); ?></span></p>
                                </div>
                                <div class="listing-data-grid">
                                <p>
                                <?php
                                 $property_type = htmlspecialchars($row['type']);
                                     $icon = ''; // Default icon

                               // Determine the correct icon based on the property type
                              if ($property_type == 'office') {
                               $icon = 'fa fa-building'; // Office icon
                              } elseif ($property_type == 'shop') {
                              $icon = ' fa fa-building'; // Shop icon
                              } elseif ($property_type == 'home' || $property_type == 'flat') {
                              $icon = 'fa fa-home'; // Home/Flat icon
                              } else {
                              $icon = 'fa fa-home'; // Default icon if type is unknown
                               }
                                ?>
                              <i class="<?php echo $icon; ?>" aria-hidden="true"></i> 
                              <span><?php echo $property_type; ?></span>
                             </p>
                                <p><i class="fa fa-tag" aria-hidden="true"></i> <span><?php echo htmlspecialchars($row['offer']); ?></span></p>
                                <?php 
                                  // Check if the property type is 'office' or 'shop'
                                  if ($row['type'] == 'office' || $row['type'] == 'shop') {
                                  // Display property age if the type is 'office' or 'shop'
                                  echo '<p><i class="fa fa-calendar" aria-hidden="true"></i> <span>' . htmlspecialchars($row['age']) . ' years old</span></p>';
                                   } else {
                                // Otherwise, display the BHK
                                 echo '<p><i class="fa fa-bed" aria-hidden="true"></i> <span>' . htmlspecialchars($row['bhk']) . ' BHK</span></p>';
                                     }
                                  ?>
                    
                                <p><i class="fa fa-reply" aria-hidden="true"></i> <span><?php echo htmlspecialchars($row['status']); ?></span></p>
                                <p><i class="fa fa-home" aria-hidden="true"></i> <span><?php echo htmlspecialchars($row['furnished']); ?></span></p>
                                <p><i class="fa fa-arrows-alt" aria-hidden="true"></i> <span><?php echo htmlspecialchars($row['carpet']); ?> sqft</span></p>
                                </div>
                                <div class="listing-buttons">
                                    <button class="btnviewproperty"><a href="view_property.php?id=<?php echo $row['id']; ?>">View Property</a></button>
                                    <button class="btnsendenquery"><a href="enquery.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $_SESSION['user_id']; ?>&owener_id=<?php echo $row['user_id']; ?>">Send Enquiry</a></button>
                                    <!-- <button class="btnsendenquery"><a href="#">Send Enquiry</a></button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "
        <div class='filter_not_found'>
        <p>No properties found matching your search criteria.</p>
         </div>";
    }
?>     
    <?php  include("components/footer.php")?>
    <script src="js/script.js"></script>
    <script src="js/goback.js"></script>
  </body>
</html>
