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
$name  = $_SESSION['name'];


$total_workouts = $conn->query("SELECT COUNT(*) as t FROM workout_logs WHERE user_email='$email'")->fetch_assoc()['t'] ?? 0;
$total_diets    = $conn->query("SELECT COUNT(*) as t FROM diet_logs WHERE user_email='$email'")->fetch_assoc()['t'] ?? 0;


$latest_workout = $conn->query("SELECT workout_type FROM workout_logs WHERE user_email='$email' ORDER BY id DESC LIMIT 1")->fetch_assoc()['workout_type'] ?? '—';

$latest_diet_row = $conn->query("SELECT protein, habit FROM diet_logs WHERE user_email='$email' ORDER BY id DESC LIMIT 1")->fetch_assoc();

$latest_diet = $latest_diet_row 
    ? ($latest_diet_row['protein'] . "g / " . $latest_diet_row['habit']) 
    : '—';
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard - Burn Club</title>

<script src="https://www.gstatic.com/charts/loader.js"></script>

<style>
body{
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)),
                url('../images/image11.jpg') no-repeat center center fixed;
    background-size: cover;
    color:white;
    font-family: 'Segoe UI', sans-serif;
    margin:0;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    width:230px;
    height:100%;
    background:rgba(0,0,0,0.9);
    backdrop-filter: blur(10px);
    padding:20px;
}
.sidebar h2{
    color:#ffcc00;
    margin-bottom:20px;
}
.sidebar a{
    display:block;
    color:#bbb;
    margin:12px 0;
    text-decoration:none;
    transition:0.3s;
}
.sidebar a:hover{
    color:#ffcc00;
    transform:translateX(5px);
}

/* MAIN */
.main{
    margin-left:250px;
    padding:30px;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;
}

/* PREMIUM CARDS */
.card{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    border-radius:20px;
    padding:25px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    transition:0.3s;
    border:1px solid rgba(255,255,255,0.05);
}

.card:hover{
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0,0,0,0.8);
}

/* STAT NUMBERS */
.card h2{
    font-size:28px;
    background: linear-gradient(45deg,#ffcc00,#ff6600);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* HEADINGS */
h1{
    margin-bottom:25px;
    font-size:28px;
}

h2{
    margin-bottom:12px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

.right{
    display:flex;
    flex-direction:column;
    gap:20px;
}

/* MAP */
iframe{
    width:100%;
    height:250px;
    border:none;
    border-radius:12px;
}

/* MOTIVATION TEXT */
..quote{
    background: rgba(255,255,255,0.06);
    padding:12px 15px;
    border-radius:12px;
    margin-bottom:10px;
    color:#eee;
    font-size:14px;
    transition:0.3s;
    border-left:3px solid #ffcc00;
}

.quote:hover{
    background: rgba(255,255,255,0.1);
    transform:translateX(5px);
}
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

<!-- TOP -->
<div class="topbar">
<h1>Welcome, <?php echo $name; ?></h1>

<div class="quote">
"Discipline is the key to success."
</div>
</div>

<!-- STATS -->
<div class="stats">

<div class="card">
<h2><?php echo $total_workouts; ?></h2>
<p>Workouts</p>
</div>

<div class="card">
<h2><?php echo $total_diets; ?></h2>
<p>Diet Logs</p>
</div>

<div class="card">
<h2><?php echo $latest_workout; ?></h2>
<p>Last Workout</p>
</div>

<div class="card">
<h2><?php echo $latest_diet; ?></h2>
<p>Last Diet</p>
</div>

</div>

<!-- GRID -->
<div class="grid">

<!-- CHART -->
<div class="card">
<h2>Activity Overview</h2>
<div id="chart" style="height:300px;"></div>
</div>

<!-- RIGHT -->
<div>

<div class="card">
<h2>Burn Club Location</h2>

<iframe 
width="100%" 
height="250" 
style="border:0;"
loading="lazy"
src="https://www.google.com/maps?q=burn+club+nairobi&output=embed">
</iframe>

</div>

<div class="card">
<h2>Motivation</h2>

<div class="quote">No excuses. Just results.</div>
<div class="quote">Push beyond limits.</div>
<div class="quote">Stay consistent.</div>

</div>
</div>

</div>

</div>

<!-- CHART -->
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart(){
var data = google.visualization.arrayToDataTable([
['Type','Count'],
['Workouts', <?php echo $total_workouts; ?>],
['Diet', <?php echo $total_diets; ?>]
]);

var options = {
backgroundColor:'transparent',
legend:{textStyle:{color:'white'}},
colors:['#ffcc00','#ff0000']
};

var chart = new google.visualization.PieChart(document.getElementById('chart'));
chart.draw(data, options);
}
</script>

</body>
</html>