<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../config.php';

$total_properties = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM properties"))['count'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_comments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM comments"))['count'];
$total_enquiries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM enquery"))['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-container">
        <h1>Welcome, Admin</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Manage Users</a></li>
                <li><a href="properties.php">Manage Properties</a></li>
                <li><a href="comments.php">Manage Comments</a></li>
                <li><a href="enquiries.php">Manage Enquiries</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <canvas id="adminChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('adminChart').getContext('2d');
        var adminChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Properties', 'Users', 'Comments', 'Enquiries'],
                datasets: [{
                    label: 'Admin Statistics',
                    data: [<?php echo $total_properties; ?>, <?php echo $total_users; ?>, <?php echo $total_comments; ?>, <?php echo $total_enquiries; ?>],
                    backgroundColor: ['blue', 'green', 'red', 'orange']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>