<?php
session_name("USER_SESSION");
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include("components/connect.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT fname, email, mobile, password FROM user_ragister WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $fname = $row['fname'];
  $email = $row['email'];
  $mobile = $row['mobile'];
  $password = $row['password']; 
} else {
  echo "User not found";
  exit;
}

// Initialize error messages and form values
$fnameErr = $emailErr = $mobileErr = $oldpassErr = $newpassErr = $conpassErr = "";
$fnameValue = $emailValue = $mobileValue = "";
$successMsg = "";
$oldpass = $newpass = $con_pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fnameValue = $_POST["fname"];
    $emailValue = $_POST["email"];
    $mobileValue = $_POST["mobile"];
    $oldpass = $_POST["oldpass"];
    $newpass = $_POST["newpass"];
    $con_pass = $_POST["con_pass"];
    $valid = true;

    // Name Validation
    if (empty($fnameValue)) {
        $fnameErr = "* First name is required.";
        $valid = false;
    } elseif (strlen($fnameValue) < 2) {
        $fnameErr = "* First name must be at least 2 characters.";
        $valid = false;
    } elseif (!preg_match("/^[A-Za-z]+$/", $fnameValue)) {
        $fnameErr = "* First name should only contain letters.";
        $valid = false;
    } else{
      $fnameErr="";
    }

    // Email Validation
    if (empty($emailValue)) {
        $emailErr = "* Email is required.";
        $valid = false;
    } elseif (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "* Invalid email format.";
        $valid = false;
    } else{
      $emailErr="";
    }

    // Mobile Validation
    if (empty($mobileValue)) {
        $mobileErr = "* Mobile number is required.";
        $valid = false;
    } elseif (!preg_match("/^[0-9]{10}$/", $mobileValue)) {
        $mobileErr = "* Mobile number must be 10 digits.";
        $valid = false;
    }else{
      $mobileErr="";
    }

    // Old Password Validation
    if (empty($oldpass)) {
        $oldpassErr = "* Old password is required.";
        $valid = false;
    } elseif ($oldpass != $password) {
        $oldpassErr = "* Incorrect old password.";
        $valid = false;
    }else{
      $oldpassErr="";
    }

    // New Password Validation
    // if (empty($newpass)) {
    //     $newpassErr = "* New password is required.";
    //     $valid = false;
    // } elseif (strlen($newpass) < 8) {
    //     $newpassErr = "* Password must be at least 8 characters.";
    //     $valid = false;
    // }else{
    //   $newpassErr="";
    // }
    if (empty($newpass)) {
      $newpassErr = "* New password is required.";
      $valid = false;
  } elseif (strlen($newpass) < 8) {
      $newpassErr = "* Password must be at least 8 characters.";
      $valid = false;
  } elseif (!preg_match('/[A-Z]/', $newpass)) {
      $newpassErr = "* Password must contain at least one uppercase letter.";
      $valid = false;
  } elseif (!preg_match('/[a-z]/', $newpass)) {
      $newpassErr = "* Password must contain at least one lowercase letter.";
      $valid = false;
  } elseif (!preg_match('/[0-9]/', $newpass)) {
      $newpassErr = "* Password must contain at least one digit.";
      $valid = false;
  } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $newpass)) {
      $newpassErr = "* Password must contain at least one special character.";
      $valid = false;
  } else {
      $newpassErr = ""; // Clear error message if valid
  }
  

    // Confirm Password Validation
    if (empty($con_pass)) {
        $conpassErr = "* Confirm password is required.";
        $valid = false;
    } elseif ($newpass !== $con_pass) {
        $conpassErr = "* Passwords do not match.";
        $valid = false;
    }else{
      $conpassErr="";
    }

    // If all fields are valid, update the database
    if ($valid) {
        $update_sql = "UPDATE user_ragister SET fname='$fnameValue', email='$emailValue', mobile='$mobileValue', password='$newpass' WHERE user_id='$user_id'";
        
        if ($conn->query($update_sql) === TRUE) {
          $_SESSION['success_msg'][] = "Profile updated successfully!";
            // Clear fields after successful update
            // $fnameValue = $emailValue = $mobileValue = "";
            $oldpass=$newpass=$con_pass="";
            $fnameErr = $emailErr = $mobileErr = $oldpassErr = $newpassErr = $conpassErr = "";
            header("Location: updateprofile.php");
            exit();
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body onload="removeSuccessMsg()">

  <?php  include("components/header.php")?>
    <div class="form-container">
      <div class="my-form">
        <form action="" method="post">
          <h2>Update your Account!</h2>
          <input
            type="text"
            name="fname"
            id="updatefname"
            value="<?= $row['fname']; ?>"
            placeholder="<?=$row['fname']; ?>"
            class="input-box"
          />
          <span class="validation-span" id="errupdatefname"><?= $fnameErr; ?></span>

          <input
            type="email"
            name="email"
            id="updateemail"
            value="<?= $row['email']; ?>"
            placeholder="<?= $row['email']; ?>"
            class="input-box"
          />
          <span class="validation-span" id="errupdateemail"><?= $emailErr; ?></span>
          <input
            type="text"
            name="mobile"
            id="updatemobile"
            value="<?= $row['mobile']; ?>"
            placeholder="<?= $row['mobile']; ?>"
            class="input-box"
          />
          <span class="validation-span" id="errupdatemobile"><?= $mobileErr; ?></span>
          <div class="field-password">
          <input
            type="password"
            name="oldpass"
            value="<?= $oldpass; ?>"
            id="updateoldpass"
            placeholder="enter your old password"
            class="input-box"
          />
          <i class="fa fa-eye field-icon" id="eye" aria-hidden="true"></i>
        </div>
        <span class="validation-span" id="errupdateoldpass"><?= $oldpassErr; ?></span>
         
  
            <input
              type="password"
              name="newpass"
              value="<?= $newpass; ?>"
              id="updatenewpass"
              placeholder="enter your new password"
              class="input-box"
            />
            <span class="validation-span" id="errupdatenewpass"><?= $newpassErr; ?></span>
          
          <input
            type="password"
            name="con_pass"
            value="<?= $con_pass; ?>"
            id="updatecon_pass"
            placeholder="confirm password"
            class="input-box"
          />
          <span class="validation-span" id="errupdatecon_pass"><?= $conpassErr; ?></span>
          <input type="submit" value="Update Now" name="submit" class="btn" />
          <span class="success-msg" id="success-msg" style="color:green;"><?= $successMsg; ?></span>
        </form>
      </div>
    </div>
    <?php  include("components/footer.php")?>
 
    <script src="js/script.js"></script>
  </body>
</html>
