<?php
session_name("USER_SESSION");
session_start();
include("components/connect.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if (isset($_GET['id']) && isset($_GET['user_id']) && isset($_GET['owener_id'])) {
   

    $property_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']); // User who clicked the button
    $owener_id = mysqli_real_escape_string($conn, $_GET['owener_id']); 

    $check_query = "SELECT * FROM request WHERE user_id = '$user_id' AND property_id = '$property_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['warning_msg'][] = "You have already sent an enquiry for this property.";
        header("Location: " . $_SERVER['HTTP_REFERER']); 
        exit();
    } else {
 
    $query = "INSERT INTO request(user_id,owener_id, property_id, request_date) VALUES ('$user_id','$owener_id', '$property_id', NOW())";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success_msg'][] = "Your enquiry has been sent successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']); 
        exit();
    } else {
        $_SESSION['error_msg'][] = "Failed to send enquiry!";
        header("Location: " . $_SERVER['HTTP_REFERER']); 
        exit();
    }
} 

}
?>