<?php
require "SimilarityCode.php"; // Prediction function needs a similarity function (Weighted Sum of Others’ Ratings).

$count = 0;
$ALLcustomerRatePairsArray = array();
$customerIDsArray = array();
$customerRatesArray = array();

function itemPredictionForUser($itemID, $customerID){ // The main function which will return the final predicted value
    $customerRatePairsArray = array(); // This array will contains all rates for chosen item and the customers who gave the rating, it's an objects treated as pairs inside an array, itemID key will contain item ID, and customerID key will contain customer ID
    customersRatedItem($itemID , $customerID, $customerRatePairsArray); // fill the array in line 10
    
    $isItRated = isItAlreadyRated($customerID, $customerRatePairsArray); // check if the item has already been rated by user, thus we don't need to predict it's value

    if($isItRated){
        return "Item Already Rated";
    }

    $Avg_Rate_For_Item = AvgOtherRatedItems($itemID, $customerID); // this function will calculate the average rates for a customer for all items, expect for the rates of the item that we want to predict it's value 

    $predictionValue = $Avg_Rate_For_Item + PredictionFunction($itemID, $customerID,$customerRatePairsArray,$Avg_Rate_For_Item); // Prediction Equation (Weighted Sum of Others’ Ratings)
    
    $predictionValue = max(1, min(5, $predictionValue)); // Cut the value above 5 to 5

    return number_format($predictionValue, 2);
}

function customersRatedItem($itemID ,$customerID , &$customerRatePairsArray){ // fill the array in line 10

    $customersIDsSQL = "SELECT customer_id, item_rate FROM item_rate WHERE item_id = $itemID ORDER BY `item_rate`.`customer_id` ASC"; 

    $result = DB()->query($customersIDsSQL);

    if (!$result) {
        die('Error: ' . DB()->error);
    }

    $customerRatePairsArray = $result->fetch_all(MYSQLI_ASSOC);
}

function isItAlreadyRated($customerID, $customerRatePairsArray){ // check if the item has already been rated by user
    if(binarySearch($customerRatePairsArray, $customerID) !== -1){ //Binary Search to find if customerID has already rated the item
        return true;
    } else {
        return false;
    }
}

function binarySearch($arr, $target) {  // Binary Search Function
    $left = 0;
    $right = count($arr) - 1;

    while ($left <= $right) {
        $mid = floor(($left + $right) / 2);

        if ($arr[$mid]['customer_id'] == $target) {
            return $mid; 
        } elseif ($arr[$mid]['customer_id'] < $target) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }

    return -1; // Not found
}

function AvgOtherRatedItems($itemID, $customerID){ // Return the Average rates of all items that were rated by $customerID expect for $itemID 
    $otherRatedItemsSQL = "SELECT AVG(item_rate) AS average_rate
                           FROM item_rate WHERE item_id <> $itemID AND customer_id = $customerID";
    
    $otherRatedItemsResult = DB()->query($otherRatedItemsSQL);
    
    if($otherRatedItemsResult){
        $row = $otherRatedItemsResult->fetch_assoc();
        $averageRate = $row['average_rate'];

        if($averageRate === NULL)
            return 0;
        else
            return number_format($averageRate, 2);

    } else {
        return 0;
    }
}

function PredictionFunction($itemID, $mainCustomerID, $customerRatePairsArray, $Avg_Rate_For_Item){ 
    global $itemsIDsArray, $customerIDsArray, $customerRatesArray;
    $numerator = 0;
    $denominator = 0;

    foreach ($customerRatePairsArray as $pair) {
        $customerID = $pair['customer_id'];
        $itemRate = $pair['item_rate'];
        $similarity = similarityTwoUsers($customerID, $mainCustomerID);

        $numerator += ($itemRate - AvgOtherRatedItems($itemID, $customerID)) * $similarity;
        $denominator += abs($similarity);
    }
    
    $numerator = number_format($numerator,2);
    $denominator = number_format($denominator,2);
     

     if($denominator == 0){ // if denominator is 0 (which means that the user didn't rate any item at all), return value -1
        return -1;
    }


    return number_format(($numerator/$denominator), 2);
}

?>