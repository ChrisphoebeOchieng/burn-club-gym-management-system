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

/* ADD ACTIVITY */
if(isset($_POST['add'])){
    $activity = $_POST['activity'];
    $category = $_POST['category'];
    $date = $_POST['date'];

    $conn->query("INSERT INTO activity_bookings (user_email, activity, category, date)
    VALUES ('$email','$activity','$category','$date')");
}

/* DATA */
$workouts = $conn->query("SELECT COUNT(*) as t FROM activity_bookings WHERE user_email='$email'")->fetch_assoc()['t'];
$goal = 20;
$calories = $workouts * 50;

/* BOOKINGS */
$result = $conn->query("SELECT * FROM activity_bookings WHERE user_email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Workout - Burn Club</title>

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
    backdrop-filter:blur(10px);
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

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

/* GRID */
.grid-2{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:30px;
}

/* CARD */
.card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 40px rgba(0,0,0,0.6);
}

/* HEADINGS */
.card h2{
    color:#ffcc00;
    margin-bottom:15px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    margin-bottom:12px;
}

/* BUTTON */
.btn{
    padding:10px 15px;
    border:none;
    border-radius:10px;
    background:linear-gradient(45deg,#ff0000,#ffcc00);
    color:white;
    cursor:pointer;
}

/* FLEX */
.row{
    display:flex;
    gap:10px;
    margin-bottom:10px;
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

<h1>Book Activities</h1>

<!-- STATS -->
<div class="stats">

<div class="card">
<h2><?php echo $workouts; ?></h2>
<p>Workouts Done</p>
</div>

<div class="card">
<h2><?php echo $goal; ?></h2>
<p>Your Goal</p>
</div>

<div class="card">
<h2><?php echo $calories; ?> kcal</h2>
<p>Calories Burned</p>
</div>

</div>

<!-- PROGRESS -->
<div class="card">
<h2>Update Fitness Progress</h2>
<input type="number" placeholder="Goal">
<input type="number" placeholder="Calories">
<button class="btn">Save</button>
</div>

<!-- ACTIVITIES -->
<div class="grid-2">

<!-- OUTDOOR -->
<div class="card">
<h2>Outdoor</h2>

<form method="POST">
<div class="row">
<input type="date" name="date">
<input type="hidden" name="activity" value="Running">
<input type="hidden" name="category" value="Outdoor">
<button name="add" class="btn">Running</button>
</div>
</form>

<form method="POST">
<div class="row">
<input type="date" name="date">
<input type="hidden" name="activity" value="Hiking">
<input type="hidden" name="category" value="Outdoor">
<button name="add" class="btn">Hiking</button>
</div>
</form>

</div>

<!-- INDOOR -->
<div class="card">
<h2>Indoor</h2>

<form method="POST">
<div class="row">
<input type="date" name="date">
<input type="hidden" name="activity" value="Gym">
<input type="hidden" name="category" value="Indoor">
<button name="add" class="btn">Gym</button>
</div>
</form>

<form method="POST">
<div class="row">
<input type="date" name="date">
<input type="hidden" name="activity" value="Yoga">
<input type="hidden" name="category" value="Indoor">
<button name="add" class="btn">Yoga</button>
</div>
</form>

</div>

</div>

<!-- BOOKINGS -->
<div class="card">
<h2>My Bookings</h2>

<table>
<tr>
<th>Activity</th>
<th>Category</th>
<th>Date</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['activity']; ?></td>
<td><?php echo $row['category']; ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>