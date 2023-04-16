<?php include('db_connect.php')  ?>
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
            <div class="table-responsive">
                <table class="table caption-top">
                    <caption>
                        List of Orders
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">Order No</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Custmer Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Delivery Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Event</th>
                        </tr>
                    </thead>

                    <?php 
                      $odrer_sql = "SELECT customer_order.o_id, customer_order.order_date, product.p_name, customer_order.order_qty,customer_order.total_price, customer_order.customer_name, customer_order.customer_phone, customer_order.customer_address, customer_order.delivery_date,customer_order.order_status   FROM customer_order INNER JOIN product ON customer_order.product_id = product.pid";


                      $result = $conn->query($odrer_sql);
                          
                    ?>

                    <tbody>
                        <?php 
                      if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                          echo '<tr>
                                <th scope="row">'.$row['o_id'].'</th>
                                <td>'.$row['order_date'].'</td>
                                <td>'.$row['p_name'].'</td>
                                <td>'.$row['order_qty'].'</td>
                                <td>$'.$row['total_price'].'</td>
                                <td>'.$row['customer_name'].'</td>
                                <td>'.$row['customer_phone'].'</td>
                                <td>'.$row['customer_address'].'</td>
                                <td>'.$row['delivery_date'].'</td>
                                <td>'.($row['order_status'] == 0 ? "Pending":"Delivered").'</td>
                                <td>
                                    <button
                                        class="btn btn-success">Delivered</button>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>';


                        }
                      }
                    
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include('boilar_plate/footer.php') ?>

</body>

</html>