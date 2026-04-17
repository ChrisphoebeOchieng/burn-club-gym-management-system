<?php
session_start();
include '../db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

/* DATA */
$workouts = $conn->query("SELECT COUNT(*) as t FROM activity_bookings WHERE user_email='$email'")->fetch_assoc()['t'] ?? 0;
$diets    = $conn->query("SELECT COUNT(*) as t FROM diet_logs WHERE user_email='$email'")->fetch_assoc()['t'] ?? 0;

/* GOALS */
$goal = 20;
$diet_goal = 10;

$workout_percent = ($goal > 0) ? ($workouts / $goal) * 100 : 0;
$diet_percent    = ($diet_goal > 0) ? ($diets / $diet_goal) * 100 : 0;

/* HISTORY */
$result = $conn->query("SELECT * FROM activity_bookings WHERE user_email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Progress - Burn Club</title>

<script src="https://www.gstatic.com/charts/loader.js"></script>

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

/* TITLE */
h1{margin-bottom:20px;}

/* GRID */
.grid{
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
}

/* PROGRESS BAR */
.bar{
    width:100%;
    height:10px;
    background:#333;
    border-radius:10px;
    margin-top:10px;
    overflow:hidden;
}

.fill{
    height:100%;
    background:linear-gradient(45deg,#ff0000,#ffcc00);
}

/* CHART */
#chart{
    height:300px;
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

<h1>Your Progress </h1>

<!-- STATS -->
<div class="grid">

<div class="card">
<h2><?php echo $workouts; ?> Workouts</h2>
<div class="bar">
<div class="fill" style="width:<?php echo $workout_percent; ?>%"></div>
</div>
</div>

<div class="card">
<h2><?php echo $diets; ?> Diet Logs</h2>
<div class="bar">
<div class="fill" style="width:<?php echo $diet_percent; ?>%"></div>
</div>
</div>

</div>

<!-- CHART -->
<div class="card">
<h2>Progress Overview</h2>
<div id="chart"></div>
</div>

<!-- HISTORY -->
<div class="card">
<h2>Workout History</h2>

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
<td><?php echo $row['created_at'] ?? ''; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

<!-- CHART -->
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart(){
var data = google.visualization.arrayToDataTable([
['Type','Count'],
['Workouts', <?php echo $workouts; ?>],
['Diet', <?php echo $diets; ?>]
]);

var options = {
backgroundColor:'transparent',
legend:{textStyle:{color:'white'}},
colors:['#ff0000','#ffcc00']
};

var chart = new google.visualization.PieChart(document.getElementById('chart'));
chart.draw(data, options);
}
</script>

</body>
</html>