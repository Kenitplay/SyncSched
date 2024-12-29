<?php
// logout.php
session_start();
session_destroy();
header('location: FRONTENDPHP/index.html');
exit;
?>
