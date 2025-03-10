<?php
session_name("USER_SESSION");
session_start();
include("components/connect.php");
function generateUniqueUserId($conn) {
  do {
      $user_id ="USR_". rand(1,9999);
      $check_query = "SELECT user_id FROM user_ragister WHERE user_id = '$user_id'";
      $result = $conn->query($check_query);
  } while ($result->num_rows > 0);
  return $user_id;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
 
    $user_id = generateUniqueUserId($conn);
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $email = $_POST['useremail'];
    $mobile = $_POST['number'];
    $password = $_POST['pass'];
    $con_pass = $_POST['con_pass'];
    
    if(isset($user_id) &&
    isset($fname) && isset($lname)&& isset($age) && isset($email) && isset($mobile) && isset($password) && isset($con_pass)){

        $sql = "INSERT INTO user_ragister (user_id, fname, lname, age, email, mobile, password) 
                VALUES ('$user_id', '$fname', '$lname', '$age', '$email', '$mobile', '$password')";

        if ($conn->query($sql) === TRUE) {
          $_SESSION['user_id'] = $user_id;
          $_SESSION['user_email'] = $email;
          $_SESSION['success_msg'][] = "Ragistartion Successfully!";
          header("location:login.php");
           exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ragistration</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>

    <div class="form-container form-center">
      <div class="my-form">
        <form action="<?=$_SERVER['PHP_SELF'];?>" onsubmit="return funcvalidation()" method="post">
          <h2>Create An Account</h2>
          <input
            type="text"
            name="fname"
            id="fname"
            placeholder="enter first name"
          />
          <span class="validation-span" id="errfname"></span>
          <input
            type="text"
            name="lname"
            id="lname"
            placeholder="enter last name"
                      />
                      <span class="validation-span" id="errlname"></span>
          <input
            type="text"
            name="age"
            id="age"
            placeholder="enter your age"
                   />
                   <span class="validation-span" id="errage"></span>
          <input
            type="text"
            name="useremail"
             id="email"
            placeholder="enter your email"

                     />
                     <span class="validation-span" id="erremail"></span>
          <input
            type="text"
            name="number"
            id="mobile"
            placeholder="enter mobile number"
                    />
                    <span class="validation-span" id="errmobile"></span>
          <div class="field-password">
            <input
              type="password"
              name="pass"
              id="password"
              placeholder="enter your password"
                        />
              <i class="fa fa-eye field-icon" id="eye" aria-hidden="true"></i>
               </div>
            <span class="validation-span" id="errpassword"></span>
          <input
            type="password"
            name="con_pass"
            id="conpass"
            placeholder="confirm password"
                    />
            <span class="validation-span" id="errconpass"></span>
          <p>already have an account? <a href="login.php">Login Now</a></p>
          <input type="submit" value="Register Now" name="submit" class="btn" />
        </form>
      </div>
    </div>
    <!-- <?php  include("components/footer.php")?> -->

    <script src="js/script.js"></script>
  </body>
</html>
