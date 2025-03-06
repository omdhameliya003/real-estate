<?php
include "alert.php";
date_default_timezone_set('Asia/Kolkata');
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "realestate_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

