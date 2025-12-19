<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "../config/db.php";

$id = $_GET['id'];
$statement = $con->prepare("select * from coach left join user on coach.coachID = user.id where coachID= ? ");
$statement->bind_param("i",$id);
$statement->execute();


$result = $statement->get_result();
$statement = $con->query("select * from disponible where id_coach =  $id ");

$dispo=[];
while($d = $statement->fetch_assoc()){
    $dispo[] = $d;
}





$row = $result->fetch_assoc();
unset($row['password']);
$row['sports'] = ['Football', 'Tennis'];
$row['certifications'] = ['Football', 'Tennis'];
$row['rating'] = 4.5;
$row['disponibilite']= $dispo;

echo json_encode($row);
exit();