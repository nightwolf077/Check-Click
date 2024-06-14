<?php
require "connection.php";
extract($_POST);
$newest_item_id = $_GET['id'];

$adminName = $_SESSION['admin_name'];
$adminSQL = "SELECT administrator_id FROM admin WHERE administrator_name = '$adminName'";
$res = DB()->query("$adminSQL");
$r = $res->fetch_assoc();
$adminID = $r['administrator_id'];

$sql = "UPDATE product SET 
item_name = '$item_name', 
item_price = '$item_price', 
item_description='$item_description',
item_quantity='$item_quantity',
item_category='$item_category' 
WHERE item_id = '$newest_item_id'";

if (DB()->query("$sql")) {
    $operationSQL = "INSERT INTO item_administrator (item_id,administrator_id,operation) 
    VALUES ('$newest_item_id','$adminID','EDIT');";
    DB()->query("$operationSQL");

    echo '<script>';
    echo 'alert("Item edited successfully")';
    echo '</script>';
} else {
    echo '<script>';
    echo 'alert("ERROR, item name already exists")';
    echo '</script>';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if a file was selected
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        // Define the target directory to store the uploaded image
        $targetDir = "photo/";

        // Specify the desired filename
        $filename = $newest_item_id . ".jpg"; // Replace with your desired filename and extension

        // Construct the path where the image will be stored
        $targetPath = $targetDir . $filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {

        } else {

        }
    }
    $sql_image = "UPDATE product SET item_img = '$targetPath' WHERE item_id = '$newest_item_id'";
    DB()->query("$sql_image");
}



header("refresh:0; url=../items_table.php");
exit();
?>