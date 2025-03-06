<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Function to display messages with SweetAlert2
    function displayAlert($type, $sessionKey) {
        if (isset($_SESSION[$sessionKey])) {
            foreach ($_SESSION[$sessionKey] as $msg) {
                echo "Swal.fire({
                    title: '$msg',
                    icon: '$type',
                    confirmButtonColor: '#3085d6'
                });";
            }
            unset($_SESSION[$sessionKey]); // Clear messages after displaying
        }
    }
    
    // Display different types of messages
    displayAlert("success", "success_msg");
    displayAlert("warning", "warning_msg");
    displayAlert("info", "info_msg");
    displayAlert("error", "error_msg");
    ?>
});
</script>
