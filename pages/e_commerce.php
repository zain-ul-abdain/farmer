<?php

session_start();
require_once '../require/database.php';

$id = $_POST['id'];
$c_id = $_POST['c_id'];



$q = "SELECT * FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN product_image ON product_image.product_id=product.product_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.product_id='$id' AND product.is_active=1 ORDER BY product.product_id DESC";
$db->_result($q);
$res = $db->result;

$item = mysqli_fetch_assoc($res);

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
            <p><?php
                $db->_result("SELECT AVG(rating) AS 'Stars' FROM product_rating WHERE product_id=" . $item['product_id']);
                if ($db->result->num_rows) {
                  $stars = mysqli_fetch_assoc($db->result);

                ?>
            <div class="rate">
              <input type="radio" id="star5" name="rate<?php echo $consultant['user_id']; ?>" value="5" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 5) {
                                                                                                          echo 'checked';
                                                                                                        } ?> disabled />
              <label for="star5" title="text">5 stars</label>
              <input type="radio" id="star4" name="rate<?php echo $consultant['user_id']; ?>" value="4" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 4) {
                                                                                                          echo 'checked';
                                                                                                        } ?> disabled />
              <label for="star4" title="text">4 stars</label>
              <input type="radio" id="star3" name="rate<?php echo $consultant['user_id']; ?>" value="3" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 3) {
                                                                                                          echo 'checked';
                                                                                                        } ?> disabled />
              <label for="star3" title="text">3 stars</label>
              <input type="radio" id="star2" name="rate<?php echo $consultant['user_id']; ?>" value="2" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 2) {
                                                                                                          echo 'checked';
                                                                                                        } ?> disabled />
              <label for="star2" title="text">2 stars</label>
              <input type="radio" id="star1" name="rate<?php echo $consultant['user_id']; ?>" value="1" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 1) {
                                                                                                          echo 'checked';
                                                                                                        } ?> disabled />
              <label for="star1" title="text">1 star</label>
            </div>
          <?php
                }
          ?>
          </p>
          </div>

          <?php
          if (isset($_SESSION['user'])) {
          ?>
            <div class="row mt-4">
              <nav class="w-100">
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                  <a class="nav-item nav-link active" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="true">Comments</a>
                  <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
                </div>
              </nav>
              <div class="tab-content p-3" id="nav-tabContent">

                <div class="tab-pane fade active in show" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                  <?php
                  $db->_result("SELECT comment FROM product_comment WHERE product_id=" . $id);
                  if ($db->result->num_rows) {
                    while ($comments = mysqli_fetch_assoc($db->result)) {
                      echo $comments['comment'];
                      echo "<br>";
                    }
                  }
                  ?>
                </div>
                <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">


                  <div class="rate">
                    <input onclick="_star(this.value)" type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input onclick="_star(this.value)" type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input onclick="_star(this.value)" type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input onclick="_star(this.value)" type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input onclick="_star(this.value)" type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text">1 star</label>
                  </div>
                  <input type="hidden" id="stars" value="0">

                  <!-- /.contacts-list-info -->
                  <textarea id="rating_msg" style="color:black;"></textarea>
                  <?php

                  if (isset($_SESSION['user'])) { ?>
                    <button onclick="_rating_p(<?php echo $id; ?>)" class="w3-button w3-success">Rate</button>
                  <?php
                  } ?>
                  </li>
                  <!-- End Contact Item -->
                  </ul>
                  <!-- /.contatcts-list -->
                </div>
              </div>
            </div>
          <?php
          } ?>
        </div>

      </div>
      <!-- /.card-body -->
    </div>
</div>


<div class="row">
  <h2>Related Products</h2>
  <?php
  $q = "SELECT * FROM product INNER JOIN category ON category.category_id=product.category_id WHERE category.category_id=$c_id AND product.product_id <> $id";
  $db->_result($q);
  $res2 = $db->result;
  if ($res2->num_rows) {
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

            <a onclick="product_details(<?php echo $product['product_id']; ?>,<?php echo $product['category_id']; ?>)" href="#" class="btn btn-primary">Details</a>
            <a onclick="add_to_cart(<?php echo $product['product_id']; ?>,1)" href="#" class="btn btn-secondary">Add to Cart</a>

          </div>
        </div>
      </div>
    <?php }
  } else {
    ?>
    <p style="margin-left: 20px;">Currently not Available..!</p>
  <?php
  }
  ?>
</div>
<!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->