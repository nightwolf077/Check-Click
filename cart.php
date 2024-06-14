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

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check and click</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="./style/search.css">
    <!-- slide -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- slide -->
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
   
    <style>
        .carousel-control-prev-icon {
        
            background-color: black; /* Change the arrow color */
            margin-left:-100px;
        }
        .carousel-control-next-icon {
        
        background-color: black; /* Change the arrow color */
        margin-right:-100px;
    }




    </style>
  
</head>

<body >
    <!--  -->
    <!-- firat section navbar  -->
    <section id="header">
    <a href="index.php"> <img src="img/logo-main-word.png" alt="" class="logo" width="200px"> </a>

    <div>
    <form id="logoutForm" method="post" action="logout.php">    
        <ul id="navbar">
            <li id="home"><a class="active" href="index.php">Home</a></li>
            <li id="shop"><a href="shop.php">Shop</a></li>
            <li id="blog"><a href="blog.php">Blog</a></li>
            <li id="about"><a href="about.php">About</a></li>
            <li id="contact"><a href="contact.php">Contact</a></li>

            <select id="userDropdown" class="dropdown drop" onchange="handleDropdownChange()">
                <option value="default" selected>
                    <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; ?>
                </option>
                <?php if (isset($_SESSION['user_name'])) : ?>
                    <option value="logout">Log Out</option>
                <?php else : ?>
                    <option value="login">Log In</option>
                <?php endif; ?>
            </select>
            <div class="">
                <div class="">
                    <div class="dropdown">
                        <input style=" height:27px;" " id="search" type="text" class="form-control" placeholder="Search" oninput="handleSearchChange()" onblur="handleBlur()" onfocus="handleFocus()" autocomplete="off" >
                        <div class="dropdown-content" id="dropdownResults"></div>
                    </div>
                </div>
            </div>

            
            <li id="lg-bag"><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
            <a href="#" id="close"> <i class="far fa-times"></i></a>
        </ul>
                </form>
    </div>
    
    <div id="mobile">
        <a href=""><i class="far fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
    
</section>





<!--  -->
    <!-- second section -->
    <section id="page-header" class="cart-header">
        <div class="blog-header-cont">
            <h2>#Easy Choice, Easy Shopping</h2>
            <p>We wish that you have found your choices</p>
        </div>

    </section>

    

    <!-- some shity m e  -->
    
    
    


   
     
 
            
      

    
   
    <!--  -->

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>remove</td>
                    <td>image</td>
                    <td>product</td>
                    <td>price</td>
                </tr>
            </thead>

           
            <?php

      

$customerID_AND_transactionTotal_SQL = "SELECT transaction_id,customer_id,transaction_total FROM cart WHERE customer_id='$userID' AND transaction_date = '0000-00-00' ";
    $result_for_customerID_AND_transactionTotal_SQL = DB()->query($customerID_AND_transactionTotal_SQL);
                  
    if ($result_for_customerID_AND_transactionTotal_SQL->num_rows > 0) {
        echo 'HIIII'; //test
                      
     $row_for_customerID_AND_transactionTotal_SQL = $result_for_customerID_AND_transactionTotal_SQL->fetch_assoc();
    $transactionID = $row_for_customerID_AND_transactionTotal_SQL['transaction_id'];
    
    $customer_cart_SQL = "SELECT item_id FROM cart_product WHERE transaction_id = '$transactionID' ";
    $result_for_customer_cart_SQL = DB()->query($customer_cart_SQL);
    
    // for getting number of items in the cart vvv
    $ItemsNumber_SQL = "SELECT COUNT(*) as NUM FROM cart_product WHERE transaction_id = '$transactionID' ";
    $result_for_ItemsNumber_SQL = DB()->query($ItemsNumber_SQL);
    $ItemsNumber = $NumRow['NUM'];
    $NumRow = $result_for_ItemsNumber_SQL->fetch_assoc();
    


    
    }

    foreach ($result_for_customer_cart_SQL as $row) {
        $itemID = $row['item_id'];
        $transTotal = $row_for_customerID_AND_transactionTotal_SQL['transaction_total'];
        $delete_url = "PHP/delete_item_from_cart.php?id=$itemID";
        // search for urlencode

        $itemName_AND_itemPrice_SQL = "SELECT item_name,item_price FROM product WHERE item_id='$itemID'";
        $result_for_itemName_AND_itemPrice_SQL = DB()->query($itemName_AND_itemPrice_SQL);
        $row_for_itemName_AND_itemPrice_SQL = $result_for_itemName_AND_itemPrice_SQL->fetch_assoc();
        $itemName = $row_for_itemName_AND_itemPrice_SQL['item_name'];
        $itemPrice = $row_for_itemName_AND_itemPrice_SQL['item_price'];
        $img = getImageByID($itemID);
        echo" 
            <tbody>
                <tr>
                    <td><a href='$delete_url'> <i class='far fa-times-circle'></i></a></td>
                    <td> <img src='$img' alt='img'> </td>
                    <td> $itemName </td>
                    <td> $itemPrice </td>
                </tr>

              
            </tbody>

            ";
    }
?>
      




           
            
            


           

        </table>
    </section>


    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Applay coupon</h3>
            <div>
                <input type="text" placeholder="enter your cpupon">
                <button class="normal">Applay</button>
            </div>
        </div>

        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>cart subtotal</td>
                    <td>$<?php if(isset($transTotal)) echo $transTotal; else echo '0';  ?></td>
                </tr>
                <tr>
                    <td>shipping</td>
                    <td>free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>$<?php if(isset($transTotal)) echo $transTotal; else echo '0';  ?></strong></td>
                </tr>
            </table>
          <button class="normal">  <a href='./PHP/checkout.php' class="normal" id="paginationn">Proceed to check out</a> </button>
        </div>
    </section>

    <?php include('footer.html'); ?>


    <script src="script.js"></script>
    <script src="script/search.js"></script>
</body>

</html>