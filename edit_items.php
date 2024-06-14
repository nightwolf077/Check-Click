<?php
   require "./PHP/connection.php";
   require "./PHP/headInfo.php";
   $itemID = $_GET['id'];
   $sql = "SELECT item_name,item_price,item_description,item_quantity,item_category FROM product where item_id = '$itemID'";
   $result = DB()->query("$sql");
   $row = mysqli_fetch_assoc($result);
   $item_name = $row['item_name'];
   $item_price = $row['item_price'];
   $item_description = $row['item_description'];
   $item_quantity = $row['item_quantity'];
   $item_category = $row['item_category'];
   $url = "./PHP/edit_itemPHP.php?id=".$itemID;
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="style_nightwolf/add_item.css">
      <style>
         .suggestText {
            font-size: 50px;
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 30px auto;
            font-weight: bolder;
            letter-spacing: 3px;
            
         }
      </style>
   </head>
   <body style="background-color: whitesmoke;">
      <div class="suggestText" style="display:flex; justify-content:center ; font-size:40px; margin-top:30px">
         Edit Item
      </div>
      <div class="context">
         <div class="contextOne" style="margin-top:20px;">
            <!-- <form class="formText" action="" method="post"> -->
            <form class="formMain" action="<?php echo $url ?>" method="POST" enctype="multipart/form-data">
               <label for="item_name">Name Item</label>
               <input type="text" name="item_name" id="item_name" value="<?php echo htmlspecialchars($item_name); ?>" required>
               <label for="item_price">Price Item</label>
               <input type="number" name="item_price" min="0" step="any" id="item_price" value="<?php echo htmlspecialchars($item_price); ?>" required>
               <label for="item_description">Item Description</label>
               <input type="text" name="item_description" id="item_description" value="<?php echo htmlspecialchars(trim($item_description)); ?> " required>
               <label for="item_quantity">Item Quantity</label>
               <input type="number" min="1" step="any" name="item_quantity" id="item_quantity" value="<?php echo htmlspecialchars($item_quantity); ?>" required>
               <label for="item_category">Select Item Category</label>
               <select id="item_category" name="item_category" value="<?php echo htmlspecialchars($item_category); ?>">
                  <option value="Electronic">Electronics</option>
                  <option value="Clothing">Clothing and Apparel</option>
                  <option value="Groceries">Groceries and Food</option>
               </select>
               <input type="submit" value="Edit Item">
               <div class="contextTwo" style="margin-top:50px;">
                  <label for="file-upload" class="file-upload-label">Choose an image:</label>
                  <div class="file-upload-display">
                  <img id="preview-image" src="#" alt="Preview" />
                  </div>
                  <input type="file" id="file-upload" name="image" accept="image/*" onchange="previewImage(event)" required>
                  <br>
                  <label for="file-upload" class="file-upload " style = "color:white;text-align:center;">Browse</label>
               </div>
         </div>
         <!-- form image -->
         </form>
      </div>
      <script>
         function previewImage(event) {
           var reader = new FileReader();
           var image = document.getElementById('preview-image');
           reader.onload = function () {
             if (reader.readyState == 2) {
               image.src = reader.result;
             }
           }
           reader.readAsDataURL(event.target.files[0]);
         }
      </script>
   </body>
</html>