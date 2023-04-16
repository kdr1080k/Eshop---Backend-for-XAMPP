<?php include('db_connect.php')  ?>

<?php
if (isset($_POST["order_submit"])) {

    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['address'];
    $customer_contact = $_POST['contact'];
    $delivery_date = strtotime($_POST['delivery_date']);
    $formated_delivery_date = date('Y-m-d',$delivery_date);
    $product_id = $_POST['product_id'];
    $order_quantity = $_POST['order_qty'];


    $product_sql = "SELECT `pid`, `p_name`, `p_qty`, `p_price` FROM `product` WHERE `product`.`pid`='$product_id'";

    $result = $conn->query($product_sql);
    $row = $result->fetch_assoc();

    $product_unit_price = $row['p_price'];
    $total_order_price = $product_unit_price * $order_quantity;
    $product_stock = $row['p_qty'];

    if ($order_quantity > $product_stock) {
        $error_message = "Not enough stock";
    }else{

        $remaining_stock = $product_stock - $order_quantity;

        mysqli_autocommit($conn, false);
        $state = true;

        $product_update_sql = "UPDATE `product` SET `p_qty`='$remaining_stock' WHERE `product`.`pid` = '$product_id'";

        $res = mysqli_query($conn, $product_update_sql);

        if (!$res) {
            $state = false;
            $error_message= "Error: " . mysqli_error($conn) . ".";
        }

        $order_generate_sql = "INSERT INTO `customer_order`( `customer_name`, `customer_phone`, `customer_address`, `product_id`, `order_qty`, `total_price`, `delivery_date`) VALUES ('$customer_name','$customer_contact','$customer_address','$product_id','$order_quantity','$total_order_price','$formated_delivery_date')";

        $res = mysqli_query($conn, $order_generate_sql);

        if (!$res) {
            $state = false;
            $error_message= "Error: " . mysqli_error($conn) . ".";
        }
        
        if ($state) {
            mysqli_commit($conn);
            header('Location: ' . '/eshop/admin_product.php');

        } else {
            mysqli_rollback($conn);
            $error_message = "All queries have been canceled";
        }
        mysqli_close($conn); 
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
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <fieldset class="scheduler-border">
                    <legend class="text-center">Customer Place Order</legend>
                    <form method="post" action="place_order.php">
                        <div class="form-group">
                            <label> Customer Name</label>
                            <input type="text" class="form-control"
                                name="customer_name" placeholder="Enter Name" />
                        </div>
                        <div class="form-group">
                            <label> Customer Address</label>
                            <input type="text" class="form-control"
                                name="address" placeholder="Enter Address" />
                        </div>
                        <div class="form-group">
                            <label> Customer Phone</label>
                            <input type="text" class="form-control"
                                name="contact" placeholder="Enter Phone" />
                        </div>
                        <div class="form-group">
                            <label> Delivery Date</label>
                            </br>
                            <input type="text" name="delivery_date"
                                id="datepicker" style="width: 100%;" />
                        </div>

                        <div class="form-group">
                            <label
                                for="exampleFormControlSelect1">Product</label>
                            <select class="form-control" name="product_id">
                                <option>Select Product</option>
                                <?php 
                                    $sql = "SELECT `pid`,`p_name`,`p_qty` FROM product";

                                    $result = $conn->query($sql);
                                        
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                            echo ' <option value="'.$row['pid'].'">'.$row['p_name'] . '( ' . $row['p_qty'] . ' )'.'</option>';
                                        }
                                    }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label> Quantity</label>
                            <input type="number" name="order_qty"
                                class="form-control" min="1" max="50" />
                        </div>

                        </br>
                        <div class="text-center">
                            <button type="submit" name="order_submit"
                                class="btn btn-primary">
                                Confirm Order
                            </button>
                        </div>
                    </form>
                    <?php 

                    if (isset($_POST["order_submit"])) {
                        echo ' <div class="alert alert-danger" role="alert">'.$error_message.'
                        </div>';
                    }
                    ?>

                </fieldset>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


</body>

</html>