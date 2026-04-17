<?php
session_start();
include '../db.php';

$message = "";

if(isset($_POST['add'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if(empty($name) || empty($email) || empty($_POST['password'])){
        $message = "All fields are required!";
    } else {

        $check = $conn->query("SELECT * FROM users WHERE email='$email'");
        if($check->num_rows > 0){
            $message = "User already exists!";
        } else {

            $conn->query("INSERT INTO users (name, email, password, role) 
                          VALUES ('$name','$email','$password','$role')");

            $message = "Member added successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Member - Burn Club</title>

<style>
body{
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)),
                url('../images/image11.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family:'Segoe UI', sans-serif;
    color:white;
    margin:0;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    width:230px;
    height:100%;
    background:rgba(0,0,0,0.9);
    padding:20px;
}
.sidebar h2{color:#ffcc00;}
.sidebar a{
    display:block;
    color:#bbb;
    margin:12px 0;
    text-decoration:none;
}
.sidebar a:hover{color:#ffcc00;}

/* MAIN */
.main{
    margin-left:250px;
    padding:30px;
}

/* CARD */
.card{
    max-width:500px;
    margin:auto;
    background:rgba(255,255,255,0.05);
    padding:30px;
    border-radius:15px;
}

/* INPUTS */
input, select{
    width:100%;
    height:50px;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:10px;
    box-sizing:border-box;
    font-size: 14px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(90deg,#ff512f,#f09819);
    color:white;
    font-weight:bold;
    cursor:pointer;
}

/* MESSAGE */
.msg{
    text-align:center;
    margin-bottom:10px;
    color:#00ffcc;
}
</style>

</head>

<body>

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="dashboard.php">Dashboard</a>
<a href="users.php">Members</a>
<a href="add_member.php">Add Member</a>
<a href="reports.php">Reports</a>
<a href="../user/logout.php">Logout</a>
</div>

<div class="main">

<h1>Add New Member</h1>

<div class="card">

<?php if($message){ ?>
<p class="msg"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name">

<input type="email" name="email" placeholder="Email">

<input type="password" name="password" placeholder="Password">

<select name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
</select>

<button name="add">Add Member</button>

</form>

</div>

</div>

</body>
</html>