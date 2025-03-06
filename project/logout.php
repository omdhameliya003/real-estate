<?php
 include("<components/alert.php");
session_start();
session_destroy();
header("Location: login.php");
exit();
?>