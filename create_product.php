<?php
include('db_connect.php');

if (isset($_POST["submit"])) {
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
    // Check if file already exists
    if (file_exists($target_file)) {
        $error_msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error_msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed..";
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error_msg2 = "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    }else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    
            $product_name = trim($_POST['product_name']);
            $product_description = trim($_POST['product_des']);
            $product_quantity = trim($_POST['product_qty']);
            $product_price = trim($_POST['product_unit_price']);
            $product_image = $_FILES["fileToUpload"]["name"];
    
            $sql = "INSERT INTO `product` (`pid`, `p_name`, `p_des`, `p_qty`, `p_price`, `p_image`, `create_date`) VALUES (NULL, '$product_name', '$product_description', '$product_quantity', '$product_price', '$product_image', current_timestamp());";
    
            if (mysqli_query($conn, $sql)) {
                header('Location: ' . '/eshop/admin_product.php');
            }
            else {
                $error_msg2 = "Product create is unsuccessful";
            }
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
                    <legend>Create Product</legend>

                    <form method="post" action="create_product.php"
                        enctype="multipart/form-data">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input name='product_name' type="text"
                                class="form-control" />
                            <label class="form-label">Product Name </label>
                        </div>
                        <div class="form-outline mb-4">
                            <textarea name='product_des' type="text"
                                class="form-control" /></textarea>
                            <label class="form-label">Product Description
                            </label>
                        </div>
                        <div class="form-outline mb-4">
                            <input name='product_qty' type="number"
                                class="form-control" />
                            <label class="form-label">Product Quantity </label>
                        </div>
                        <div class="form-outline mb-4">
                            <input name='product_unit_price' type="number"
                                step="0.01" class="form-control" />
                            <label class="form-label">Product Unit Price
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="formFileMultiple"
                                class="form-label">Product Image Upload</label>
                            <input class="form-control" type="file"
                                id="formFileMultiple" name="fileToUpload"
                                multiple>
                        </div>
                        <button type="submit" name="submit"
                            class="btn btn-primary btn-block mb-4"
                            style="width: 100%">
                            Create
                        </button>

                    </form>
                    <a href="admin_product.php">
                        <button class="btn btn-danger" style="width:100%">
                            Cancel
                        </button>
                    </a>
                    <div>
                        <?php
                    if(isset($_POST["submit"])){
                        echo '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';} 
                    ?>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <?php include('boilar_plate/footer.php') ?>
</body>

</html>