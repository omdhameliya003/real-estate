<?php
session_name("ADMIN_SESSION");
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include "../components/connect.php";

if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $conn->query("DELETE FROM user_ragister WHERE user_id='$user_id'");
    $_SESSION['success_msg'][] = "User deleted successfully!";
    header("Location: manage_users.php");
    exit;
}

$users = $conn->query("SELECT * FROM user_ragister ORDER BY user_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="content">
            <h2>Manage Users</h2>

            <!-- Search Box -->
            <input type="text" id="search" placeholder="Search by ID, Name, or Email" onkeyup="searchUsers()" />

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <?php while ($user = $users->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['fname']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <!-- <td><button onclick="confirmDelete('<?php #echo $user['user_id']; ?>')" ><a href="?delete_user=<?php #echo $user['user_id']; ?>">Delete</a></button></td> -->

                            <td><button onclick="confirmDelete('<?php echo $user['user_id']; ?>')" >Delete</a></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchUsers() {
            let query = document.getElementById("search").value;
            $.ajax({
                url: "search_users.php",
                method: "POST",
                data: {search: query},
                success: function(response) {
                    document.getElementById("userTable").innerHTML = response;
                }
            });
        }

        function confirmDelete(userId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "manage_users.php?delete_user=" + userId;
        }
    });
}
    </script>
</body>
</html>
