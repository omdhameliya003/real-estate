<?php
session_name("USER_SESSION");
session_start();
include("components/connect.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request!");
}

$property_id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "DELETE FROM postproperty WHERE id='$property_id' AND user_id='{$_SESSION['user_id']}'";

if (mysqli_query($conn, $query)) {
    $_SESSION['success_msg'][] = "Property deleted successfully!";
    header("Location: my_listing.php");
    exit();
} else {
    echo "Error deleting property: " . mysqli_error($conn);
}
?>
