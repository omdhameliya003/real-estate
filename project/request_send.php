<?php
session_start();
include("components/connect.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}
$user_id = $_SESSION['user_id'];
$request_query = "SELECT request.id AS request_id, request.property_id, request.request_date, 
                         postproperty.property_name, postproperty.id AS property_id,
                         user_ragister.fname, user_ragister.email, user_ragister.mobile
                  FROM request 
                  JOIN postproperty ON request.property_id = postproperty.id
                  JOIN user_ragister ON request.user_id COLLATE utf8mb4_general_ci = user_ragister.user_id COLLATE utf8mb4_general_ci
                  WHERE request.user_id COLLATE utf8mb4_general_ci = '$user_id'
                  ORDER BY request.request_date DESC";

$request_result = mysqli_query($conn, $request_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include("components/header.php"); ?>

    <div class="requiest-container">
        <h2>All Requests</h2>
        <div class="requiest-cards">
            <?php if (mysqli_num_rows($request_result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($request_result)) { ?>
                    <div class="requiest-card">
                        <p><i class="fa fa-user"></i>Name: <span><?php echo htmlspecialchars($row['fname']); ?></span></p>
                        <p><i class="fa fa-phone"></i>Number: <span><?php echo htmlspecialchars($row['mobile']); ?></span></p>
                        <p><i class="fa fa-envelope"></i>Email: <span><?php echo htmlspecialchars($row['email']); ?></span></p>
                        <p> <i class="fa fa-building"></i>Enquiry for: <span><?php echo htmlspecialchars($row['property_name']); ?></span></p>
                        <p><i class="fa fa-calendar"></i> Enquiry Date: 
                               <span><?php echo date("F j, Y", strtotime($row['request_date'])); ?></span>
                        </p>
                         <p><i class="fa fa-clock-o"></i> Enquiry Time: 
                                <span><?php echo date("g:i A", strtotime($row['request_date'])); ?></span>
                        </p>
                        <button class="btndelete" onclick="deleteRequest('<?php echo $row['request_id']; ?>')">Delete Request</button>
                        <button class="btnview_property"><a href="view_property.php?id=<?php echo $row['property_id']; ?>">View Property</a></button>
                    </div>
                <?php } ?>

            <?php } else { 
              echo'
                <div class="no_request">
                <p>
                  No requests sent for any property.
                </p>
                </div>
              ';
            } 
              ?>
              
        </div>
    </div>

    <?php include("components/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function deleteRequest(requestId) {
        Swal.fire({
            title: "Are you sure?",
            text: "you want to delete this request!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete_request.php?id=" + requestId;
            }
        });
    }
</script>
    <!-- <script>
        function deleteRequest(requestId) {
            if (confirm("Are you sure you want to delete this request?")) {
                window.location.href = "delete_request.php?id=" +requestId;
            }
        }
    </script> -->
</body>
</html>