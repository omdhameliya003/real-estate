
<?php
session_name("USER_SESSION");
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include("components/connect.php"); 

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to save properties.");
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET['id'] ?? '';
$action = $_GET['action'] ?? '';

if (!$property_id || !in_array($action, ['save', 'remove'])) {
    die("Invalid request.");
}

if ($action == 'save') {
    $check_saved = mysqli_query($conn, "SELECT * FROM saved_properties WHERE user_id='$user_id' AND property_id='$property_id'");

    if (mysqli_num_rows($check_saved) == 0) {
        // Only insert if not already saved
        $query = "INSERT INTO saved_properties (user_id, property_id) VALUES ('$user_id', '$property_id')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success_msg'][] = "Property saved successfully";
          echo "<script> window.history.back();</script>";
          exit();
       } else {
        echo "Error: " . mysqli_error($conn);
          }
    }
    }
 else {
    // Remove the saved property
    $query = "DELETE FROM saved_properties WHERE user_id='$user_id' AND property_id='$property_id'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_msg'][] = "Property removed from saved list!";
    echo "<script> window.history.back();</script>";
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
}

?>
