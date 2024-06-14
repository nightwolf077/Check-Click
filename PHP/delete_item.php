<?php
require "connection.php";
$itemID = $_GET['id'];
$sql = "DELETE FROM product WHERE item_id = $itemID";

$fileToDelete = "../DBImages/$itemID.jpg";
if (file_exists($fileToDelete)) {
    unlink($fileToDelete);
} else {
    echo "File does not exist.";
}
$deleteOperationSQL = "DELETE FROM item_administrator WHERE item_id='$itemID'";


$sqlITEMS = "SELECT * from product WHERE item_id=$itemID";
$result = DB()->query("$sqlITEMS");
$row = $result->fetch_assoc();
$item_id = $row['item_id'];
$item_name = $row['item_name'];
$item_price = $row['item_price'];
$item_description = $row['item_description'];
$item_category = $row['item_category'];
$item_quantity = $row['item_quantity'];

$SAVEdeleteOperationSQL = "INSERT INTO deleted_product (item_id, item_name, item_price, item_description, item_quantity, item_category)
VALUES ('$item_id','$item_name', '$item_price', '$item_description','$item_quantity', '$item_category')";

if (DB()->query("$SAVEdeleteOperationSQL") && DB()->query("$deleteOperationSQL") && DB()->query("$sql")) {
    echo '<script>';
    echo "alert('Item deleted successfully')";
    echo '</script>';
    header("refresh:0; url=../items_table.php");
} else {
    echo '<script>';
    // echo "alert('ERROR , something went wrong')";
    echo '</script>';
    header("refresh:0; url=../items_table.php");
}

if ( DB()->query("$sql")) {
    echo '<script>';
    echo "alert('Item deleted successfully')";
    echo '</script>';
    header("refresh:0; url=../items_table.php");
} else {
    echo '<script>';
    echo "alert('ERROR , something went wrong')";
    echo '</script>';
    header("refresh:0; url=../items_table.php"); 
}

?>



