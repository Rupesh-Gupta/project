<?php
session_unset();
session_destroy();
header("location: main.php");
?>