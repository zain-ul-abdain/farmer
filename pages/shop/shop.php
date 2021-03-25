<!-- Bootstrap CSS -->
<link rel="stylesheet" href="pages/shop/css/bootstrap.min.css">
<!-- Site CSS -->
<link rel="stylesheet" href="pages/shop/css/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="pages/shop/css/responsive.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="pages/shop/css/custom.css">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Site CSS -->
<link rel="stylesheet" href="css/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="css/responsive.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/custom.css">
<?php

session_start();
require_once '../../require/database.php';

$q = "SELECT * FROM product INNER JOIN user_assign_role ON product.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=product.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE product.is_active=1 ORDER BY product.product_id DESC";
$db->_result($q);
$res = $db->result;
?>

<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <?php
      if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other') {
      ?>
        <div class="row">
          <div class="col-12" id="product_form">
            <button onclick="add_product_form()" class="w3-btn w3-green">Add product</button>
          </div>
        </div>
      <?php } ?>
      <h1 class="w3-teal w3-padding-16" align="center">Farmers Online Store</h1>
      <div class="row">
        <div class="col-12">
          <div class="w3-bar w3-blue-gray w3-card w3-padding">
            <p>Categories</p>
            <?php
            $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='E-Commerce' AND parent_category IS NULL");
            if ($db->result->num_rows) {
              while ($c = mysqli_fetch_assoc($db->result)) {
            ?>
                <a href="#" class="w3-bar-item w3-button w3-text-white" onclick="category_post(<?php echo $c['category_id']; ?>)"><?php echo $c['category']; ?></a>
            <?php
              }
            }
            ?>
          </div>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>
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
  <!-- End Products  -->

  <!-- ALL JS FILES -->
  <script src="pages/shop/js/jquery-3.2.1.min.js"></script>
  <script src="pages/shop/js/popper.min.js"></script>
  <script src="pages/shop/js/bootstrap.min.js"></script>
  <!-- ALL PLUGINS -->
  <script src="pages/shop/js/jquery.superslides.min.js"></script>
  <script src="pages/shop/js/bootstrap-select.js"></script>
  <script src="pages/shop/js/inewsticker.js"></script>
  <script src="pages/shop/js/bootsnav.js."></script>
  <script src="pages/shop/js/images-loded.min.js"></script>
  <script src="pages/shop/js/isotope.min.js"></script>
  <script src="pages/shop/js/owl.carousel.min.js"></script>
  <script src="pages/shop/js/baguetteBox.min.js"></script>
  <script src="pages/shop/js/jquery-ui.js"></script>
  <script src="pages/shop/js/jquery.nicescroll.min.js"></script>
  <script src="pages/shop/js/form-validator.min.js"></script>
  <script src="pages/shop/js/contact-form-script.js"></script>
  <script src="pages/shop/js/custom.js"></script>
  <!-- ALL JS FILES -->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- ALL PLUGINS -->
  <script src="js/jquery.superslides.min.js"></script>
  <script src="js/bootstrap-select.js"></script>
  <script src="js/inewsticker.js"></script>
  <script src="js/bootsnav.js."></script>
  <script src="js/images-loded.min.js"></script>
  <script src="js/isotope.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/baguetteBox.min.js"></script>
  <script src="js/form-validator.min.js"></script>
  <script src="js/contact-form-script.js"></script>
  <script src="js/custom.js"></script>