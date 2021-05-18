<?php

session_start();
require_once '../require/database.php';

$con = $db->connection;

$page_no = $_POST['page_no'];
$limit = 12;
$total_records_per_page = $limit;

$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM product WHERE is_active=1");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = $total_records;
// $total_no_of_pages = ceil($total_records / $total_records_per_page);
// $second_last = ceil($total_no_of_pages / $limit) - 1; // total pages minus 1

$q = "SELECT *,product.category_id AS 'c_id' FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.quantity > product.low_inventory  AND product.is_active=1 ORDER BY product.product_id DESC 
				LIMIT $offset, $total_records_per_page";
$db->_result($q);
$res2 = $db->result;

// 
$db->_result("SELECT COUNT('product_id') AS 'records' FROM product WHERE is_active=1");
if ($db->result->num_rows) {
  $rows = mysqli_fetch_assoc($db->result);
}


?>

<style type="text/css">
  .rate {
    float: left;
    height: 46px;
    padding: 0 10px;
  }

  .rate:not(:checked)>input {
    position: absolute;
    top: -9999px;
  }

  .rate:not(:checked)>label {
    float: right;
    width: 1em;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    font-size: 30px;
    color: #ccc;
  }

  .rate:not(:checked)>label:before {
    content: '★ ';
  }

  .rate>input:checked~label {
    color: #ffc700;
  }

  .rate:not(:checked)>label:hover,
  .rate:not(:checked)>label:hover~label {
    color: #deb217;
  }

  .rate>input:checked+label:hover,
  .rate>input:checked+label:hover~label,
  .rate>input:checked~label:hover,
  .rate>input:checked~label:hover~label,
  .rate>label:hover~input:checked~label {
    color: #c59b08;
  }
</style>

