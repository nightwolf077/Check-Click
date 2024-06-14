<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_nightwolf/add_item.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="./style/search.css">
    <link rel="stylesheet" href="style.css">
    <title>Online Shopping</title>

</head>


<body style="background-color: whitesmoke;">

<section id="header">
    <a href="index.php"> <img src="img/logo-main-word.png" alt="" class="logo" width="200px"> </a>
    <ul id="navbar">
    <li id="contact"><a href="register.php">Log out </a></li>
</ul>
</section>


    <div class="suggestText">

    </div>
    <div class="context">
        <div class="contextOne">
            <!-- <form class="formText" action="" method="post"> -->
            <form class="formMain" action="PHP/add_new_item.php" method="POST" enctype="multipart/form-data">
                <label for="item_name"> Item Name </label>
                <input type="text" name="item_name" id="item_name" required>
                <label for="item_price">Item Price</label>
                <input type="number" name="item_price" min="0" step="any" id="item_price" required>
                <label for="item_description">Item Description</label>
                <input type="text" name="item_description" id="item_description" required>
                <label for="item_quantity">Item Quantity</label>
                <input type="number" min="1" step="any" name="item_quantity" id="item_quantity" required>


                </select>
                <input type="submit" value="Add item">

                <div class="contextTwo" style="margin-top: 50px;">
                    <label for="file-upload" class="file-upload-label">Choose an image:</label>
                    <div class="file-upload-display">
                        <img id="preview-image" src="#" alt="Preview" />
                    </div>
                    <input type="file" id="file-upload" name="image" accept="image/*" onchange="previewImage(event)"
                        required>
                    <br>
                    <label for="file-upload" class="file-upload"
                        style="color:white ; text-align: center;">Browse</label>
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