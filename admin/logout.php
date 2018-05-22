<?php
include'../file.php';
session_start();
session_unset();
session_destroy();
echo "<script>location.href=('".$base_url."')</script>";

?>