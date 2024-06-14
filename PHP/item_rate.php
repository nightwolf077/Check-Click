<?php
require "connection.php";
$currentID = $_GET['customer_id'];
$itemID = $_GET['item_id'];
$itemRate = $_GET['rate'];

$rateSQL = "SELECT item_id FROM item_rate WHERE item_id='$itemID' AND customer_id='$currentID'";
$rateResult = DB()->query($rateSQL);
if ($rateResult->num_rows > 0){
    $addRateSQL = 
    "UPDATE item_rate
    SET item_rate = '$itemRate'
    WHERE item_id='$itemID' AND customer_id='$currentID'";
    if (DB()->query("$addRateSQL") === true) {
        echo '<script>';
        echo "alert('Item rate edited successfully')";
        echo '</script>';
    } 
    
} else {
    $addRateSQL = "INSERT INTO `item_rate`(`item_id`, `customer_id`, `item_rate`) VALUES ('$itemID','$currentID','$itemRate')";
    if (DB()->query("$addRateSQL") === true) {
        echo '<script>';
        echo "alert('Item rated successfully')";
        echo '</script>';
    } 
}

header("refresh: 0 url=" . $_SERVER['HTTP_REFERER']);
exit();

?>