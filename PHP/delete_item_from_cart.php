<?php
require "connection.php";
$itemID = $_GET['id'];

$user_name = $_SESSION['user_name'];
$q = "SELECT customer_id FROM consumer WHERE customer_name='$user_name'";
$res = DB()->query($q);
$r = $res->fetch_assoc();
$userID = $r['customer_id'];

$item_price_SQL = "SELECT item_price FROM product WHERE item_id = $itemID";
$result_for_item_price_SQL = DB()->query($item_price_SQL);
$row_for_item_price_SQL = $result_for_item_price_SQL->fetch_assoc();
$itemPrice = $row_for_item_price_SQL['item_price'];

$transactionTotal_SQL = "SELECT transaction_id,transaction_total FROM cart WHERE customer_id='$userID' AND transaction_date = '0000-00-00' ";
$result_for_transactionTotal_SQL = DB()->query($transactionTotal_SQL);
$row_for_transactionTotal_SQL = $result_for_transactionTotal_SQL->fetch_assoc();
$transTotal = $row_for_transactionTotal_SQL['transaction_total'];
$transID = $row_for_transactionTotal_SQL['transaction_id'];

$newTotal = $transTotal - $itemPrice;

$delete_Operation_SQL = "DELETE FROM cart_product WHERE item_id='$itemID'";


$subtract_From_Total_SQL = "UPDATE cart
SET transaction_total = '$newTotal'
WHERE transaction_id = '$transID';";

if (DB()->query("$delete_Operation_SQL") && DB()->query("$subtract_From_Total_SQL")) {

    if($newTotal == 0){
        $delete_transaction_SQL = "DELETE FROM cart WHERE transaction_id = '$transID';";
        DB()->query("$delete_transaction_SQL");
    }

    echo '<script>';
    echo "alert('Item removed from cart successfully')";
    echo '</script>';
    header("refresh:0; url=../cart.php");
} else {
    echo '<script>';
    echo "alert('ERROR , something went wrong')";
    echo '</script>';
    header("refresh:0; url=../cart.php");
}

?>