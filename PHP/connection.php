<?php
session_start();
extract($_POST);
function DB(){
  $servername = "localhost";
  $username = "root";
  $password = "nightwolf";
  $dbname = "ccc";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  
  if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error);
  }
  //return connection
  return $conn;
}
?> 


