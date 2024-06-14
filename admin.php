
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Online Shopping</title>
    
    
  
   
    
    <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" /> -->
    <!-- <link rel="stylesheet" href="./style/search.css"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_nightwolf/adminStyle.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
   
 



  </head>

  <body>
   <!-- 0 -->
   <section  id="header">
    <a href="index.php"> <img src="img/logo-main-word.png" alt="" class="logo" width="200px"> </a>
    <ul id="navbar">
    <li id="contact"><a href="register.php">Log out </a></li>
</ul>
</section>
   <!-- 0 -->

  <div class="button-grid">
    <div class="cont">
        <img src="style_nightwolf/images/plus.png" alt="" height="200" width="200">
        <button id="add-item" onclick="window.location.href='add_items.php'">
          Add new item
        </button>
    </div>

    <div class="cont">
      <img src="style_nightwolf/images/edit_delete_2.png" alt="" height="200" width="200">
      <button
        id="edit-remove-item"
        onclick="window.location.href='items_table.php'"
      >
        Edit / Remove item
      </button>
    </div>

    <div class="cont">
      <img src="style_nightwolf/images/user_2.png" alt="" height="200" width="200">

      <button id="show-users" onclick="window.location.href='users_table.php'">
        Show users
      </button>
    </div>

    <div class="cont">
      <img src="style_nightwolf/images/dashboard.png" alt="" height="200" width="200">

      <img src="" alt="">
      <button>Dashboard</button>
    </div>
  </div>
    
 </body>
</html>
