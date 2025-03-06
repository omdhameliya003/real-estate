<?php
 include("<components/alert.php");
session_name("USER_SESSION");
session_start();
session_destroy();
header("Location: login.php");
exit();
?>