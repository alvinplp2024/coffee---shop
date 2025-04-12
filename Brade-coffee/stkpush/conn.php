<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "brade_coffee";
$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
// or die("connection of db failed".mysqli_error());
if(!$con)
  {
    die("failed to connect!");
  } 
  //else{echo "connect!"; }
	//$mysqli -> select_db("dekut") or die("failed to connect to database!".mysqli_error());
   //mysqli_select_db($con,"bookshop");
   //echo "connect to db!";
?>