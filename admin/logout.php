<?php
require './header.php';
session_start();
session_unset();
session_destroy();
echo '<script>window.location.href="./admin.php"</script>';
?>