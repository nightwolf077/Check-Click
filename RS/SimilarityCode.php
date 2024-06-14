<?php

$user_A_rates = array(); // This Array will contain Rates(1-5) of "Common Rated Items" Between 'User A' and 'User B' ' For User A'.
$user_B_rates = array(); // This Array will contain Rates(1-5) of "Common Rated Items" Between 'User A' and 'User B' ' For User B'.
$similarityCache = array(); //Cache array to store already calculated values

function similarityTwoUsers($userA_id, $userB_id){ // Pearson correlation coefficient function.
    global $similarityCache;
    if (isset($similarityCache[$userA_id][$userB_id])) {
        //echo "ALREADY CACHED VALUE<br>";
        return $similarityCache[$userA_id][$userB_id];
    }
    
    global $user_A_rates, $user_B_rates;
    $user_A_rates = array();
    $user_B_rates = array();

    $commonResult = commonRatedItemsTable($userA_id, $userB_id); // SQL Function to get all "Common Rated Items" Between 'User A' and 'User B'.
    if($commonResult->num_rows == 0){  // If there is no 'Common Rated Items', Similarity is 0.
        return 0;
    }

    fillArraysWithRates($commonResult); // This function fill "Rates Arrays" In line 3 and 4.
    
    $avg_rate_A = itemRateAVG('A'); // This Variable will contain "Average Rate" Of "Common Rated Items" For User A.
    $avg_rate_B = itemRateAVG('B'); // This Variable will contain "Average Rate" Of "Common Rated Items" For User B.
    
    $Similarity = number_format(PearsonFunction($avg_rate_A, $avg_rate_B), 2);
    $similarityCache[$userA_id][$userB_id] = $Similarity; // Store value for future use

    return $Similarity;
}

function commonRatedItemsTable($userA_id, $userB_id){ // SQL Function to get all "Common Rated Items" Between 'User A' and 'User B'.
    $commonSQL = "SELECT DISTINCT r1.item_id, r1.item_rate AS rate1, r2.item_rate AS rate2
        FROM item_rate r1
        JOIN item_rate r2 ON r1.item_id = r2.item_id
        WHERE r1.customer_id = $userA_id AND r2.customer_id = $userB_id";
    
    $commonResult = DB()->query($commonSQL);

    return $commonResult;
}

function fillArraysWithRates($commonResult){ // This function fill "Rates Arrays" In line 3 and 4.
    global $user_A_rates, $user_B_rates;

    while ($row = $commonResult->fetch_assoc()) {
        $user_A_rates[] = $row['rate1'];
        $user_B_rates[] = $row['rate2'];
    }
}

function itemRateAVG($user){ // This function calculates "Average Rate" Of "Common Rated Items"
    global $user_A_rates, $user_B_rates;
    $array;
    if($user == 'A'){
        $array = $user_A_rates;
    } else {
        $array = $user_B_rates;
    }

    $AVG = array_sum($array) / count($array);

    return $AVG;
}

function PearsonFunction($AVG1, $AVG2){ // This Function will calculate the Pearson correlation coefficient function.
    global $user_A_rates, $user_B_rates;

    $numerator = 0;
    $denominator = 0;
    $denmo1 = 0;
    $denmo2 = 0;

    $count = count($user_A_rates);
    for ($i = 0; $i < $count; $i++) {
        $rateA = $user_A_rates[$i];
        $rateB = $user_B_rates[$i];
        
        $numerator += ($rateA - $AVG1) * ($rateB - $AVG2);
        $denmo1 += pow(($rateA - $AVG1), 2);
        $denmo2 += pow(($rateB - $AVG2), 2);
    }

    $numerator = number_format($numerator, 2);
    $denominator = number_format(( sqrt($denmo1) * sqrt($denmo2) ), 2);

    if($denominator == 0){ // this mean that the item is not rated by anyone
        return 0;
    }

    return number_format(($numerator/$denominator), 2);
}
?>