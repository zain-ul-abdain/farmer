<?php

if (isset($_POST['action']) && $_POST['action'] == 'category_product') {
  require_once '../require/database.php';
  $q = "SELECT *,product.category_id AS 'c_id' FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.quantity > product.low_inventory  AND product.is_active=1 AND category.category_id='" . $_REQUEST['id'] . "' ORDER BY product.product_id DESC";
  $db->_result($q);
  $res = $db->result;
?>
  <div class="row">
    <?php
    while ($product = mysqli_fetch_assoc($res)) {
      $db->_result("SELECT * FROM product_image WHERE product_id='" . $product['product_id'] . "' AND is_main=1");
      $img = mysqli_fetch_assoc($db->result);
    ?>
      <div class="col-sm-3">

        <div class="card" style="width: 18rem; height:450px;">

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
  <?php
    }
  }
  ?>
  </div>