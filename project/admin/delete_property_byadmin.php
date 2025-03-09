<?php
session_name("ADMIN_SESSION");
session_start();
include "../components/connect.php";

header("Content-Type: text/plain"); // Ensures proper response type

if (!isset($_SESSION['admin_logged_in'])) {
    exit("error");
}

if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
    $property_id = intval($_POST['id']); // Convert to integer

    // Use a prepared statement for security
    $stmt = $conn->prepare("DELETE FROM postproperty WHERE id = ?");
    $stmt->bind_param("i", $property_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        
        ob_clean(); // Clear output buffer if any unwanted output exists
        flush(); // Ensure data is sent immediately
        exit("success"); // Send success response
    } else {
        $stmt->close();
        $conn->close();

        ob_clean();
        flush();
        exit("error");
    }
}
$conn->close();
exit("error"); // In case ID is missing or invalid
