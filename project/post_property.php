  <?php
  // Include database connection
  session_name("USER_SESSION");
  session_start();
  $user_id=$_SESSION['user_id'];
  include("components/connect.php");

  if (isset($_POST["post"])) {
    
      // Sanitize input
      function clean($data) {
          global $conn;
          return mysqli_real_escape_string($conn, trim($data));
      }

      $fields = ['property_name', 'type', 'offer', 'price', 'deposite', 'address', 'city', 'state', 'status', 'furnished', 'bhk', 'bedroom', 'bathroom', 'balcony', 'carpet', 'age', 'total_floors', 'room_floor', 'loan', 'description'];
      $data = array_map('clean', array_intersect_key($_POST, array_flip($fields)));

      // Add the user_id to the data array
      $data['user_id'] = $user_id;

      // Features (checkboxes)
      $features = ['lift', 'security_guard', 'play_ground', 'garden', 'water_supply', 'power_backup', 'fire_security', 'parking_area', 'gym', 'cctv_cameras', 'shopping_mall', 'hospital', 'school', 'market_area'];
      foreach ($features as $feature) {
          $data[$feature] = isset($_POST[$feature]) ? 'yes' : 'no';
      }

      // Handle images
      $target_dir = "uploads/";
      for ($i = 1; $i <= 5; $i++) {
          $key = "image_0$i";
          if (!empty($_FILES[$key]['name'])) {
              $data[$key] = basename($_FILES[$key]['name']);
              move_uploaded_file($_FILES[$key]['tmp_name'], $target_dir . $data[$key]);
          } else {
              $data[$key] = '';
          }
      }

        // If the property type is "office" or "shop", set bhk to 0
      if ($data['type'] == 'office' || $data['type'] == 'shop') {
        $data['bhk'] = 0;
        $data['bedroom']=0;
        $data['bathroom']=0;
        $data['room_floor']=0;
    }

      // Insert into database
      $columns = implode(", ", array_keys($data));
      $values = "'" . implode("', '", $data) . "'";
      $query = "INSERT INTO postproperty ($columns) VALUES ($values)";

      if ($conn->query($query)) {
        $_SESSION['success_msg'][] = "Property Posted Successfully!";
        header("Location: home.php");
        exit();
      } else {
        $_SESSION['error_msg'][] = "Error: " . $conn->error;
        header("Location: post_property.php");
        exit();
      }

      $conn->close();
  }
  ?>




  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>post_property</title>
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
            <h3>Property Details</h3>
            <div>
              <p>property name <span>*</span></p>
              <input
                type="text"
                name="property_name"
                required
                placeholder="enter property name"
              />
            </div>
            <div class="property-flex">
            <div>
                <p>property type <span>*</span></p>
                <select name="type" id="property-type" onchange="togglePropertyFields()" required >
                  <option value="flat">flat</option>
                  <option value="house">house</option>
                  <option value="shop">shop</option>
                  <option value="office">office</option>
                </select>
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
                <p>property price <span>*</span></p>
                <input
                  type="number"
                  name="price"
                  required
                  min="0"
                  max="9999999999"
                  maxlength="10"
                  placeholder="enter property price or rent"
                />
              </div>
              <div>
                <p>deposite amount <span>*</span></p>
                <input
                  type="number"
                  name="deposite"
                  required
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
                  required
                  value="gujarat"
                  readonly
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
                  <option value="1">1 BHK</option>
                  <option value="2">2 BHK</option>
                  <option value="3">3 BHK</option>
                  <option value="4">4 BHK</option>
                  <option value="5">5 BHK</option>
                </select>
              </div>
              <div class="not-included-office-shop">
                <p>how many bedrooms <span>*</span></p>
                <select name="bedroom" required class="no-required">
                  <option value="0">0 bedroom</option>
                  <option value="1" selected>1 bedroom</option>
                  <option value="2">2 bedroom</option>
                  <option value="3">3 bedroom</option>
                  <option value="4">4 bedroom</option>
                  <option value="5">5 bedroom</option>
                </select>
              </div>
              <div class="not-included-office-shop">
                <p>how many bathrooms <span>*</span></p>
                <select name="bathroom" required class="no-required">
                  <option value="1">1 bathroom</option>
                  <option value="2">2 bathroom</option>
                  <option value="3">3 bathroom</option>
                  <option value="4">4 bathroom</option>
                  <option value="5">5 bathroom</option>
                </select>
              </div>
              <div>
                <p>how many balconys <span>*</span></p>
                <select name="balcony" required>
                  <option value="0">0 balcony</option>
                  <option value="1">1 balcony</option>
                  <option value="2">2 balcony</option>
                  <option value="3">3 balcony</option>
                  <option value="4">4 balcony</option>
                  <option value="5">5 balcony</option>  
                </select>
              </div>
              <div>
                <p>carpet area <span>*</span></p>
                <input
                  type="number"
                  name="carpet"
                  required
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
              ></textarea>
            </div>
            <div class="checkbox">
              <div>
                <p><input type="checkbox" name="lift" value="yes" />lifts</p>
                <p>
                  <input
                    type="checkbox"
                    name="security_guard"
                    value="yes"
                  />security guard
                </p>
                <p>
                  <input type="checkbox" name="play_ground" value="yes" />play
                  ground
                </p>
                <p><input type="checkbox" name="garden" value="yes" />garden</p>
                <p>
                  <input type="checkbox" name="water_supply" value="yes" />water
                  supply
                </p>
                <p>
                  <input type="checkbox" name="power_backup" value="yes" />power
                  backup
                </p>
                <p>
                  <input type="checkbox" name="fire-security" value="yes" />fire
                  alarm
                </p>
              </div>
              <div>
                <p>
                  <input type="checkbox" name="parking_area" value="yes" />parking
                  area
                </p>
                <p><input type="checkbox" name="gym" value="yes" />gym</p>
                <p>
                  <input type="checkbox" name="cctv-cameras" value="yes" />cctv
                  cameras
                </p>
                <p>
                  <input
                    type="checkbox"
                    name="shopping_mall"
                    value="yes"
                  />shopping_mall
                </p>
                <p>
                  <input type="checkbox" name="hospital" value="yes" />hospital
                </p>
                <p><input type="checkbox" name="school" value="yes" />school</p>
                <p>
                  <input type="checkbox" name="market_area" value="yes" />market
                  area
                </p>
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
            <input type="submit" value="post property" class="btn" name="post" />
          </form>
        </div>
      </div>
      <?php  include("components/footer.php")?>
      <script src="./js/script.js"></script>
    </body>
  </html>
