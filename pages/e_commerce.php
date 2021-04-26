<?php

session_start();
require_once '../require/database.php';

$id = $_POST['id'];

$q = "SELECT * FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN product_image ON product_image.product_id=product.product_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.product_id='$id' AND product.is_active=1 ORDER BY product.product_id DESC";
$db->_result($q);
$res = $db->result;

$item = mysqli_fetch_assoc($res);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

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
    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="col-12">
              <img style="width: 500px;height:400px;" id="main" src="<?php echo $item['image_path']; ?>" class="product-image" alt="Product Image">
            </div>
            <div class="col-12 product-image-thumbs">
              <?php
              $db->_result("SELECT * FROM product_image WHERE product_id='$id'");
              while ($img = mysqli_fetch_assoc($db->result)) {
              ?>
                <div class="product-image-thumb" onclick="change_product_image(this.children[0].getAttribute('src'))"><img src="<?php echo $img['image_path']; ?>" alt="Product Image"></div>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <h3 class="my-3"><?php echo $item['product_title']; ?></h3>
            <p><?php echo $item['product_description']; ?></p>

            <hr>



            <div class="bg-gray py-2 px-3 mt-4">
              <h2 class="mb-0">
                PKR <?php echo $item['price']; ?>
              </h2>

            </div>

            <div class="mt-4">

              <label for="quantity">Quantity</label>
              <input id="quantity" class="form-control" style="width:60px;" type="number" min="1" max="10" value="1">
              <div class="btn btn-primary btn-lg btn-flat" onclick="add_to_cart(<?php echo $item['product_id']; ?>,0)">
                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                Add to Cart
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="true">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">

              <div class="tab-pane fade active in show" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                unavailable
              </div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
                unavailable
              </div>
            </div>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->