<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../db.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])){

            $_SESSION['email'] = $row['email'];
            $_SESSION['name']  = $row['name'];
            $_SESSION['role']  = $row['role'];

            if($row['role'] == 'admin'){
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();

        } else {
            echo "<script>alert('Wrong password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - Burn Club</title>

<style>

/* BACKGROUND */
body{
margin:0;
font-family:Arial;
height:100vh;
background:url('../images/image8.jpg') no-repeat center center/cover;
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

/* LOGIN BOX */
.login-box{
position:relative;
z-index:1;
background:rgba(0,0,0,0.85);
padding:35px;
border-radius:15px;
width:320px;
box-shadow:0 10px 40px rgba(0,0,0,0.9);
text-align:center;
transition:0.3s;
}

/* HOVER EFFECT */
.login-box:hover{
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

<div class="login-box">

<h1>THE BURN CLUB GYM MANAGEMENT SYSTEM</h1>

<p>"Discipline is the bridge between goals and results."</p>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button name="login">Login</button>

</form>

<a href="register.php">Create Account</a>

</div>

</body>
</html>