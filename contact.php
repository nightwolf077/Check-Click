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
            <li id="about"><a href="about.php">About</a></li>
            <li id="contact"><a class="active" href="contact.php">Contact</a></li>

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
    <section id="page-header" class="about-contact">

        <h2>#let's_talk </h2>

        <p> leave a message we love to hear from you </p>


    </section>

    <section id="contact-details" class="section-p1" >
        <div class="details">
            <span> get in touch</span>
            <h2>Visit one of our agency locations or contact us today</h2>
            <h3>Head office</h3>

            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p > Hashemite unversity </p>
                </li>
                <!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere architecto dolores maiores neque veritatis ipsum similique, deserunt odit doloremque soluta ea consectetur eius ipsa cupiditate vero, qui id eum voluptas! -->
                <li>
                    <i class="far fa-envelope"></i>
                    <p> checlick@yahoo.com</p>
                </li>

                <li>
                    <i class="fal fa-phone-alt"></i>
                    <p> 077-270-8006</p>
                </li>
                <li>
                    <i class="fal fa-clock"></i>
                    <p> 24/7</p>
                </li>
            </div>

        </div>

        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3379.7558714057313!2d36.178546574688276!3d32.10288307395265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151b73d1eb51be21%3A0xc4daca834a1e6988!2sThe%20Hashemite%20University!5e0!3m2!1sen!2sjo!4v1702489236364!5m2!1sen!2sjo"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <form action="">
            <span>leave a message </span>
            <h2>we love to hear from you</h2>
            <input type="text" placeholder="your name">
            <input type="email" placeholder="E-mail">
            <input type="text" placeholder="subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="your nessage"></textarea>
            <button class="normal">submit</button>
        </form>
        <div class="people">
            <div>
                <img src="img/people/mohmmad.jpg" alt="">
                <p><span>Mohammad Alayaseh</span>Full-stack developer <br>
                    phone: + 962 7826 960 80 <br> email:Mohmmademad@gmail.com </p>
            </div>
            <div>
                <img src="img/people/baker.jpg" alt="">
                <p><span>Baker Aljbour</span>Back-developer <br>
                    phone: + 962 7 7248 2269 <br> email:Bakeraljbour@gmail.com </p>
            </div>
            <div>
                <img src="img/people/amjadfinal.jpg" alt="">
                <p><span>Amjad Aldgoor</span>Web Developer<br>
                    phone: + 962 7727 080 06 <br> <a href="mailto:amjadman21@yahoo.com">Amjadaldgoor@gmail.com</a> </p>
            </div>

        </div>

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

    <?php include('footer.html'); ?>

   
    <script src="script.js"></script>
    <script src="script/search.js"></script>
</body>

</html>