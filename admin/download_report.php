<?php
include '../db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="payment_statement.csv"');

$output = fopen("php://output", "w");

fputcsv($output, ['Name','Email','Phone','Plan','Amount','Method','Date']);

$result = $conn->query("SELECT * FROM payments");

while($row = $result->fetch_assoc()){
    fputcsv($output, [
        $row['name'],
        $row['email'],
        $row['phone'],
        $row['plan'],
        $row['amount'],
        $row['method'],
        $row['created_at']
    ]);
}

fclose($output);