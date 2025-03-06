<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include "../components/connect.php";

if (isset($_GET['delete_message'])) {
    $message_id = $_GET['delete_message'];
    $conn->query("DELETE FROM messages WHERE id='$message_id'");
    header("Location: messages.php");
}
$messages = $conn->query("SELECT * FROM messages ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Messages</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="admin-container">
        <?php include "admin_sidebar.php" ?>
        <div class="content">
            <h2>Contact Messages</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>operation</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($msg = $messages->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $msg['name']; ?></td>
                            <td><?php echo $msg['email']; ?></td>
                            <td class="message-column"><?php echo $msg['message']; ?></td>
                            <td><?php echo $msg['submitted_at']; ?></td>
                            <td class="messages-btn">
                                <button><a href="reply_message.php?message_id=<?php echo $msg['id']; ?>">replay</a></button>
                                <button><a href="?delete_message=<?php echo $msg['id']; ?>">delete</a></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</body>

</html>