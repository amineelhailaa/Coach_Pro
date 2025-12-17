<?php
$host = 'localhost';
$user = 'root';
$pw = '281102';
$db='coach_Pro';


$con= new mysqli($host,$user,$pw,$db);

if ($con->connect_error){
    die("cant connect".$con->connect_error);
}