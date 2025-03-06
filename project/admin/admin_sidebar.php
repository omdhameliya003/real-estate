<?php
$default_image = '../images/pic-3';

// Check if an image is already uploaded and stored in session
$admin_image = isset($_SESSION['admin_image']) ? $_SESSION['admin_image'] : $default_image;
?>
<div class="sidebar">
            <div class="sidebar-top">
               <div class="profile-container">
                     <img id="adminProfile" src="<?php echo $admin_image; ?>" alt="">
                     <label for="fileInput" class="camera-icon">
                     <i class="fas fa-camera"></i>
                      </label>
                 <input type="file" id="fileInput" accept="image/*" style="display: none;">
              </div>
                       <h2>Welcome, Admin</h2>
            </div>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="properties.php">View Properties</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
 </div>

 <script>
document.getElementById("fileInput").addEventListener("change", function() {
    let file = this.files[0];
    if (file) {
        let formData = new FormData();
        formData.append("profile_image", file);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "uplode_profile.php", true);
        
        xhr.onload = function() {
            if (xhr.status == 200) {
                document.getElementById("adminProfile").src = xhr.responseText; // Update the image dynamically
            } else {
                alert("Image upload failed!");
            }
        };
        
        xhr.send(formData);
    }
});
</script>
