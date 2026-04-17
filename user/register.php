<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../db.php';

if(isset($_POST['register'])){

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];

if(empty($name) || empty($email) || empty($phone) || empty($password)){
    echo "<script>alert('All fields are required');</script>";
}else{

$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name,email,phone,password) 
VALUES ('$name','$email','$phone','$hashed')";

if($conn->query($sql)){
    echo "<script>alert('Account created successfully'); window.location='login.php';</script>";
}else{
    echo "Error: ".$conn->error;
}
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register - Burn Club</title>

<style>

/* BACKGROUND */
body{
margin:0;
font-family:Arial;
height:100vh;
background:url('../images/image6.jpg') no-repeat center center/cover;
display:flex;
justify-content:center;
align-items:center;
}

/* DARK OVERLAY */
.overlay{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.75);
}

/* REGISTER BOX */
.register-box{
position:relative;
z-index:1;
background:rgba(0,0,0,0.9);
padding:40px;
border-radius:15px;
width:330px;
box-shadow:0 10px 40px rgba(0,0,0,0.9);
text-align:center;
transition:0.3s;
}

.register-box:hover{
transform:scale(1.02);
}

/* TITLE */
h1{
color:#ffcc00;
font-size:20px;
margin-bottom:10px;
}

p{
color:#ccc;
font-size:13px;
margin-bottom:20px;
}

/* INPUT */
input{
width:100%;
padding:12px;
margin:10px 0;
border:none;
border-radius:10px;
background:#111;
color:white;
outline:none;
transition:0.3s;
}

input:focus{
box-shadow:0 0 10px rgba(255,0,0,0.6);
}

/* BUTTON */
button{
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:linear-gradient(45deg,#ff0000,#ffcc00);
color:white;
font-weight:bold;
cursor:pointer;
transition:0.3s;
}

button:hover{
opacity:0.85;
}

/* LINK */
a{
display:block;
margin-top:15px;
color:#ffcc00;
text-decoration:none;
font-size:14px;
}

</style>

</head>

<body>

<div class="overlay"></div>

<div class="register-box">

<h1>THE BURN CLUB GYM MANAGEMENT SYSTEM</h1>

<p>"Start your journey. Stay consistent. Become unstoppable."</p>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email Address" required>

<input type="text" name="phone" placeholder="Phone Number" required>

<input type="password" name="password" placeholder="Password" required>

<button name="register">Register</button>

</form>

<a href="login.php">Already have an account?</a>

</div>

</body>
</html>