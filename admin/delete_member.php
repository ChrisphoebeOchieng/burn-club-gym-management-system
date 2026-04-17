<?php
session_start();
include '../db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../user/login.php");
    exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $conn->query("DELETE FROM users WHERE id='$id'");
}

header("Location: view_members.php");
exit();