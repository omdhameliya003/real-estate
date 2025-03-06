
<?php
session_start();
$user_id = $_SESSION['user_id'];

include("components/connect.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request!");
}

$property_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch the existing data
$query = "SELECT * FROM postproperty WHERE id='$property_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("Property not found or you don't have permission to edit it.");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $property_name = mysqli_real_escape_string($conn, $_POST['property_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $offer = mysqli_real_escape_string($conn, $_POST['offer']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $deposite = mysqli_real_escape_string($conn, $_POST['deposite']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $furnished = mysqli_real_escape_string($conn, $_POST['furnished']);
    $bhk = mysqli_real_escape_string($conn, $_POST['bhk']);
    $bedroom = mysqli_real_escape_string($conn, $_POST['bedroom']);
    $bathroom = mysqli_real_escape_string($conn, $_POST['bathroom']);
    $balcony = mysqli_real_escape_string($conn, $_POST['balcony']);
    $carpet = mysqli_real_escape_string($conn, $_POST['carpet']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $total_floors = mysqli_real_escape_string($conn, $_POST['total_floors']);
    $room_floor = mysqli_real_escape_string($conn, $_POST['room_floor']);
    $loan = mysqli_real_escape_string($conn, $_POST['loan']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Checkbox fields
    $amenities = ['lift', 'security_guard', 'play_ground', 'garden', 'water_supply', 'power_backup', 'fire_security', 'parking_area', 'gym', 'cctv_cameras', 'shopping_mall', 'hospital', 'school', 'market_area'];
    $amenities_values = [];
    foreach ($amenities as $amenity) {
        $amenities_values[$amenity] = isset($_POST[$amenity]) ? 'yes' : 'no';
    }
    
    // Handle image uploads
    $image_fields = ['image_01', 'image_02', 'image_03', 'image_04', 'image_05'];
    foreach ($image_fields as $image_field) {
        if (!empty($_FILES[$image_field]['name'])) {
            $image_name = time() . '_' . $_FILES[$image_field]['name'];
            $image_tmp = $_FILES[$image_field]['tmp_name'];
            move_uploaded_file($image_tmp, "uploads/$image_name");
            $image_updates[] = "$image_field = '$image_name'";
        }
    }
    $image_query = isset($image_updates) ? ", " . implode(", ", $image_updates) : "";
    $update_query = "UPDATE postproperty SET 
        property_name='$property_name', 
        type='$type', 
        offer='$offer', 
        price='$price', 
        deposite='$deposite', 
        address='$address', 
        city='$city', 
        state='$state', 
        status='$status', 
        furnished='$furnished', 
        bhk='$bhk', 
        bedroom='$bedroom', 
        bathroom='$bathroom', 
        balcony='$balcony', 
        carpet='$carpet', 
        age='$age', 
        total_floors='$total_floors', 
        room_floor='$room_floor', 
        loan='$loan', 
        description='$description',
        lift='{$amenities_values['lift']}', 
        security_guard='{$amenities_values['security_guard']}', 
        play_ground='{$amenities_values['play_ground']}', 
        garden='{$amenities_values['garden']}', 
        water_supply='{$amenities_values['water_supply']}', 
        power_backup='{$amenities_values['power_backup']}', 
        fire_security='{$amenities_values['fire_security']}', 
        parking_area='{$amenities_values['parking_area']}', 
        gym='{$amenities_values['gym']}', 
        cctv_cameras='{$amenities_values['cctv_cameras']}', 
        shopping_mall='{$amenities_values['shopping_mall']}', 
        hospital='{$amenities_values['hospital']}', 
        school='{$amenities_values['school']}', 
        market_area='{$amenities_values['market_area']}' 
        $image_query 
        WHERE id='$property_id' AND user_id='$user_id'";
    
    $update_result = mysqli_query($conn, $update_query);
    if ($update_result) {
      $_SESSION['success_msg'][] = "Property updated successfully!";
      header("Location: my_listing.php");
      exit();
        // echo "<script>alert('Property updated successfully!'); window.location.href='my_listing.php';</script>";
    } else {
      $_SESSION['error_msg'][] = "Failed to update property!";
      header("Location: my_listing.php");
      exit();
        // echo "<script>alert('Failed to update property!');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>update property</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
  <?php  include("components/header.php")?>
    <div class="form-container">
      <div class="my-form " id="property-form">
        <form action="#" method="POST" enctype="multipart/form-data">
          <h3>Update Propety </h3>
          <div>
            <p>property name <span>*</span></p>
            <input
              type="text"
              name="property_name"
              required
              value="<?php echo htmlspecialchars($row['property_name']); ?>"
              placeholder="enter property name"
            />
          </div>
          <div class="property-flex">
          <div>
              <p>property type <span>*</span></p>
              <select name="type" id="property-type" onchange="togglePropertyFields()" required >
                        <option value="flat" <?php if($row['type'] == 'flat') echo 'selected'; ?>>Flat</option>
                        <option value="house" <?php if($row['type'] == 'house') echo 'selected'; ?>>House</option>
                        <option value="shop" <?php if($row['type'] == 'shop') echo 'selected'; ?>>Shop</option>
                        <option value="office" <?php if($row['type'] == 'office') echo 'selected'; ?>>Office</option>
              </select>
            </div>
            <div>
              <p>offer type <span>*</span></p>
              <select name="offer" required>
                <option value="sale" <?php if($row['offer'] == 'sale') echo 'selected'; ?>>sale</option>
                <option value="resale" <?php if($row['offer'] == 'resale') echo 'selected'; ?>>resale</option>
                <option value="rent" <?php if($row['offer'] == 'rent') echo 'selected'; ?>>rent</option>
              </select>
            </div>
            <div>
              <p>property price <span>*</span></p>
              <input
                type="number"
                name="price"
                required
                value="<?php echo $row['price']; ?>"
                min="0"
                max="9999999999"
                maxlength="10"
                placeholder="enter property price"
              />
            </div>
            <div>
              <p>deposite amount <span>*</span></p>
              <input
                type="number"
                name="deposite"
                required
                value="<?php echo $row['deposite']; ?>"
                min="0"
                max="9999999999"
                maxlength="10"
                placeholder="enter deposite amount"
              />
            </div>
            <div>
              <p>property address <span>*</span></p>
              <input
                type="text"
                name="address"
                required
                value="<?php echo htmlspecialchars($row['address']); ?>"
                maxlength="100"
                placeholder="enter property full address"
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
            
            </div>
            <div>
              <p>state<span>*</span></p>
              <input
                type="text"
                name="state"
                value="gujarat"
                readonly
                value="<?php echo htmlspecialchars($row['state']); ?>"
                maxlength="100"
                placeholder="enter your state"
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
            <div class="not-included-office-shop">
              <p>how many BHK <span>*</span></p>
              <select name="bhk" required class="no-required">
                <option value="1" <?php if($row['bhk'] == '1') echo 'selected'; ?>>1 BHK</option>
                <option value="2" <?php if($row['bhk'] == '2') echo 'selected'; ?>>2 BHK</option>
                <option value="3" <?php if($row['bhk'] == '3') echo 'selected'; ?>>3 BHK</option>
                <option value="4" <?php if($row['bhk'] == '4') echo 'selected'; ?>>4 BHK</option>
                <option value="5" <?php if($row['bhk'] == '5') echo 'selected'; ?>>5 BHK</option>
              </select>
            </div>
            <div class="not-included-office-shop">
              <p>how many bedrooms <span>*</span></p>
              <select name="bedroom" required class="no-required">
                <option value="0"<?php if($row['bedroom'] == '0') echo 'selected'; ?>>0 bedroom</option>
                <option value="1" <?php if($row['bedroom'] == '1') echo 'selected'; ?>>1 bedroom</option>
                <option value="2"<?php if($row['bedroom'] == '2') echo 'selected'; ?>>2 bedroom</option>
                <option value="3" <?php if($row['bedroom'] == '3') echo 'selected'; ?>>3 bedroom</option>
                <option value="4" <?php if($row['bedroom'] == '4') echo 'selected'; ?>>4 bedroom</option>
                <option value="5" <?php if($row['bedroom'] == '5') echo 'selected'; ?>>5 bedroom</option>
              </select>
            </div>
            <div class="not-included-office-shop">
              <p>how many bathrooms <span>*</span></p>
              <select name="bathroom" required class="no-required">
                <option value="1" <?php if($row['bathroom'] == '1') echo 'selected'; ?>>1 bathroom</option>
                <option value="2" <?php if($row['bathroom'] == '2') echo 'selected'; ?>>2 bathroom</option>
                <option value="3" <?php if($row['bathroom'] == '3') echo 'selected'; ?>>3 bathroom</option>
                <option value="4" <?php if($row['bathroom'] == '4') echo 'selected'; ?>>4 bathroom</option>
                <option value="5" <?php if($row['bathroom'] == '5') echo 'selected'; ?>>5 bathroom</option>
              </select>
            </div>
            <div>
              <p>how many balconys <span>*</span></p>
              <select name="balcony" required>
                <option value="0" <?php if($row['balcony'] == '0') echo 'selected'; ?> >0 balcony</option>
                <option value="1" <?php if($row['balcony'] == '1') echo 'selected'; ?>>1 balcony</option>
                <option value="2" <?php if($row['balcony'] == '2') echo 'selected'; ?>>2 balcony</option>
                <option value="3" <?php if($row['balcony'] == '3') echo 'selected'; ?>>3 balcony</option>
                <option value="4" <?php if($row['balcony'] == '4') echo 'selected'; ?> >4 balcony</option>
                <option value="5" <?php if($row['balcony'] == '5') echo 'selected'; ?>>5 balcony</option>  
              </select>
            </div>
            <div>
              <p>carpet area <span>*</span></p>
              <input
                type="number"
                name="carpet"
                required
                 value="<?php echo htmlspecialchars($row['carpet']); ?>"
                min="1"
                max="9999999999"
                maxlength="10"
                placeholder="how many squarefits?"
              />
            </div>
            <div>
              <p>property age <span>*</span></p>
              <input
                type="number"
                name="age"
                required
                value="<?php echo htmlspecialchars($row['age']); ?>"
                min="0"
                max="99"
                maxlength="2"
                placeholder="how old is property?"
              />
            </div>
            <div>
              <p>total floors <span>*</span></p>
              <input
                type="number"
                name="total_floors"
                required
                 value="<?php echo htmlspecialchars($row['total_floors']); ?>"
                min="0"
                max="99"
                maxlength="2"
                placeholder="how many floors available?"
              />
            </div>
            <div class="not-included-office-shop">
              <p>floor room <span>*</span></p>
              <input
                type="number"
                name="room_floor"
                required
                 value="<?php echo htmlspecialchars($row['room_floor']); ?>"
                min="0"
                max="99"
                maxlength="2"
                placeholder="property floor number"
                class="no-required"
              />
            </div>
            <div>
              <p>loan <span>*</span></p>
              <select name="loan" required>
                <option value="available">available</option>
                <option value="not available">not available</option>
              </select>
            </div>
          </div>
          <div>
            <p>property description <span>*</span></p>
            <textarea
              name="description"
              maxlength="1000"
              required
              cols=""
              rows="6"
              placeholder="write about property..."
            ><?php echo htmlspecialchars($row['description']); ?></textarea>
          </div>
          <div class="checkbox">
                    <div>
                        <p><input type="checkbox" name="lift" value="yes" <?php if($row['lift'] == 'yes') echo 'checked'; ?>> Lifts</p>
                        <p><input type="checkbox" name="security_guard" value="yes" <?php if($row['security_guard'] == 'yes') echo 'checked'; ?>> Security Guard</p>
                        <p><input type="checkbox" name="play_ground" value="yes" <?php if($row['play_ground'] == 'yes') echo 'checked'; ?>> Play Ground</p>
                        <p><input type="checkbox" name="garden" value="yes" <?php if($row['garden'] == 'yes') echo 'checked'; ?>> Garden</p>
                        <p><input type="checkbox" name="water_supply" value="yes" <?php if($row['water_supply'] == 'yes') echo 'checked'; ?>> Water Supply</p>
                        <p><input type="checkbox" name="power_backup" value="yes" <?php if($row['power_backup'] == 'yes') echo 'checked'; ?>> Power Backup</p>
                        <p><input type="checkbox" name="fire-security" value="yes" <?php if($row['fire_security'] == 'yes') echo 'checked'; ?>> Fire Alarm</p>
                    </div>
                    <div>
                        <p><input type="checkbox" name="parking_area" value="yes" <?php if($row['parking_area'] == 'yes') echo 'checked'; ?>> Parking Area</p>
                        <p><input type="checkbox" name="gym" value="yes" <?php if($row['gym'] == 'yes') echo 'checked'; ?>> Gym</p>
                        <p><input type="checkbox" name="cctv-cameras" value="yes" <?php if($row['cctv_cameras'] == 'yes') echo 'checked'; ?>> CCTV Cameras</p>
                        <p><input type="checkbox" name="shopping_mall" value="yes" <?php if($row['shopping_mall'] == 'yes') echo 'checked'; ?>> Shopping Mall</p>
                        <p><input type="checkbox" name="hospital" value="yes" <?php if($row['hospital'] == 'yes') echo 'checked'; ?>> Hospital</p>
                        <p><input type="checkbox" name="school" value="yes" <?php if($row['school'] == 'yes') echo 'checked'; ?>> School</p>
                        <p><input type="checkbox" name="market_area" value="yes" <?php if($row['market_area'] == 'yes') echo 'checked'; ?>> Market Area</p>
                    </div>
                </div>
          
          <div>
            <p>image 01 <span>*</span></p>
            <input type="file" name="image_01" accept="image/*" required />
          </div>
          <div class="property-flex">
            <div>
              <p>image 02</p>
              <input type="file" name="image_02" accept="image/*" />
            </div>
            <div>
              <p>image 03</p>
              <input type="file" name="image_03" accept="image/*" />
            </div>
            <div>
              <p>image 04</p>
              <input type="file" name="image_04" accept="image/*" />
            </div>
            <div>
              <p>image 05</p>
              <input type="file" name="image_05" accept="image/*" />
            </div>
          </div>
          <input type="submit" value="update property" class="btn" name="post" />
        </form>
      </div>
    </div>
    <?php  include("components/footer.php")?>
    <script src="./js/script.js"></script>
  </body>
</html>