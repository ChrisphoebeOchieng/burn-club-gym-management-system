<?php
session_start();
include '../db.php';

/* FETCH PAYMENTS */
$result = $conn->query("SELECT * FROM payments ORDER BY id DESC");

/* TOTAL REVENUE */
$total = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports - Burn Club</title>

<style>
body{
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)),
                url('../images/image11.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family:'Segoe UI', sans-serif;
    color:white;
    margin:0;
}

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

.main{
    margin-left:250px;
    padding:30px;
}

h1{
    margin-bottom:20px;
}

/* DOWNLOAD BUTTON */
.download-btn{
    padding:10px 15px;
    border:none;
    border-radius:8px;
    background:#ffcc00;
    cursor:pointer;
    margin-bottom:20px;
}

/* STATS */
.stats{
    display:flex;
    gap:20px;
    margin-bottom:25px;
}

.stat-box{
    flex:1;
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:15px;
    text-align:center;
}

.stat-box h2{
    color:#ffcc00;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:15px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

th, td{
    padding:15px;
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

<div class="sidebar">
<h2>Admin Panel</h2>
<a href="dashboard.php">Dashboard</a>
<a href="users.php">Users</a>
<a href="add_member.php">Add Member</a>
<a href="reports.php">Reports</a>
<a href="../user/logout.php">Logout</a>
</div>

<div class="main">

<h1>Payment Reports</h1>

<!-- DOWNLOAD FULL REPORT -->
<a href="download_report.php">
<button class="download-btn">Download Full Report</button>
</a>

<div class="stats">
    <div class="stat-box">
        <h2>Ksh <?php echo $total['total'] ?? 0; ?></h2>
        <p>Total Revenue</p>
    </div>
</div>

<div class="card">

<table>
<tr>
<th>User</th>
<th>Plan</th>
<th>Amount</th>
<th>Method</th>
<th>Phone</th>
<th>Date</th>
<th>Statement</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['plan']; ?></td>
<td>Ksh <?php echo $row['amount']; ?></td>
<td><?php echo $row['method']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['created_at']; ?></td>

<td>
<a href="download_report.php?id=<?php echo $row['id']; ?>">
<button style="
padding:6px 10px;
border:none;
border-radius:6px;
background:#ffcc00;
cursor:pointer;
">
Download
</button>
</a>
</td>

</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>