<?php
   require "./PHP/connection.php";
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="style/style.css" />
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
      <div class="suggestText">Users Table</div>

      <table>
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Email</th> 
               <th></th>
            </tr>
         </thead>
         <tbody>
            <?php
               $query = "SELECT customer_id,customer_name,customer_email FROM consumer";
               $result = DB()->query($query);
               
               foreach ($result as $row) {
                   $customerID = $row['customer_id'];
                   $sql = "SELECT * FROM consumer_admin where customer_id = $customerID";
                   $res = DB()->query($sql);
                   $message = "";
                   if(mysqli_num_rows($res) > 0){
                       $message = "UnBan";
                   }
                   else{
                       $message = "Ban";
                   }
               
                   $banURL = "./PHP/ban_user.php?id=" . urlencode($customerID);
                   $UnBanURL = "./PHP/Unban_user.php?id=" . urlencode($customerID);
                   echo "<tr>";
                   echo "<td>" . $row['customer_id'] . "</td>";
                   echo "<td>" . $row['customer_name'] . "</td>";
                   echo "<td>" . $row['customer_email'] . "</td>";
                   echo "<td><a href='$banURL' class='ban' >$message</a></td>";;
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