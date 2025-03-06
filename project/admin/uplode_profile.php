<?php
session_start();

$upload_dir = "uplodes_admin/";

if (isset($_FILES['profile_image'])) {
    $file_name = basename($_FILES["profile_image"]["name"]);
    $target_file = $upload_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Invalid file type");
    }

    // Move file to uploads folder
    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        $_SESSION['admin_image'] = $target_file; // Save in session
        echo $target_file; // Return the new image path for AJAX
    } else {
        echo "Error uploading file";
    }
}
?>
