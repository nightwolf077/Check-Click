<?php 
require "PredictionCode.php";

function isNew(){
    $userID = $_SESSION['user_id'];
    $userIdSQL = "SELECT customer_id FROM item_rate WHERE customer_id='$userID' ";
    $userIdResult = DB()->query($userIdSQL);

    if ($userIdResult->num_rows == 0) {
        $userIdRow = $userIdResult->fetch_assoc();

        return true;
    } else {

        return false;
    }
}

function displayTopPredictedItemsForUser($customerID, $n) {
    function predictTopItemsForUser($customerID, $n) {
        $topItems = array();
        $allItemsSQL = "SELECT DISTINCT item_id FROM item_rate";
        $allItemsResult = DB()->query($allItemsSQL);

        if (!$allItemsResult) {
            die('Error: ' . DB()->error);
        }

        while ($row = $allItemsResult->fetch_assoc()) {
            $itemID = $row['item_id'];
            $prediction = itemPredictionForUser($itemID, $customerID);

            if($prediction != 'Item Already Rated')
                $topItems[$itemID] = $prediction;

        }

        arsort($topItems);
        
        $topNItems = array_slice($topItems, 0, $n, true);
       // echo count($topNItems);
        return $topNItems;
    }
    
    $_SESSION['predictedItems'] = predictTopItemsForUser($customerID, $n);

    
    $query = "SELECT * FROM product WHERE item_id IN (" . implode(',', array_keys($_SESSION['predictedItems'])) . ") ORDER BY FIELD(item_id, " . implode(',', array_keys($_SESSION['predictedItems'])) . ")";
    $result = DB()->query($query);
    if ($result && $result->num_rows > 0) {


    $number2=0;

    while ($row = $result->fetch_assoc()) {
        
        $Id = $row['item_id'];
        $price=$row['item_price'];
        $Name = $row['item_name'];
        $description = $row['item_description'];
        $link="window.location.href='spro.php?id=$Id'"; // id come from here (GET)
        $img = $row['item_img'];
        $rate = $_SESSION['rateArray'][$Id];

    if( $number2 < $n ){
        echo "
        <div class='pro pro-rec' >
        <img src='$img' alt=''onclick=$link>
        <div class='des'>
            <span>$Name</span>
            <h5>$description</h5>
            <div class='star'>
                "; echo generateStarRating($rate);
                echo "
            </div>
            <h4>$ $price</h4>
        </div>
        
        <a href='#'> <i class='fal fa-shopping-cart cart'></i>  </a>
    
        </div>";   
    }
    $number2++;

    } 


        // echo "<div class='row ms-2 me-2 d-flex justify-content-center'>";

        // while ($row = $result->fetch_assoc()) {
        //     $randomImage = $row['item_img'];
        //     $randomName = $row['item_name'];
        //     $randomPrice = $row['item_price'];
        //     $randomId = $row['item_id'];
        //     $phpFileUrl = "item_view.php?id=$randomId";
        //     $predictedRating = $_SESSION['predictedItems'][$randomId];

        //     echo "
        //         <div class='col-lg-2 col-md-4 col-sm-6 d-flex'>
        //             <div class='card w-100 my-2 shadow-2-strong'>
        //                 <img src='$randomImage' class='card-img-top' style='aspect-ratio: 1 / 1'/>
        //                 <div class='card-body d-flex flex-column'>
        //                     <h5 class='card-title' style='min-height: 6rem;'>$randomName</h5>
        //                     <p class='card-text d-flex justify-content-center' style='min-height: 40px;'>$$randomPrice</p>
        //                     <div class='card-footer d-flex justify-content-center pt-3 px-0 pb-0 mt-auto'>
        //                         <a href='$phpFileUrl' class='button shadow-0 me-1'>View Item</a>
        //                     </div>
        //                 </div>
        //             </div>
        //         </div>
        //     ";
        // }

        // echo "</div>";
    }
}
?>