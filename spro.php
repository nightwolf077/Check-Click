<?php
 require "./PHP/connection.php";
 require "./PHP/functions.php";
 $ID = $_GET['id']; // Here GET the ITEM ID
 $userID = getIdFromName($_SESSION['user_name']);


 function generateStarRating($rating) {
    $wholeStars = floor($rating);
    $starsHtml = str_repeat("<span class='fa fa-star checked' '></span>", $wholeStars);

    $decimalPart = $rating - $wholeStars;

    if ($decimalPart >= 0.5) {
        $starsHtml .= "<span class='fa fa-star-half-alt checked'></span>";
    } elseif ($decimalPart > 0) {
        $starsHtml .= "<span class='fa fa-star' style='color: grey;'></span>";
    }

    $emptyStars = 5 - ceil($rating);
    $starsHtml .= str_repeat("<span class='fa fa-star' style='color: grey;'></span>", $emptyStars);

    return $starsHtml;
}

function calculateAverageRatings() {
    $averageRatings = array();

    $query = "SELECT item_id, AVG(item_rate) as AVG FROM item_rate GROUP BY item_id";
    $result = DB()->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $itemId = $row['item_id'];
            $averageRating = $row['AVG'];

            $averageRatings[$itemId] = number_format($averageRating, 1);
        }
    }
    arsort($averageRatings);

    

    return $averageRatings;
}

$_SESSION['rateArray'] = calculateAverageRatings();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check and click</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- firat section navbar  -->
    <?php include('nav.php'); ?>


    <section id="prodetails" class="section-p1">
        
        <?php
            $item_query = "SELECT * FROM product where item_id='$ID'";
            $item_result = DB()->query($item_query);
            if ($item_result && $item_result->num_rows > 0) {
                
                $row = $item_result->fetch_assoc();
                $Image=$row['item_img'];
                $Name=$row['item_name'];
                $Price=$row['item_price'];
                $Description=$row['item_description'];
                $Quantity = $row['item_quantity'];
                $Category = $row['item_category'];
            } else {
                echo "No Information";
            }
            
            echo 
            "
            <div class='single-pro-image'>
                <img src='$Image' width='100%' id='MainImg' alt='$Name'>
            </div>
            <div class='single-pro-details'>
                <h6 style='color: black;'>$Category</h6>
                <h4 style='color: black;'>$Name</h4> 
                <h2 style='color: black;'>$Price</h2> 
    
                <select>
                    <option>Select Color</option>
                    <option>Purpule</option>
                    <option>Dark Blue</option>
                    <option>Pink</option>
                    <option>White</option>
                    <option>Black</option>
                </select>
                <div class='stars' id='rating'>
                   <div class='stars' id='rating'>
                      <label>Rate:</label>
                      <a style='color:black' onmouseover='highlightStars(1)' onmouseout='resetStars()' href='PHP/item_rate.php?customer_id=$userID&item_id=$ID&rate=1 '><span id='star1' class='fa fa-star '></span></a>
                      <a style='color:black' onmouseover='highlightStars(2)' onmouseout='resetStars()' href='PHP/item_rate.php?customer_id=$userID&item_id=$ID&rate=2 '><span id='star2' class='fa fa-star '></span></a>
                      <a style='color:black' onmouseover='highlightStars(3)' onmouseout='resetStars()' href='PHP/item_rate.php?customer_id=$userID&item_id=$ID&rate=3 '><span id='star3' class='fa fa-star '></span></a>
                      <a style='color:black' onmouseover='highlightStars(4)' onmouseout='resetStars()' href='PHP/item_rate.php?customer_id=$userID&item_id=$ID&rate=4 '><span id='star4' class='fa fa-star '></span></a>
                      <a style='color:black' onmouseover='highlightStars(5)' onmouseout='resetStars()' href='PHP/item_rate.php?customer_id=$userID&item_id=$ID&rate=5 '><span id='star5' class='fa fa-star '></span></a>
                   </div>
                </div>

                <input type='number' value='1'>
                    <button class='normal' > <a style='padding  ' id='paginationn' href='./PHP/add_to_cart.php?customer_id=$userID&item_id=$ID'class='normal'>Add To Chart</a>  </button>
                <h4 style='color: black;'>Product details</h4>
                <span>$Description</span>
            </div>
            ";

        ?>
    </section>
<!-- the buttton is here  -->
        <!-- items go here -->
        <section id="product1" class="section-p1">
        <h2 style="color:black;" >featured products</h2>
        <P style="color:black;">Winter collection new mordern collection</P>
        <div class="pro-container">
     

        
        <?php
//  <a href='./PHP/add_to_cart.php?customer_id=$userID&item_id=$ID'class='normal'>Add To Chart</a> 
      

$item ="SELECT * FROM product";
$result = DB()->query($item);

// $counterr=0;
$number=0;

while ($row = $result->fetch_assoc()  ) {

$Id = $row['ite_id'];
$price=$row['item_price'];
$Name = $row['item_name'];
$description = $row['item_description'];
$link="window.location.href='spro.php?id=$Id'"; // id come from here (GET)
$img = $row['item_img'];
$rate = $_SESSION['rateArray'][$Id];


if( $number < 4 ){
    echo "
    <div class='pro' >
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
    
    <a href='./PHP/add_to_cart.php?customer_id=$userID&item_id=$ID'class='normal'><i class='fal fa-shopping-cart cart'></i></a> 
   
       </div>";

       $number++;
    
}


// $counterr++;

}




?>




?>
            
        </div>
    </section>
        <!-- items go here -->


    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>sign up for newsletters</h4>
            <p>get email upsarws out shio and pla plaplapla <span>speacal offers</span></p>
        </div>

        <div class="form">
            <input type="text" placeholder="your email address">
            <button class="normal">sign up</button>
        </div>

    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" alt="">
            <h4>contact</h4>
            <p><strong>address:</strong> 562 wekkubgr riad,street 32 , san francisco </p>
            <p><strong>phone:</strong> +962 78 2 9553</p>
            <p><strong>hourse:</strong> 10 - 18, mon , sat</p>
            <div class="follow">
                <h4>follow us </h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>about</h4>
            <a href="#">about us</a>
            <a href="#">delivery information</a>
            <a href="#">privacy olicy</a>
            <a href="#">terms & conditions</a>
            <a href="#">contact us</a>
        </div>

        <div class="col">
            <h4>my acconut</h4>
            <a href="#">sign in </a>
            <a href="#">view cart</a>
            <a href="#">my wishlist</a>
            <a href="#">track my order</a>
            <a href="#">HElP</a>

        </div>

        <div class="col install">
            <h4>install app</h4>
            <p>from app store or goo gel play</p>
            <div class="row">
                <img src="img/pay/app.jpg" alt="">
                <img src="img/pay/play.jpg" alt="">
            </div>
            <p>secerd payment gateways</p>
            <img src="img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p> copy right shit stuffsfdkljfsd sdkfjlsdl </p> <!-- keep it long enough other wise u will suffer-->
        </div>
    </footer>

    <script>
        var MainImg = document.getElementById("MainImg");
        var smallimg = document.getElementsByClassName("small-img");

        smallimg[0].onclick = function () {
            MainImg.src = smallimg[0].src;
        }
        smallimg[1].onclick = function () {
            MainImg.src = smallimg[1].src;
        }
        smallimg[2].onclick = function () {
            MainImg.src = smallimg[2].src;
        }
        smallimg[3].onclick = function () {
            MainImg.src = smallimg[3].src;
        }
    </script>


    <script src="script.js"></script>
    <script src="./script/rate.js"></script>
</body>

</html>