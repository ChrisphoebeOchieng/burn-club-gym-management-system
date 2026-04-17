<?php
session_start();
include '../db.php';

/* COUNTS */
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();
$workouts = $conn->query("SELECT COUNT(*) as total FROM workout_logs")->fetch_assoc();
$diet = $conn->query("SELECT COUNT(*) as total FROM diet_logs")->fetch_assoc();

/* RECENT USERS */
$recentUsers = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - Burn Club</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* BACKGROUND */
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

/* TITLE */
h1{
    margin-bottom:25px;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:20px;
}

.card{
    background:rgba(255,255,255,0.05);
    padding:25px;
    border-radius:15px;
    text-align:center;
}

.card h2{
    color:#ffcc00;
    font-size:28px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns: 2fr 1fr;
    gap:20px;
    margin-top:25px;
}

/* BOX */
.box{
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:15px;
}

/* CHART FIX */
.chart-box{
    max-width:400px;
    margin:auto;
}

canvas{
    width:100% !important;
    height:300px !important;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    text-align:left;
}

th{
    color:#ffcc00;
    border-bottom:2px solid #444;
}

td{
    border-bottom:1px solid #333;
}

tr:hover{
    background:rgba(255,255,255,0.05);
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Admin Panel</h2>
<a href="dashboard.php">Dashboard</a>
<a href="users.php">Users</a>
<a href="add_member.php">Add Member</a>
<a href="reports.php">Reports</a>
<a href="../user/logout.php">Logout</a>
</div>

<div class="main">

<h1>Admin Dashboard</h1>

<!-- CARDS -->
<div class="cards">

<div class="card">
<h2><?php echo $users['total']; ?></h2>
<p>Total Users</p>
</div>

<div class="card">
<h2><?php echo $workouts['total']; ?></h2>
<p>Workout Logs</p>
</div>

<div class="card">
<h2><?php echo $diet['total']; ?></h2>
<p>Diet Logs</p>
</div>

</div>

<!-- GRID -->
<div class="grid">

<!-- CHART -->
<div class="box">
<h3>System Activity</h3>

<div class="chart-box">
<canvas id="myChart"></canvas>
</div>

</div>

<!-- RECENT USERS -->
<div class="box">
<h3>Recent Users</h3>

<table>
<tr>
<th>Name</th>
<th>Email</th>
</tr>

<?php while($row = $recentUsers->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
</tr>
<?php } ?>

</table>

</div>

</div>

</div>

<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Users', 'Workouts', 'Diet'],
        datasets: [{
            data: [
                <?php echo $users['total']; ?>,
                <?php echo $workouts['total']; ?>,
                <?php echo $diet['total']; ?>
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

</body>
</html>