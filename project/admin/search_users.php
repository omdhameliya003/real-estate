<?php
include "../components/connect.php";

$search = isset($_POST['search']) ? trim($_POST['search']) : '';

$sql = "SELECT * FROM user_ragister";
if ($search !== '') {
    $sql .= " WHERE user_id LIKE '%$search%' OR fname LIKE '%$search%' OR email LIKE '%$search%'";
}
$sql .= " ORDER BY user_id DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['fname']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><button><a href="?delete_user=<?php echo $user['user_id']; ?>">Delete</a></button></td>
        </tr>
    <?php }
} else {
    echo "<tr><td colspan='4'>No users found</td></tr>";
}
?>
