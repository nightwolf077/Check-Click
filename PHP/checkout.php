<?php
require "connection.php";
$userID = $_SESSION['user_id'];
$sql = "UPDATE cart SET transaction_date = NOW() WHERE customer_id = $userID";

if(DB()->query("$sql")){
    echo '<script>';
    echo "alert('Order done, nice doing bussness with you')";
    echo '</script>';
    header("refresh:0; url=../cart.php");
} else {
    echo '<script>';
    echo "alert('Error, please try again later')";
    echo '</script>';
    header("refresh:0; url=../cart.php");
};

?>