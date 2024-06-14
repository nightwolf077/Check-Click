<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $products = array();
    $searchTerm = $_POST["search"];

    $sql = "SELECT item_id,item_name, item_img, item_price FROM product WHERE item_name LIKE '%$searchTerm%'";

    $result = mysqli_query(DB(), $sql);

    if (!$result) {
        http_response_code(500);
        echo json_encode(array('error' => 'Database error'));
        exit;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = array(
            'name' => $row['item_name'],
            'image' => $row['item_img'],
            'id' => $row['item_id'],
        );
    }
// the max limit of search items product
    $limitedProducts = array_slice($products, 0, 5);


    header('Content-Type: application/json');

    echo json_encode($limitedProducts);
}
?>
