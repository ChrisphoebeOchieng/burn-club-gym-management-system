<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

/* SAVE */
if(isset($_POST['save'])){
    $protein = $_POST['protein'];
    $water   = $_POST['water'];
    $habit   = $_POST['habit'];

    $conn->query("INSERT INTO diet_logs (user_email, protein, water, habit)
    VALUES ('$email','$protein','$water','$habit')");
}

/* FETCH */
$result = $conn->query("SELECT * FROM diet_logs WHERE user_email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Diet Tracker - Burn Club</title>

<style>

/* BACKGROUND */
body{
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)),
                url('../images/image11.jpg') no-repeat center center fixed;
    background-size: cover;
    color:white;
    font-family:'Segoe UI', sans-serif;
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

/* HERO */
.hero{
    background:url('../images/image10.jpg') center/cover;
    height:180px;
    border-radius:20px;
    padding:20px;
    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    margin-bottom:30px;
}

.hero h1{margin:0;}
.hero p{color:#ccc;}

/* CARD */
.card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    border-radius:20px;
    padding:25px;
    margin-bottom:25px;
}

/* INPUT */
input, select{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    margin-bottom:12px;
}

/* BUTTON */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(45deg,#ff0000,#ffcc00);
    color:white;
    cursor:pointer;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:10px;
    border-bottom:1px solid #333;
}
th{color:#ffcc00;}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Burn Club</h2>
<a href="dashboard.php">Dashboard</a>
<a href="book_activity.php">Workout</a>
<a href="diet_log.php">Diet</a>
<a href="progress.php">Progress</a>
<a href="payments.php">Payments</a>
<a href="logout.php">Logout</a>
</div>

<div class="main">

<!-- HERO -->
<div class="hero">
<h1>Nutrition Tracker </h1>
<p>Discipline starts with what you eat</p>
</div>

<!-- FORM -->
<div class="card">
<h2>Track Your Daily Intake</h2>

<form method="POST">

<input type="number" name="protein" placeholder="Protein (grams)" required>

<input type="number" name="water" placeholder="Water (litres)" required>

<select name="habit" required>
<option value="">Select Healthy Habit</option>
<option>Clean Eating</option>
<option>No Sugar</option>
<option>High Protein</option>
<option>Hydrated</option>
</select>

<button name="save" class="btn">Save</button>

</form>
</div>

<!-- HISTORY -->
<div class="card">
<h2>My Diet Logs</h2>

<table>
<tr>
<th>Protein</th>
<th>Water</th>
<th>Habit</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['protein']; ?> g</td>
<td><?php echo $row['water']; ?> L</td>
<td><?php echo $row['habit']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>