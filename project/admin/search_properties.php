<?php
include "../components/connect.php";

$search = isset($_POST['search']) ? trim($_POST['search']) : '';

$sql = "SELECT id, property_name, type, offer, price, city FROM postproperty";
if ($search !== '') {
    $sql .= " WHERE property_name LIKE '%$search%' OR city LIKE '%$search%' OR type LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($property = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $property['property_name']; ?></td>
            <td><?php echo $property['type']; ?></td>
            <td><?php echo $property['offer']; ?></td>
            <td><?php echo ($property['offer'] == 'sale') ? $property['price'] : '-'; ?></td>
            <td><?php echo ($property['offer'] == 'rent') ? $property['price'] : '-'; ?></td>
            <td><?php echo $property['city']; ?></td>
            <td class="action-btn "><button><a href="../view_property.php?id=<?php echo $property['id']; ?>">View</a></button>
            <button class="delete-btn" onclick="deleteProperty(<?php echo $property['id']; ?>)">Delete</button>
        </td>
        </tr>
    <?php }
} else {
    echo "<tr><td colspan='7'>No properties found</td></tr>";
}
?>
