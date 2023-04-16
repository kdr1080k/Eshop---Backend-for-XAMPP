<?php

include('db_connect.php');



if ($_GET['pid'] != "") {
    $get_product_id = $_GET['pid'];
    
     $sql = "SELECT * FROM `product` WHERE `pid` = '$get_product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $get_product_name = $row['p_name'];
        $get_product_description= $row['p_des'];
        $get_product_price = $row['p_price'];
        $get_product_qty = $row['p_qty'];
        $get_product_image = $row['p_image'];
    }
}

if (isset($_POST["submit"])) {

        if($_FILES["fileToUpload"]['name'] != ""){
            $target_dir = "prod_image/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            // Check if image file is a actual image or fake image
        
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            }
            else {
                $error_msg = "File is not an image.";
                $uploadOk = 0;
            }
           
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $error_msg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
        
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" &&       $imageFileType != "jpeg" && $imageFileType != "gif") {
                $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed..";
                // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

                // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            
                $error_msg2 = "Sorry, your file was not uploaded.";
                header('Location: ' . '/eshop/edit_product.php?pid='.$product_id);
            // if everything is ok, try to upload file
            }else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                {
                    // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                    
                    $product_id = trim($_POST['p_id']);
                    $product_name = trim($_POST['product_name']);
                    $product_description = trim($_POST['product_des']);
                    $product_quantity = trim($_POST['product_qty']);
                    $product_price = trim($_POST['product_unit_price']);
                    $product_image = $_FILES["fileToUpload"]["name"];
            
                    $sql = "UPDATE `product` SET `p_name`='$product_name',`p_des`='$product_description',`p_qty`='$product_quantity',`p_price`='$product_price',`p_image`='$product_image' WHERE `product`.`pid` = '$product_id';";

                    if (mysqli_query($conn, $sql)) {
                        header('Location: ' . '/eshop/admin_product.php');
                    }
                    else {
                       
                        $error_msg2 = "Product update is unsuccessful";
                    }
                }
            }
            
        }else{
            $product_id = trim($_POST['p_id']);
            $product_name = trim($_POST['product_name']);
            $product_description = trim($_POST['product_des']);
            $product_quantity = trim($_POST['product_qty']);
            $product_price = trim($_POST['product_unit_price']);
    
            $sql = "UPDATE `product` SET `p_name`='$product_name',`p_des`='$product_description',`p_qty`='$product_quantity',`p_price`='$product_price' WHERE `product`.`pid` = '$product_id';";
        
    
            if (mysqli_query($conn, $sql)) {
                header('Location: ' . '/eshop/admin_product.php');
            }
            else {
                $error_msg2 = "Product update is unsuccessful";
            }
        }
   
}


?>



<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>
    <?php include('boilar_plate/custom_import.php') ?>
</head>

<body>
    <?php include('boilar_plate/header.php') ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <fieldset>
                    <legend>Edit Product</legend>

                    <form method="post" action="edit_product.php"
                        enctype="multipart/form-data">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input name='product_name' type="text"
                                class="form-control"
                                value="<?php echo $get_product_name;?>" />
                            <label class="form-label">Product Name </label>
                        </div>
                        <div><input type="hidden" name="p_id"
                                value="<?php echo $get_product_id  ?>"></div>
                        <div class="form-outline mb-4">
                            <textarea name='product_des' type="text"
                                class="form-control"><?php echo $get_product_description;?></textarea>
                            <label class="form-label">Product Description
                            </label>
                        </div>
                        <div class="form-outline mb-4">
                            <input name='product_qty' type="text"
                                class="form-control"
                                value="<?php echo $get_product_qty;?>" />
                            <label class="form-label">Product Quantity </label>
                        </div>
                        <div class="form-outline mb-4">
                            <input name='product_unit_price' type="text"
                                class="form-control"
                                value="<?php echo $get_product_price;?>" />
                            <label class="form-label">Product Unit Price
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="formFileMultiple"
                                class="form-label">Product Image Upload</label>
                            <input class="form-control" type="file"
                                id="formFileMultiple" name="fileToUpload"
                                multiple>
                            <div class="alert alert-light" role="alert">
                                Uploaded Image :
                                <?php echo $get_product_image ?>
                            </div>
                        </div>

                        <button type="submit" name="submit"
                            class="btn btn-primary btn-block mb-4">
                            Update
                        </button>
                    </form>
                    <div>
                        <?php
                    if(isset($_POST["update"])){
                        echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';} ?>

                    </div>
                </fieldset>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <?php include('boilar_plate/footer.php') ?>
</body>

</html>