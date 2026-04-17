<?php
session_start();
include '../db.php';

/* DELETE USER */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: users.php");
    exit();
}

/* SEARCH */
$search = $_GET['search'] ?? '';

if($search){
    $result = $conn->query("
        SELECT * FROM users 
        WHERE id LIKE '%$search%' 
        OR name LIKE '%$search%' 
        OR email LIKE '%$search%' 
        ORDER BY id DESC
    ");
} else {
    $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Members - Burn Club</title>

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

/* SEARCH */
.search-box{
    margin-bottom:20px;
}

.search-box input{
    width:300px;
    padding:12px;
    border:none;
    border-radius:10px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:15px;
}

/* TABLE FIX */
table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

th{
    color:#ffcc00;
    border-bottom:2px solid #444;
    padding:15px;
    text-align:left;
}

td{
    padding:15px;
    border-bottom:1px solid #333;
    word-wrap:break-word;
}

/* COLUMN ALIGNMENT */
th:nth-child(1), td:nth-child(1){ width:8%; text-align:center; }
th:nth-child(2), td:nth-child(2){ width:22%; }
th:nth-child(3), td:nth-child(3){ width:30%; }
th:nth-child(4), td:nth-child(4){ width:15%; text-align:center; }
th:nth-child(5), td:nth-child(5){ width:15%; text-align:center; }

/* ROW HOVER */
tr:hover{
    background:rgba(255,255,255,0.05);
}

/* ROLE BADGE */
.role{
    background:#ffcc00;
    color:black;
    padding:5px 10px;
    border-radius:10px;
    font-size:12px;
}

/* DELETE BUTTON */
.delete-btn{
    background:#ff4d4d;
    color:white;
    padding:6px 12px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.delete-btn:hover{
    background:#ff0000;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Admin Panel</h2>
<a href="dashboard.php">Dashboard</a>
<a href="users.php">Members</a>
<a href="add_member.php">Add Member</a>
<a href="reports.php">Reports</a>
<a href="../user/logout.php">Logout</a>
</div>

<div class="main">

<h1>Members</h1>

<!-- SEARCH -->
<div class="search-box">
<form method="GET">
<input type="text" name="search" placeholder="Search by ID, name or email..." value="<?php echo $search; ?>">
</form>
</div>

<div class="card">

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><span class="role"><?php echo $row['role']; ?></span></td>
<td>
<a href="users.php?delete=<?php echo $row['id']; ?>" 
   onclick="return confirm('Delete this user?')">
   <button class="delete-btn">Delete</button>
</a>
</td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>