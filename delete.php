<?php

require_once('db_connect.php');

$product_id = $_GET['pid'];


if ($product_id != "") {

    // sql to delete a record
    $sql = "DELETE FROM product WHERE pid= $product_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: ' . '/eshop/admin_product.php');
    }
    else {
        header('Location: ' . '/eshop/admin_product.php');
    }
}



?>