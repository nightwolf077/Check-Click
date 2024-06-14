<?php

require "connection.php";
$sql = "SELECT * FROM admin WHERE administrator_name='$name' AND administrator_password='$password'";
$result = DB()->query($sql);
$row = $result->fetch_all(MYSQLI_BOTH);

if (!empty($row)) {
    $_SESSION['admin_name'] = $name;
    echo '<script>alert("Welcome Admin ' . $name . '!");</script>';
    header("refresh:0; url=../admin.php");
    exit();
}

$sql = "SELECT customer_id FROM consumer WHERE customer_name='$name' AND customer_password='$password'";
$result = DB()->query($sql);
$row = $result->fetch_assoc();

if ($row) {
    $userID = $row['customer_id'];
    $banSQL = "SELECT * FROM consumer_admin WHERE customer_id='$userID'";
    $res = DB()->query($banSQL);

    if (mysqli_num_rows($res) > 0) {
        echo '<script>alert("Account with name ' . $name . ' is Banned!");</script>';
        header("refresh:0; url=../register.php");
        exit();
    }

    $_SESSION['user_name'] = $name;
    $_SESSION['user_id'] = $userID;
    header("refresh:0; url=../index.php");
    exit();
} else {
    echo '<script>alert("Username or password incorrect");</script>';
    header("refresh:0; url=../register.php");
    exit();
}
?>
