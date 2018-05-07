<?php
session_start();
session_destroy();
header("Location: index.php?alert=You have logged out of your hosting account.");
?>