<?php
session_start();
$_SESSION['email'] = NULL;
echo '<script>window.location.href = "home.php";</script>';
exit;
?>