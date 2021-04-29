<?php

session_start();
require_once '../require/database.php';

$q = "SELECT *,product.category_id AS 'c_id' FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.is_active=1 ORDER BY product.product_id DESC";
$db->_result($q);
$res = $db->result;
?>

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
                <a href="#" class="w3-bar-item w3-button" onclick="category_post(<?php echo $c['category_id']; ?>)"><?php echo $c['category']; ?></a>
            <?php
              }
            }
            ?>
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


    <div class="row">
      <div class="col-sm-12">
        <div class="mt-4">
          <a href="pages/cart.php" class="btn btn-primary btn-lg btn-flat">
            <i class="fas fa-cart-plus fa-lg mr-2"></i>
            Show Cart
          </a>
        </div>
      </div>
    </div>

    <div class="row p-4">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-6">

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
      <div class="col-sm-3">
      </div>
    </div>

    <div class="row">
      <?php
      while ($product = mysqli_fetch_assoc($res)) {
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

  </div>