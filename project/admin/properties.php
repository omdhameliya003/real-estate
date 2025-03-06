<?php 
session_start(); 
if (!isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit;
}  
include "../components/connect.php";  
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Properties</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="content">
            <h2>All Properties</h2>
            
            <!-- Search Box -->
            <input type="text" id="search" placeholder="Search by City, Property name or Type" onkeyup="searchProperties()"  />

            <table>
                <thead>
                    <tr>
                        <th>Property Name</th>
                        <th>Type</th>
                        <th>Offer</th>
                        <th>Price</th>
                        <th>Rent</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="propertyTable">
                    <?php 
                    $properties = $conn->query("SELECT id, property_name, type, offer, price, city FROM postproperty ORDER BY id DESC");
                    while ($property = $properties->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $property['property_name']; ?></td>
                            <td><?php echo $property['type']; ?></td>
                            <td><?php echo $property['offer']; ?></td>
                            <td><?php echo ($property['offer'] == 'sale') ? $property['price'] : '-'; ?></td>
                            <td><?php echo ($property['offer'] == 'rent') ? $property['price'] : '-'; ?></td>
                            <td><?php echo $property['city']; ?></td>
                            <td><button><a href="view_property_admin.php?id=<?php echo $property['id']; ?>">View</a></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function searchProperties() {
            let query = document.getElementById("search").value;
            $.ajax({
                url: "search_properties.php",
                method: "POST",
                data: {search: query},
                success: function(response) {
                    document.getElementById("propertyTable").innerHTML = response;
                }
            });
        }
    </script>
</body>
</html>
