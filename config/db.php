<?php
$host = 'localhost';
$user = 'root';
$pw = '281102';
$db='coach_Pro';

try {
    $con=mysqli_connect($host,$user,$pw,$db);
}
catch (mysqli_sql_exception){
    echo "srry";
}