    <?php
    require "./PHP/connection.php";
    require "./RS/TopPredictedItemsForUser.php";
    require "./RS/functions.php";



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



        /* loader */

            
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f9fb;
            transition: opacity 0.75s, visibility 0.75s;
            z-index: 9999;
        }

        .loader-hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 15px solid #dddddd;
            border-top-color: #7449f5;
            border-radius: 50%;
            animation: loading 0.75s ease infinite;
        }

        @keyframes loading {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        


        /* loader */
        </style>
    
    </head>

    <body >


    <!-- loader -->

        <div class="loader" ></div>


    <!-- loader -->
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

        <!-- second section -->
        <section id="hero" >
            <!-- Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sint at eveniet veritatis quae reprehenderit id, vel sed sequi mollitia minima, quaerat, culpa adipisci corrupti. Modi nihil quo animi pariatur cumque. -->
            <div class="cont">
                <h4>you can find your options here</h4>
                <h1>Check , make a choice</h1><br>
                <h1>Click , keep your voice</h1>
                <p>Technology is our future</p>
                <button>View shop</button>
            </div>


        </section>
        <section id="product1" class="section-p1" >

        <?php
            
            if(isset($_SESSION['user_name'])){
            echo "<h2 style='color:#1f75b9;'>Recommended Items For You ";
            if(isset($_SESSION['user_name']))
                echo $_SESSION['user_name']; 
            else echo ""; 
            
            echo "</h2>";
            } 
            ?>
            <div class="pro-container pro-container-rec" style=";border:4px solid black; border-radius:30px;">
                                                           
            <?php 
                $id = getIdFromName($_SESSION['user_name']);
                displayTopPredictedItemsForUser($id, 4);
            ?>


        

    <?php


    // $result = DB()->query($item);

    // $number2=0;

    // while ($row = $result->fetch_assoc()) {
    
    //     $Id = $row['item_id'];
    //     $price=$row['item_price'];
    //     $Name = $row['item_name'];
    //     $description = $row['item_description'];
    //     $link="window.location.href='spro.php?id=$Id'"; // id come from here (GET)
    //     $img = $row['item_img'];
    //     $rate = $_SESSION['rateArray'][$Id];

    // if( $number2 < 4 ){
    //     echo "
    //     <div class='pro pro-rec' >
    //     <img src='$img' alt=''onclick=$link>
    //     <div class='des'>
    //         <span>$Name</span>
    //         <h5>$description</h5>
    //         <div class='star'>
    //             "; echo generateStarRating($rate);
    //             echo "
    //         </div>
    //         <h4>$ $price</h4>
    //     </div>
        
    //     <a href='#'> <i class='fal fa-shopping-cart cart'></i>  </a>
    
    //        </div>";

        
    // }
    // $number2++;

    // } 
    ?>



    <!-- // ?> -->
        </div>
        </section>

        <!-- item slid -->
        <div id="demo" class="carousel slide" data-bs-ride="carousel" style="width:25% ; margin:auto">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>

    </div>
    
        <h2 style="color:#1f75b9; text-align:center">Discover</h2>
        <br>
        <br>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner" style="max-width:96 %">
        <div class="carousel-item active">
        <img src="img/item1/item1-1.jpg" width="375" height="290" class="d-block ; " style="width:100%">
        <div class="carousel-caption">
            <a href="http://localhost/e-shop-c/spro.php?id=13" style = "padding:5px 20px;background-color:black;border-radius:20px;">See Now</a>
        </div>
        </div>
        <div class="carousel-item">
        <img src="img/item2/item2-2.jpg" width="375" height="290" class="d-block ; " style="width:100%">
        <div class="carousel-caption">
            <a href="http://localhost/e-shop-c/spro.php?id=14" style = "padding:5px 20px;background-color:black;border-radius:20px;">See Now</a>
        </div> 
        </div>
        <div class="carousel-item">
        <img src="img/item3/item3.jpg" width="375" height="290" class="d-block ; " style="width:100%">
        <div class="carousel-caption">
            <a href="http://localhost/e-shop-c/spro.php?id=15" style = "padding:5px 20px;background-color:black;border-radius:20px;">See Now</a>
        </div>  
        </div>
        <div class="carousel-item">
        <img src="img/item8/item8.jpg" width="2" height="290"  class="d-block ; " style="width:60%;margin: auto">
        <div class="carousel-caption">
            <a href="http://localhost/e-shop-c/spro.php?id=20" style = "padding:5px 20px;background-color:black;border-radius:20px;">See Now</a>
        </div>  
        </div>
    </div>
    
    <!-- Left and right controls/icons -->
    
    <button  class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span style="color:blue;left:20px" class="carousel-control-prev-icon">
    </span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    </div>
        <!-- item slid -->

        <!-- php -->

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


    if( $number < 8 ){
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
        
        <a href='#'> <i class='fal fa-shopping-cart cart'></i>  </a>
    
        </div>";

        $number++;
        
    }


    // $counterr++;

    }




    ?>
                
            </div>
        </section>

        <section id="banner" class="section-m1">
            <div class="banner-cont"> 
                <h4> Want a labtop ? </h4>
                <h2> <span>You have to see this one</span> </h2>
                <a href="http://localhost/e-shop-c/spro.php?id=13" class="normal btn btn-primary" style="text-decoration:none;">Click to Check</a>
            </div>

        </section>

        <!-- add new section  -->
    
        <section id="product1" class="section-p1">
            <h2 style="color:#1f75b9;">featured products</h2>
            <P style="color:#1f75b9;">Winter collection new mordern collection</P>
            <div class="pro-container">
        
        <!-- php -->

        <?php

        

    $item ="SELECT * FROM product";
    $result = DB()->query($item);

    $number2=0;

    while ($row = $result->fetch_assoc()) {
    
        $Id = $row['item_id'];
        $price=$row['item_price'];
        $Name = $row['item_name'];
        $description = $row['item_description'];
        $link="window.location.href='spro.php?id=$Id'"; // id come from here (GET)
        $img = $row['item_img'];
        $rate = $_SESSION['rateArray'][$Id];

    if( $number2 > 7 ){
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
        
        <a href='#'> <i class='fal fa-shopping-cart cart'></i>  </a>
    
        </div>";

        
    }
    $number2++;

    // $counterr++;

    }




    ?>

        



    
                
            </div>
        </section>
        <!-- add new section  -->
    
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
    
        <!--  -->
        <center>
            <h2 style="color:#1f75b9;">Collections</h2>
            <P style="color:#1f75b9;">Find your perfect compo</P>
            </center>


        <section id="sm-banner" class="section-p1">
            <div class="banner-box">
                <h2>check this watch out</h2>
                <a href="http://localhost/e-shop-c/spro.php?id=25" class="white btn btn-primary"> See More</a>
            </div>

            <div class="banner-box banner-box2">
            <h2>check this labtop out</h2>
                <a href="http://localhost/e-shop-c/spro.php?id=64" class="white btn btn-primary"> See More</a>
            </div>

        </section>


        

        <section id="banner3">

            <div class="banner-box">
                <h2 style="color:black;">good device <br> cause good life</h2>
                <h3>and we most of them</h3>
            </div>

            <div class="banner-box banner-box2">
                <h2>seasonal sale</h2>
                <h3>winter collection 59% off</h3>
            </div>

            <div class="banner-box banner-box3">
                <h2 style="color:black;">seasonal sale</h2>
                <h3>summer collection 59% off</h3>
            </div>



        </section>






    

        <?php include('footer.html'); ?>

        <script src="script.js"></script>
        <script src="script/search.js"></script>
        <script src="load.js"></script>

    </body>
    <script src="script/main.js"></script>

    <script src="script/search.js"></script>

    

        <?php scripts() ?>
    </html>