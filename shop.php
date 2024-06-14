<?php
 require "./PHP/connection.php";



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
    <!-- firat section navbar  -->
    <section id="header">
    <a href="index.php"> <img src="img/logo-main-word.png" alt="" class="logo" width="200px"> </a>

    <div>
    <form id="logoutForm" method="post" action="logout.php">    
        <ul id="navbar">
            <li id="home"><a  href="index.php">Home</a></li>
            <li id="shop"><a class="active" href="shop.php">Shop</a></li>
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


    <!-- firat section navbar  -->
    
    

    <!-- second section -->
    <section id="page-header-shop">

        <div class="page-header-shop-cont">
            <h2>#stayHome we will get you</h2>
            <p>save more with coupons & up to 79% off! </p>
        </div>

    </section>


    <section id="product1" class="section-p1">
    <h2 style="color:#1f75b9;">new arrival</h2>
        <P style="color:#1f75b9;">Summer collection new mordern desgin</P>
        <div class="pro-container">
     
        <?php

      

$item ="SELECT * FROM product";
$result = DB()->query($item);

// $counterr=0;
$number=0;

while ($row = $result->fetch_assoc()  ) {

$Id = $row['item_id'];
$price=$row['item_price'];
$Name = $row['item_name'];
$description = $row['item_description'];
$link="window.location.href='spro.php?id=$Id'"; // id come from here (GET)
$img = $row['item_img'];
$rate = $_SESSION['rateArray'][$Id];



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
    
    <a href='#'> <i class='fal fa-shopping-cart cart'></i> </a>
       </div>";

       $number++;
    
}


// $counterr++;





?>



            
        </div>
    </section>


    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"> <i class="fal fa-long-arrow-alt-right"></i> </a>
    </section>



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

<!-- footer -->
<?php include('footer.html'); ?>

   
    <script src="script.js"></script>
    <script src="script/search.js"></script>
    
</body>

</html>