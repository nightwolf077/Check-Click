<?php











function getName($id){ // Get Customer name using it's ID
    $userNameSQL = "SELECT customer_name FROM consumer WHERE customer_id = " . $id;
    $userNameResult = DB()->query($userNameSQL);
    if($userNameResult){
        $userNameRow = $userNameResult->fetch_assoc();
        if(isset($userNameRow['customer_name']))
            return $userNameRow['customer_name'];
    } else {
        return "NAME NOT FOUND";
    }
}

function getIdFromName($name) {
    $userIdSQL = "SELECT customer_id FROM consumer WHERE customer_name = '" . DB()->real_escape_string($name) . "'";
    $userIdResult = DB()->query($userIdSQL);

    if ($userIdResult) {
        $userIdRow = $userIdResult->fetch_assoc();

        return $userIdRow['customer_id'];
    } else {
        return "ID NOT FOUND";
    }
}

function getItemName($id){ // Get Item name using it's ID
    $ItemNameSQL = "SELECT item_name FROM product WHERE item_id = " . $id;
    $ItemNameResult = DB()->query($ItemNameSQL);
    if($ItemNameResult){
        $ItemNameRow = $ItemNameResult->fetch_assoc();

        return $ItemNameRow['item_name'];
    } else {
        return "ITEM NOT FOUND";
    }
}


function getImageByID($id){
    $ItemImgSQL = "SELECT item_img FROM product WHERE item_id = '$id'";
    $ItemImgResult = DB()->query($ItemImgSQL);
    if($ItemImgResult){
        $ItemNameRow = $ItemImgResult->fetch_assoc();

        return $ItemNameRow['item_img'];
    } else {
        return "ITEM NOT FOUND";
    }
}









?>
