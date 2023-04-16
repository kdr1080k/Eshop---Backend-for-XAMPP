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
            <div class="col-md-12">
                <form method="post" action="product.php">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <select class="form-select" name="filter"
                                    aria-label="Default select example">
                                    <option selected>Select Filter</option>
                                    <option value="1">Price Ascending</option>
                                    <option value="2">Price Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text"
                                placeholder="Search Keywords"
                                name="search_string">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="submit"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="row">

            <?php
if (isset($_POST["submit"])) {

  $filter = $_POST['filter'];
  $search_string = $_POST['search_string'];

  if ($search_string !="" && $filter !=null) {
    $sql = "SELECT * FROM `product` WHERE `p_name` LIKE '%$search_string%'";
  }elseif ($filter == 1) {
    $sql = "SELECT * FROM `product` ORDER BY `product`.`p_price` ASC";
  }elseif($filter == 2){
    $sql = "SELECT * FROM `product` ORDER BY `product`.`p_price` DESC";
  }else{
    $sql = "SELECT * FROM product";
  }

}else{
    $sql = "SELECT * FROM product";
}

$result = $conn->query($sql);
    
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<div class="col-md-4">
  <div class="card product-card" style="width: 100%">';
  echo '<img src="prod_image/'.$row['p_image'].'" class="card-img-top" alt="..." />
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
    </div>
  </div>';
  }

} else {
  echo "No Product Found";
}
    ?>




        </div>
    </div>
    <?php include('boilar_plate/footer.php') ?>
</body>

</html>