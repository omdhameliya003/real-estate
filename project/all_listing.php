<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> All Listing</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php
    session_name("USER_SESSION");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $saveby_user = $_SESSION['user_id'];
    include("components/header.php");
    include("components/connect.php");

    $query = "SELECT * FROM postproperty ORDER BY date desc";
    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) > 0) {
    ?>
        <div class="listing-container">
            <h2>All Listings</h2>
            <?php while ($row = mysqli_fetch_assoc($result)) {

                $user_id = $row['user_id'];
                $property_id = $row['id'];

                $is_saved = false;
                if ($user_id) {
                    $check_saved = mysqli_query($conn, "SELECT * FROM saved_properties WHERE user_id='$saveby_user' AND property_id='$property_id'");
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
                                    <a href="comments.php?property_id=<?php echo $property_id; ?>&prev=<?php echo urlencode($_SERVER['REQUEST_URI'] . '#property-' . $property_id); ?>">
                                        <i class="fa fa-comments"></i> Comment
                                    </a>
                                </button>
                            </div>
                            <div class="listing-img">
                                <img src="uploads/<?php echo htmlspecialchars($row['image_01']); ?>" alt="Property Image">
                            </div>
                            <div class="listing-user">
                                <div>
                                    <h3 class="owner-logo"><?php echo substr($fetch_user['fname'], 0, 1); ?></h3>
                                </div>
                                <div class="owner-name">
                                    <p><?php echo htmlspecialchars($fetch_user['fname'] . " " . $fetch_user['lname']); ?></p>
                                    <p><?php echo htmlspecialchars($row['date']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="listing-right">
                            <div class="listing-data">
                                <div>
                                    <p><i class="fa fa-inr" aria-hidden="true"></i> <span><?php echo number_format($row['price']); ?></span></p>
                                </div>
                                <div>
                                    <h3><?php echo htmlspecialchars($row['property_name']); ?></h3>
                                </div>
                                <div>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> <span><?php echo htmlspecialchars($row['address'] . "," . $row['city']); ?></span></p>
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
                                    if ($row['type'] == 'office' || $row['type'] == 'shop') {
                                        echo '<p><i class="fa fa-calendar" aria-hidden="true"></i> <span>' . htmlspecialchars($row['age']) . ' years old</span></p>';
                                    } else {
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php
    } else {
        echo '
        <div class="no_property">
        <p>No properties found.</p>
        </div>
      ';
    }
    include("components/footer.php");
    ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Restore scroll position after reload
    if (localStorage.getItem("scrollY") !== null) {
        window.scrollTo(0, localStorage.getItem("scrollY"));
        localStorage.removeItem("scrollY"); // Clear after restoring
    }

    // Save scroll position before clicking Save/Remove
    document.querySelectorAll("button a").forEach(function(button) { 
        button.addEventListener("click", function() {
            localStorage.setItem("scrollY", window.scrollY);
        });
    });
});
</script>


    <script src="js/script.js"></script>
    <script src="js/goback.js"></script>
</body>

</html>