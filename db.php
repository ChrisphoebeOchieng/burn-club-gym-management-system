<?php
$conn = new mysqli("localhost","root","","the_burn_club");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>
