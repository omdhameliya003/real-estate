<?php
session_name("USER_SESSION");
session_start();
include("components/connect.php"); 

if (!isset($_GET['property_id']) || !isset($_SESSION['user_id'])) {
    die("Invalid request.");
}

if (isset($_GET['prev'])) {
    $_SESSION['prev_page'] = $_GET['prev'];
}

$property_id = $_GET['property_id'];
$user_id = $_SESSION['user_id'];

// for comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['comment'])) {
    $comment = $conn->real_escape_string(trim($_POST['comment']));
    
    $insert_query = "INSERT INTO comments (property_id, user_id, comment) VALUES ('$property_id', '$user_id', '$comment')";
    $conn->query($insert_query);
    
    // for redirect to prevent form resubmission
    header("Location: comments.php?property_id=$property_id");
    exit();
}

$comments_query = "SELECT c.* , u.fname ,u.lname
                 FROM comments c 
                 JOIN user_ragister u 
                 ON c.user_id = u.user_id COLLATE utf8mb4_general_ci
                 WHERE c.property_id = '$property_id' COLLATE utf8mb4_general_ci
                 ORDER BY c.id DESC";
$comments_result = $conn->query($comments_query);

function timeAgo($timestamp) {
    date_default_timezone_set('Asia/Kolkata');
    $time_ago = strtotime($timestamp);
    $cur_time = time();
    $time_elapsed = $cur_time - $time_ago;

    if ($time_elapsed < 60) {
        return $time_elapsed . " sec ago";
    } elseif ($time_elapsed < 3600) {
        return round($time_elapsed / 60) . " min ago";
    } elseif ($time_elapsed < 86400) {
        return round($time_elapsed / 3600) . " hours ago";
    } elseif ($time_elapsed < 2628000) {
        return round($time_elapsed / 86400) . " days ago";
    } elseif ($time_elapsed < 31536000) {
        return round($time_elapsed / 2628000) . " months ago";
    } else {
        return round($time_elapsed / 31536000) . " years ago";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        
    </style>
</head>
<body>
<div class="comment-container">
<button class="btn-goback-comment" onclick="goBack()">← Go Back</a></button>
    <!-- <a href="javascript:history.back()" class="go-back">← Go Back</a> -->
    
    <h2>Leave a Comment</h2>
    
    <form action="" method="POST" class="comment-form">
        <textarea name="comment" placeholder="Write your comment..." required></textarea>
        <button type="submit">Add Comment</button>
    </form>

    <h3>All Comments</h3>
    
    <?php
    if ($comments_result->num_rows > 0) {
        while ($row = $comments_result->fetch_assoc()) {
            echo '<div class="comment">
                    <strong>' . htmlspecialchars($row['fname'])." " .htmlspecialchars($row['lname']). ':</strong> 
                    ' . htmlspecialchars($row['comment']) . ' 
                    <time>' . timeAgo($row['date']) . '</time>
                  </div>';
        }
    } else {
        echo "<p>No comments yet. Be the first to comment!</p>";
    }
    ?>
</div>

<script>
    function goBack() {
        let prevPage = "<?php echo isset($_SESSION['prev_page']) ? $_SESSION['prev_page'] : 'property_listing.php'; ?>";
        window.location.href = prevPage; 
    }
</script>
</body>
</html>