<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">


      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Farmers Online Store</h1>
            </div>

          </div>

        </div><!-- /.container-fluid -->
      </section>
      <div class="row">
        <div class="col-12">
          <div class="w3-bar w3-card w3-padding">
            <p>Categories</p>
            <?php
            $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='E-Commerce' AND parent_category IS NULL");
            if ($db->result->num_rows) {
              while ($c = mysqli_fetch_assoc($db->result)) {
            ?>
                <a href="#" class="w3-bar-item w3-button" onclick="category_product(<?php echo $c['category_id']; ?>)"><?php echo $c['category']; ?></a>
            <?php
              }
            }
            ?>
          </div>

        </div>

      </div>
      <div class="row" style="float: right;">
        <div class="col-sm-12">
          <div class="mt-4">
            <a href="pages/cart.php" class="btn btn-primary btn-lg btn-flat">
              <i class="fas fa-cart-plus fa-lg mr-2"></i>
              Show Cart
            </a>
          </div>
        </div>
      </div>
      <?php
      if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other') {
      ?>
        <div class="row">
          <div class="col-12" id="product_form">
            <button onclick="add_product_form()" class="w3-btn w3-green">Add product</button>
          </div>
        </div>
      <?php } ?>
    </div><!-- /.container-fluid -->
  </section>
  <div class="container">



    <h2 align="center">Featured Products</h2>
    <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">


        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/carousel/">
        <!-- Bootstrap core CSS -->
        <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
          }

          @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
          }
        </style>
        <!-- Custom styles for this template -->
        <link href="carousel.css" rel="stylesheet">



        <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">

          <div class="carousel-inner">

            <?php
            $db->_result("SELECT * FROM product,product_image WHERE product.product_id=product_image.product_id AND product.is_featured=1 AND product_image.is_main=1 AND product.is_active=1");
            if ($db->result->num_rows) {
              $a = 1;
              while ($product = mysqli_fetch_assoc($db->result)) {

                if ($a == 1) {
            ?>
                  <div class="carousel-item active" data-bs-interval="3000" onclick="product_details(<?php echo $product['product_id']; ?>)">
                    <img style="width: 400px;height:250px;" src="<?php echo $product['image_path']; ?>" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5><?php echo $product['product_title']; ?></h5>
                      <p><?php echo $product['product_description']; ?></p>
                    </div>
                  </div>

                <?php
                } else {
                ?>
                  <div class="carousel-item" data-bs-interval="3000" onclick="product_details(<?php echo $product['product_id']; ?>)">
                    <img style="width: 400px;height:250px;" src="<?php echo $product['image_path']; ?>" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5><?php echo $product['product_title']; ?></h5>
                      <p><?php echo $product['product_description']; ?></p>
                    </div>
                  </div>
              <?php
                }
                $a++;
              }
            } else {
              ?>
              <div class="carousel-item active" data-bs-interval="3000">
                <img style="width: 400px;height:250px;" src="https://images.pexels.com/photos/1563356/pexels-photo-1563356.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>No Featured Products Available</h5>
                  <p></p>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>

    <br>

    <div class="row" id="filter">
      <?php
      while ($product = mysqli_fetch_assoc($res2)) {
        $db->_result("SELECT * FROM product_image WHERE product_id='" . $product['product_id'] . "' AND is_main=1");
        $img = mysqli_fetch_assoc($db->result);
      ?>
        <div class="col-sm-3">

          <div class="card" style="width: 18rem; height:400px;">

            <img style="width: 300px; height:200px" src="<?php echo $img['image_path']; ?>" class="card-img-top img-thumbnail" alt="...">

            <div class="card-body">

              <h5 class="card-title"><?php echo $product['product_title']; ?></h5>

              <p class="card-text"><?php echo substr($product['product_description'], 0, 80); ?></p>

              <hr>

              <a onclick="product_details(<?php echo $product['product_id']; ?>,<?php echo $product['c_id']; ?>)" href="#" class="btn btn-primary">Details</a>
              <a onclick="add_to_cart(<?php echo $product['product_id']; ?>,1)" href="#" class="btn btn-secondary">Add to Cart</a>

            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">


        <!-- Pagination start -->
        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
          <strong>Page
            <?php echo $page_no . " of " . ceil($total_no_of_pages / $limit); ?></strong>
        </div>

        <ul class="pagination" align="center">
          <?php if ($page_no > 1) { ?>

            <li><a href='#' onclick="_e_commerce(1)">First Page</a></li>
          <?php } ?>

          <li <?php if ($page_no <= 1) {
                echo "class='disabled'";
              } ?>>
            <a <?php if ($page_no > 1) { ?> href='#' onclick="_e_commerce(<?php echo $previous_page; ?>)" <?php } ?>>
              Previous</a>
          </li>

          <?php

          if ($total_no_of_pages <= $rows['records']) {
            for ($counter = 1; $counter <= ceil($total_no_of_pages / $limit); $counter++) {
              if ($counter == $page_no) {
                echo "<li class='active'><a>$counter</a></li>";
              } else { ?>
                <li><a href='#' onclick="_e_commerce(<?php echo $counter; ?>)"><?php echo $counter; ?></a>
                </li>
          <?php
              }
            }
          } elseif (ceil($total_no_of_pages / $limit) > 10) {
            // Here we will add further conditions
          }

          ?>

          <li <?php if ($page_no >= ceil($total_no_of_pages / $limit)) {
                echo "class='disabled'";
              } ?>>
            <a <?php if ($page_no < ceil($total_no_of_pages / $limit)) { ?> href='#' onclick="_e_commerce(<?php echo $next_page; ?>)" <?php } ?>>Next</a>
          </li>

          <?php if ($page_no < ceil($total_no_of_pages / $limit)) { ?>

            <li><a href='#' onclick="_e_commerce(<?php echo ceil($total_no_of_pages / $limit); ?>)">Last
                &rsaquo;&rsaquo;</a></li>
          <?php } ?>
        </ul>
        <!-- Pagination End -->
      </div>

    </div>
  </div>

</div>