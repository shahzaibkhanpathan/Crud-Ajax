<?php

$host = "localhost";
$root = "root";
$pass="";
$db = "crud_oop";

$conn = mysqli_connect($host,$root ,$pass,$db);

if($conn)
{
    // echo "connect";
}
else{
    echo "error";
}



?>

