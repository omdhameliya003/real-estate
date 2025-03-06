<?php
session_start();
include("components/connect.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if (isset($_GET['id'])) {
    $request_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Delete only if the request belongs to the logged-in user
    $delete_query = "DELETE FROM request WHERE id = '$request_id' AND user_id = '$user_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        $_SESSION['success_msg'][] = "Request deleted successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']); 
        exit();
    } else {
        $_SESSION['error_msg'][] = "Failed to delete request!";
        header("Location: " . $_SERVER['HTTP_REFERER']); 
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
