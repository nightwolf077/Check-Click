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
            <li id="blog"><a class="active" href="blog.php">Blog</a></li>
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
    <section id="page-header" class="blog-header">
        <div class="blog-header-cont">
            <h2>#read more </h2>
            <p>read about different technologies for best knowledge</p>
        </div>

    </section>


    <section id="blog">
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/pictuers/HealthTech.png" alt="">
            </div>

            <div class="blog-details">

                <h4>Could these microbots change the future of HealthTech ?</h4>
                <p>Imagine a microscopic robot that could spiral through the human body’s vascular system, guided by
                    sound, and deliver life-saving medicine as it goes.

                    Along with his colleagues at the Swiss Federal Institute of Technology, Daniel Ahmed (Professor of
                    Acoustic Robotics for Life Sciences and Healthcare) is working on a new technology that could – at
                    some point in the future – do exactly that.

                    A recent report in the New Scientist outlined Ahmed’s work.
                </p>
                <a
                    href="https://www.insights.onegiantleap.com/blogs/could-these-microbots-change-the-future-of-healthtech/">contunie
                    reading</a>
            </div>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/pictuers/ChatGPT-vs-Bard.png" alt="">
            </div>
            <div class="blog-details">
                <h4> ChatGPT Vs Bard: Which is better for coding ?</h4>
                <p>
                    For programmers, Generative AI offers tangible benefits. It helps with writing and debugging code,
                    making our busy lives a bit easier as a result. But there are now competing tools like ChatGPT and
                    Bard, which begs the question: which one is best for me to use?
                    We compare these tools against each other in the ultimate battle to see which is the most
                    feature-rich tool right now for programming purposes.
                </p>
                <a href="https://www.pluralsight.com/blog/software-development/chatgpt-vs-bard-coding">contunie reading</a>
            </div>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="img/blogMiddle.jpg" alt="">
            </div>
            <div class="blog-details">
                <h4> New Samsung Galaxy Foldables Drive More Sustainable Future While Providing the Most Versatile
                    Mobile Experience</h4>
                <p>Samsung Electronics announces today that it has made progress towards achieving the 2025
                    sustainability goals for the MX(Mobile eXperience) Business. Key initiatives include developing and
                    incorporating recycled materials into products, designing more eco-conscious packaging and giving
                    new life to older Samsung Galaxy devices to reduce e-waste.
                </p>
                <a href="https://news.samsung.com/global/new-samsung-galaxy-foldables-drive-more-sustainable-future-while-providing-the-most-versatile-mobile-experience">contunie reading</a>
            </div>
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

    <!-- footer -->
    <?php include('footer.html'); ?>

    <script src="script.js"></script>
    <script src="script/search.js"></script>
    
</body>

</html>