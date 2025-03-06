
<?php
session_name("USER_SESSION");
session_start();
include("components/connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) ) {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    
    if(isset($email) && isset($password)){

    $sql = "SELECT user_id, password FROM user_ragister WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
    if ($password==$row['password']) {
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_email'] = $email;
     
      $_SESSION['success_msg'][] = 'User logged in successfully';
      header("Location: home.php");
      exit();
  } else {
       $_SESSION['error_msg'][] = "Incorrect password!";
       header("Location: login.php");
       exit();
  }  
}
else {
  $_SESSION['error_msg'][] = "No user found with this email!";
  header("Location: login.php");
  exit();
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>login</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
    <div class="form-container">
      <div class="my-form">
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
          <h2>Login</h2>
          <input
          type="email"
          name="email"
          placeholder="enter your email"
          class="input-box"
          require
          />
          <div class="field-password">
            <input
              type="password"
              name="pass"
              placeholder="enter your password"
              class="input-box"
              require
            />
            <i class="fa fa-eye field-icon" id="eye" aria-hidden="true"></i>
          </div>

          <p>don't have an account? <a href="ragister.php">Ragister Now</a></p>
          <input type="submit" value="Login Now" name="login" class="btn" />
        </form>
      </div>
    </div>
    <script src="js/script.js"></script>
  </body>
</html>
