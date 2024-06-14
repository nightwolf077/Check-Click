<section id="header">
    <a href="index.php"> <img src="img/logo-main-word.png" alt="" class="logo" width="200px"> </a>

        <div>
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
        </div>

    <div id="mobile">
        <a href=""><i class="far fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
</section>

