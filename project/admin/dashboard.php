<?php
session_name("ADMIN_SESSION");
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include "../components/connect.php";

$total_users = $conn->query("SELECT COUNT(*) FROM user_ragister")->fetch_row()[0];
$total_properties = $conn->query("SELECT COUNT(*) FROM postproperty")->fetch_row()[0];
$total_houses = $conn->query("SELECT COUNT(*) FROM postproperty WHERE type='house'")->fetch_row()[0];
$total_flats = $conn->query("SELECT COUNT(*) FROM postproperty WHERE type='flat'")->fetch_row()[0];
$total_shops = $conn->query("SELECT COUNT(*) FROM postproperty WHERE type='shop'")->fetch_row()[0];
$total_offices = $conn->query("SELECT COUNT(*) FROM postproperty WHERE type='office'")->fetch_row()[0];

// Fetch property availability (for sale or rent)
$property_status = ['house' => [0, 0], 'flat' => [0, 0], 'shop' => [0, 0], 'office' => [0, 0]];
$status_query = $conn->query("SELECT offer, type, COUNT(*) as count FROM postproperty GROUP BY offer, type");
while ($row = $status_query->fetch_assoc()) {
    $property_status[$row['type']][$row['offer'] == 'sale' ? 0 : 1] = $row['count'];
}

// Property Listings Per Week (Last 7 days)
$weekly_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $count = $conn->query("SELECT COUNT(*) FROM postproperty WHERE DATE(date) = '$date'")->fetch_row()[0];
    $weekly_data[$date] = $count;
}

// Latest Property Listings
$latest_properties = $conn->query("SELECT property_name, type,offer, city FROM postproperty ORDER BY id DESC LIMIT 5");

// Recent User Registrations
$recent_users = $conn->query("SELECT user_id, fname, email FROM user_ragister ORDER BY user_id DESC LIMIT 5");

// Top Performing Properties (Most Views or Saves)
// $top_properties = $conn->query("SELECT property_name, views, saves FROM postproperty ORDER BY views DESC, saves DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include "admin_sidebar.php" ?>
        <div class="content">
            <h2>Admin Dashboard</h2>
            
            <div class="stats-container">
                <div class="stat-box"><span class="count"><?php echo $total_users; ?></span><span class="label">Total Users</span></div>
                <div class="stat-box"><span class="count"><?php echo $total_properties; ?></span><span class="label">Total Properties</span></div>
                <div class="stat-box"><span class="count"><?php echo $total_houses; ?></span><span class="label">Total Houses</span></div>
                <div class="stat-box"><span class="count"><?php echo $total_flats; ?></span><span class="label">Total Flats</span></div>
                <div class="stat-box"><span class="count"><?php echo $total_shops; ?></span><span class="label">Total Shops</span></div>
                <div class="stat-box"><span class="count"><?php echo $total_offices; ?></span><span class="label">Total Offices</span></div>
            </div>
            <hr>

            <div class="chart-container">
                <canvas id="propertyPieChart"></canvas><br><hr>
                <canvas id="propertyBarChart"></canvas>
            </div>
            <hr>

            <!-- Property Listings Per Week -->
            <h3>Property Listings Per Week</h3>
            <canvas id="weeklyListingsChart"></canvas>
              <br> <hr>
            <!-- Latest Property Listings -->
            <h3>Latest Property Listings</h3>
            <table>
                <tr>
                    <th>Property Name</th>
                    <th>Type</th>
                    <th>offer</th>
                    <th>City</th>
                </tr>
                <?php while ($property = $latest_properties->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $property['property_name']; ?></td>
                    <td><?php echo $property['type']; ?></td>
                    <td><?php echo $property['offer']; ?></td>
                    <td><?php echo $property['city']; ?></td>
                </tr>
                <?php } ?>
            </table>
            <!-- Recent User Registrations -->
            <h3>Recent User Registrations</h3>
            <table>
                <tr><th>User ID</th><th>Name</th><th>Email</th></tr>
                <?php while ($user = $recent_users->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['fname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
                     // Pie Chart
        var ctxPie = document.getElementById('propertyPieChart').getContext('2d');
        var pieLabels = ['Houses', 'Flats', 'Shops', 'Offices'];
        var pieData = [<?php echo $total_houses; ?>, <?php echo $total_flats; ?>, <?php echo $total_shops; ?>, <?php echo $total_offices; ?>];
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: pieLabels.map((label, index) =>` ${label} (${pieData[index]})`),
                datasets: [{
                    label: 'Properties',
                    data: pieData,
                    backgroundColor: ['blue', 'green', 'red', 'purple']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / sum) * 100).toFixed(1) + "%";
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Bar Chart
        var ctxBar = document.getElementById('propertyBarChart').getContext('2d');
        var barLabels = ['Houses', 'Flats', 'Shops', 'Offices'];
        var barDataForSale = [<?php echo $property_status['house'][0]; ?>, <?php echo $property_status['flat'][0]; ?>, <?php echo $property_status['shop'][0]; ?>, <?php echo $property_status['office'][0]; ?>];
        var barDataForRent = [<?php echo $property_status['house'][1]; ?>, <?php echo $property_status['flat'][1]; ?>, <?php echo $property_status['shop'][1]; ?>, <?php echo $property_status['office'][1]; ?>];
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'For Sale',
                    data: barDataForSale,
                    // backgroundColor: 'rgba(0, 255, 255, 0.5)',
                    backgroundColor: '#4169E1',
                    // borderColor: 'rgba(0, 255, 255, 1)',
                    borderColor: '#1E3A8A',
                    borderWidth: 1
                }, {
                    label: 'For Rent',
                    data: barDataForRent,
                    // backgroundColor: 'rgba(255, 0, 255, 0.5)',
                    backgroundColor: '#DAA520',
                    // borderColor: 'rgba(255, 0, 255, 1)',
                    borderColor: '#8B6508',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / sum) * 100).toFixed(1) + "%";
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
                </script>

    <script>
        // Weekly Listings Chart
        var ctxWeek = document.getElementById('weeklyListingsChart').getContext('2d');
        var weeklyData = <?php echo json_encode(array_values($weekly_data)); ?>;
        var weeklyLabels = <?php echo json_encode(array_keys($weekly_data)); ?>;

        var weeklyChart = new Chart(ctxWeek, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Properties Listed',
                    data: weeklyData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
