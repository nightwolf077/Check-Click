<?php 
   require "./PHP/connection.php";
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="style_nightwolf/item_table.css" />
      <!--link below is for the stars-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="./style/search.css">
    <link rel="stylesheet" href="style.css">
    
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
      <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
      <title>Online Shopping</title>
   </head>
   <body style="background-color: whitesmoke;">
   <section id="header">
    <a href="index.php"> <img src="img/logo-main-word.png" alt="" class="logo" width="200px"> </a>
    <ul id="navbar">
    <li id="contact"><a href="register.php">Log out </a></li>
</ul>
</section>
   

      <div class="suggestText">Items Table</div>
      <table>
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Image</th>
               <th></th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            <?php
               $query = "SELECT item_id,item_name,item_img FROM product";
               $result = DB()->query($query);
               foreach($result as $row)
               {
                 $edit_url = "edit_items.php?id=" . urlencode($row['item_id']);
                 $delete_url = "./PHP/delete_item.php?id=" . urlencode($row['item_id']);
                 echo "<tr>";
                 echo "<td>".$row['item_id']."</td>";
                 echo "<td>".$row['item_name']."</td>";
                 echo "<td><img width='100px' height='100px' alt='image not found' src='" .$row['item_img'] . "'</td>";
                 echo "<td><a href='$edit_url' class='edt'>Edit</a></td>";
                 echo "<td><a href='$delete_url ' class='del'>Remove</a></td>";
               }
               ?>
         </tbody>
      </table>
      <div class="table_buttons">
         <button class="table_button" onclick="window.location.href='admin.php'">Back</button>
         <button class="table_button" onclick="window.location.href='register.php'">back to register</button>
         <br><br>
      </div>
      <script src="script/main.js"></script>
   </body>
</html>