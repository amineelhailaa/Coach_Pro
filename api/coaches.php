<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../config/db.php";
global $con;
$result = $con->query("select * from coach c inner join user u on c.coachID = u.id ");
$rows=[];
if (!$result) {
    die("Query failed: " . $con->error);
}
while ($row = $result->fetch_assoc()){
    unset($row['password']);
    $row['sports'] = ['Football', 'Tennis'];
    $row['rating'] = 4.5;
    $rows[] = $row;
}

echo  json_encode($rows);
exit();