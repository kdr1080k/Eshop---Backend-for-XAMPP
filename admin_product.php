<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>
    <?php include('boilar_plate/custom_import.php') ?>
</head>

<body>
    <?php include('boilar_plate/header.php') ?>
    <?php include('db_connect.php')  ?>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h3>Product Details Page Admin</h3>
            </div>
            <div class="col-md-3">
                <a href="create_product.php"><button type="button"
                        class="btn btn-success">
                        Create Product
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <?php
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">
      <div class="card product-card" style="width: 100%">';
      echo '<img src="prod_image/'.$row['p_image'].'" class="card-img-top" alt="'.$row['p_name'].'" />
          <div class="card-body">';
           echo '<h5 class="card-title">'.$row['p_name']. '</h5>';
            echo ' <p class="card-text">' . 
              $row['p_des'].
            '</p>
          </div>
          <ul class="list-group list-group-flush">';
            echo '<li class="list-group-item"> In Stock</li>';
    echo '<li class="list-group-item"> Available Product Qty: ' . $row['p_qty'] . '</li>'.
    '<li class="list-group-item"> Product Unit Price: ' . $row['p_price'] . '</li>
          </ul>
          <div class="card-body">
              <a href="/eshop/edit_product.php?pid='.$row['pid'].'" class="card-link"
                ><button type="button" class="btn btn-primary">Edit</button></a
              >
              <a href="/eshop/delete.php?pid='.$row['pid'].'" class="card-link"
                ><button type="button" class="btn btn-danger">Delete</button></a
              >
            </div>
        </div>
      </div>';
      }
  
    } else {
      echo "No Product Found";
    }?>

        </div>
    </div>

    <?php include('boilar_plate/footer.php') ?>

</body>

</html>