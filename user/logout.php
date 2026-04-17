<?php
session_start();
session_unset();
session_destroy();

/* FORCE CORRECT PATH ALWAYS */
header("Location: /the_burn_club_final/user/login.php");
exit();
?>