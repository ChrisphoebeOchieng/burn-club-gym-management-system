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
$message = "";

/* HANDLE PAYMENT */
if(isset($_POST['pay'])){

    $plan   = $_POST['plan'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $method = $_POST['method'] ?? '';
    $phone  = $_POST['phone'] ?? '';

    if($plan && $amount > 0 && $method){

        $sql = "INSERT INTO payments (email, plan, amount, method, phone)
                VALUES ('$email','$plan','$amount','$method','$phone')";

        if(!$conn->query($sql)){
            die("DB ERROR: " . $conn->error);
        }

        $message = "processing";

    } else {
        $message = "Please fill all fields correctly";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payments - Burn Club</title>

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
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:520px;
    background:rgba(255,255,255,0.06);
    backdrop-filter:blur(15px);
    padding:35px;
    border-radius:20px;
}

h1{
    text-align:center;
    margin-bottom:20px;
}

/* FORM GROUP */
.group{
    margin-bottom:15px;
}

/* INPUT */
input, select{
    width:100%;
    height:50px;
    padding:14px;
    border:none;
    border-radius:12px;
    font-size:14px;
    margin-bottom:15px;
    box-sizing:border-box;
}

/* BUTTON */
.btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:linear-gradient(45deg,#ff0000,#ffcc00);
    color:white;
    font-size:16px;
    cursor:pointer;
}

/* ALERT */
.alert{
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    text-align:center;
}

.success{ background:#1b5e20; }
.error{ background:#7f0000; }

</style>

<script>

/* AUTO AMOUNT */
function setPlan(){
    let plan = document.getElementById("plan").value;
    let amount = document.getElementById("amount");

    if(plan === "Monthly") amount.value = 3000;
    else if(plan === "Weekly") amount.value = 1000;
    else if(plan === "Daily") amount.value = 300;
    else amount.value = "";
}

/* SHOW MPESA */
function toggleFields(){
    let method = document.getElementById("method").value;
    document.getElementById("mpesa").style.display =
        (method === "Mpesa") ? "block" : "none";
}

/* VALIDATION */
function validateForm(){

    let phone = document.getElementById("phone").value;
    let amount = document.getElementById("amount").value;
    let method = document.getElementById("method").value;

    if(amount <= 0){
        alert("Invalid amount");
        return false;
    }

    if(method === "Mpesa"){
        if(!/^07\d{8}$/.test(phone)){
            alert("Enter valid phone number (07XXXXXXXX)");
            return false;
        }
    }

    return true;
}

</script>

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

<div class="card">

<h1>Membership Payment</h1>

<div id="alertBox">
<?php if($message == "processing"){ ?>
<div class="alert">Prompt sent to your phone... Waiting for confirmation</div>

<script>
setTimeout(() => {
    document.getElementById("alertBox").innerHTML =
    "<div class='alert success'>Payment successful</div>";
}, 3000);
</script>

<?php } ?>
</div>

<form method="POST" onsubmit="return validateForm()">

<div class="group">
<select name="plan" id="plan" onchange="setPlan()" required>
<option value="">Select Plan</option>
<option value="Monthly">Monthly - Ksh 3,000</option>
<option value="Weekly">Weekly - Ksh 1,000</option>
<option value="Daily">Daily - Ksh 300</option>
</select>
</div>

<div class="group">
<select name="method" id="method" onchange="toggleFields()" required>
<option value="">Select Method</option>
<option value="Mpesa">Mpesa</option>
</select>
</div>

<div class="group" id="mpesa" style="display:none;">
<input type="text" name="phone" id="phone" placeholder="07XXXXXXXX">
</div>

<div class="group">
<input type="number" name="amount" id="amount" readonly required>
</div>

<button name="pay" class="btn">Pay Now</button>

</form>

</div>
</div>

</body>
</html>