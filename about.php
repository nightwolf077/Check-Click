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
            <li id="shop"><a href="shop.php">Shop</a></li>
            <li id="blog"><a href="blog.php">Blog</a></li>
            <li id="about"><a class="active" href="about.php">About</a></li>
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

    <!-- second section -->
    <section id="page-header" class="about-header ">

        <div class="about-header-cont">
            <h2>#know us </h2>
            <p> we have cases we care about and all of them are about <span>Gaza</span> </p>
        </div>


    </section>
    <p class="gaza-header" style="color: black; text-align: center; font-weight: bolder; font-size: 30px;">#SaveGaza</p>
    <marquee bgcolor="#000" loop="-1" scrollamount="5" width="100%"
        style="color: white; font-weight: bold; height: 50px; display: flex; justify-content: center; align-items: center;">
        You can visit our website about gaza to know the truth , just click on the link below.
    </marquee>
    <div class="intro">
        <div class="intro-cont">
            <p>You can find the truth here</p>
            <h1>GAZA UNDER ATTACK</h1>
            <a href="gaza/index.html">LEARN MORE</a>
        </div>

    </div>


    <section id="about-app" class="section-p1">
        <h1> download out <a href="#">App</a></h1>
        <div class="video">
            <video autoplay muted loop src="img/about/1.mp4"></video>
        </div>

    </section>
    <!--
    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/featuers/f1.png" alt="">
            <h6>Free Shiping</h6>
        </div>

        <div class="fe-box">
            <img src="img/featuers/f2.png" alt="">
            <h6>online order</h6>
        </div>

        <div class="fe-box">
            <img src="img/featuers/f3.png" alt="">
            <h6>sace money</h6>
        </div>

        <div class="fe-box">
            <img src="img/featuers/f4.png" alt="">
            <h6>promtions</h6>
        </div>

        <div class="fe-box">
            <img src="img/featuers/f5.png" alt="">
            <h6>happpy sell</h6>
        </div>

        <div class="fe-box">
            <img src="img/featuers/f6.png" alt="">
            <h6>f24/7 support</h6>
        </div>

    </section>
 -->
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

    <?php include('footer.html'); ?>

    <script src="script.js"></script>
    <script src="script/search.js"></script>
</body>

</html>