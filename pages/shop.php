<?php

session_start();
require_once '../require/database.php';

$q = "SELECT * FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.is_active=1 ORDER BY product.product_id DESC";
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
      <?php
      while ($product = mysqli_fetch_assoc($res)) {
        $db->_result("SELECT * FROM product_image WHERE product_id='" . $product['product_id'] . "' AND is_main=1");
        $img = mysqli_fetch_assoc($db->result);
      ?>
        <div class="col-sm-3">

          <div class="card" style="width: 18rem;">

            <img style="width: 300px; height:200px" src="<?php echo $img['image_path']; ?>" class="card-img-top img-thumbnail" alt="...">

            <div class="card-body">

              <h5 class="card-title"><?php echo $product['product_title']; ?></h5>

              <p class="card-text"><?php echo substr($product['product_description'], 0, 80); ?></p>

              <a onclick="product_details(<?php echo $product['product_id']; ?>)" href="#" class="btn btn-primary">Details</a>

            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- Start Products  -->
  <div class="products-box">
    <div class="container">
      <div class="row special-list">


        <?php
        while ($product = mysqli_fetch_assoc($res)) {
          $db->_result("SELECT * FROM product_image WHERE product_id='" . $product['product_id'] . "' AND is_main=1");
          $img = mysqli_fetch_assoc($db->result);
        ?>

          <div class="col-lg-3 col-md-6 special-grid best-seller">
            <div class="products-single fix">
              <div class="box-img-hover">
                <div class="type-lb">
                  <p class="sale"><?php echo $product['category']; ?></p>
                </div>
                <img style="width: 100%; height: 200px;" src="<?php echo $img['image_path']; ?>" class="img-fluid" alt="Image">
                <div class="mask-icon">
                  <ul>
                    <li onclick="product_details(<?php echo $product['product_id']; ?>)"><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye">View Details</i></a></li>
                  </ul>
                  <a class="cart" href="#">Add to Cart</a>
                </div>
              </div>
              <div class="why-text">
                <h4><?php echo $product['product_title']; ?></h4>
                <p><?php echo substr($product['product_description'], 0, 80); ?><a href="#" onclick="product_details(<?php echo $product['product_id']; ?>)">...show details</a></p>
                <p>Seller: <?php echo $product['first_name']; ?></p>
                <h5>PKR <?php echo $product['price']; ?></h5>
              </div>
            </div>
          </div>

        <?php   } ?>
      </div>
    </div>
  </div>