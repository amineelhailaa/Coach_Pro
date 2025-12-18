<?php
require_once "config/db.php";
global $con;
$id = $_SESSION['user_id'];
//$result = $con->query("select u.nom as myname from client c inner join  user u on c.id = u.id where c.id= $id  ");
$result = $con->query("select * from user  where id= $id  ");
$row = $result->fetch_assoc();
if(!$id){
$row['myname']="whocares";

echo 'ddddddddddddd'.$id;
}
