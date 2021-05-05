<?php
session_start();
if (isset($_SESSION['cart'])) {

  $s_address = $_REQUEST['s_address'] ?? 'same as billing address';
  require_once '../require/database.php';

  foreach ($_SESSION['cart'] as $key => $value) {

    $select = "SELECT quantity FROM product WHERE product_id=" . $key;
    $db->_result($select);
    $qty = mysqli_fetch_assoc($db->result);
    $result = $qty['quantity'] - $value['quantity'];
    $query = "UPDATE product SET quantity=$result WHERE product_id=" . $key;
    $db->_result($query);
  }
  $sess = $db->result;

  $db->_result("INSERT INTO customer_order ( user_assign_role_id,billing_address, shipping_address )  VALUES('" . $_SESSION['user']['user_assign_role_id'] . "','" . $_REQUEST['address'] . "','" . $s_address . "')");

  if ($db->result) {
    $last_id = mysqli_insert_id($db->connection);

    foreach ($_SESSION['cart'] as $key => $value) {
      $q = "INSERT INTO customer_order_detail ( customer_order_id, product_id, quantity )  VALUES('" . $last_id . "','" . $key . "','" . $value['quantity'] . "')";
      $db->_result($q);
    }
  }

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>.:: Farmer Connection ::.</title>
    <link rel="icon" href="../logo.jpg" type="image/x-icon" />


    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap for pagination -->
    <link rel="stylesheet" href="../https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="../https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- W3 CSS -->
    <link rel="stylesheet" type="text/css" href="../css/w3.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="../https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  </head>

  <body class="hold-transition sidebar-collapse layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="../#" role="button"><i class="fas fa-bars"></i></a>
          </li>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../index.php" class="nav-link">Home</a>
          </li>
          <?php
          if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other') {
          ?>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="../#" onclick="_dashboard()" class="nav-link">Dashboard</a>
            </li>

          <?php
          }
          ?>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../#" onclick="_knowledge_base()" class="nav-link">Knowledge Base</a>
          </li>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../#" onclick="_discussion_forum()" class="nav-link">Discussion Forum</a>
          </li>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../#" onclick="_consultant()" class="nav-link">Consultancy Service</a>
          </li>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../#" onclick="_e_commerce()" class="nav-link">E-Commerce</a>
          </li>
        </ul>



        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">


          <?php

          require_once '../require/database.php';

          if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'Consultant') {
            $db->_result("SELECT count(consultant) AS 'Total' FROM consultancy_service WHERE status='In-Process' AND consultant=" . $_SESSION['user']['user_assign_role_id']);
            $result = mysqli_fetch_assoc($db->result);
          }
          if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Consultant') {
            $db->_result("SELECT count(client) AS 'Total' FROM consultancy_service WHERE status='In-Process' AND client=" . $_SESSION['user']['user_assign_role_id']);
            $result = mysqli_fetch_assoc($db->result);
          }
          if (isset($_SESSION['user'])) {

            if ($_SESSION['user']['user_role'] == 'Consultant') {
              $db->_result("SELECT * FROM consultancy_service INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=consultancy_service.client INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE status='In-Process' AND consultant=" . $_SESSION['user']['user_assign_role_id']);
            } else {
              $db->_result("SELECT * FROM consultancy_service INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=consultancy_service.client INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE status='In-Process' AND client=" . $_SESSION['user']['user_assign_role_id']);
            }

            if ($db->result->num_rows) {
          ?>
              <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="../#">
                  <i class="far fa-comments"></i>
                  <span class="badge badge-danger navbar-badge"><?php echo  $result['Total']; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <?php
                  while ($client = mysqli_fetch_assoc($db->result)) {

                    if ($_SESSION['user']['user_role'] == 'Consultant') { ?>
                      <a onclick="_chat(<?php echo $client['consultancy_service_id']; ?>,<?php echo $client['user_assign_role_id']; ?>)" href="../#" class="dropdown-item">
                      <?php
                    } else {
                      ?>
                        <a onclick="_chat(<?php echo $client['consultancy_service_id']; ?>,<?php echo $client['consultant']; ?>)" href="../#" class="dropdown-item">
                        <?php
                      }
                        ?>
                        <!-- Message Start -->
                        <div class="media">
                          <img src="../<?php echo  $client['user_image']; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                          <div class="media-body">
                            <h3 class="dropdown-item-title">
                              <?php echo $client['first_name']; ?>
                            </h3>
                            <p class="text-sm"><?php echo  $client['query']; ?></p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?php echo  date("h:i a - d/m/y", strtotime($client['discussion_start'])); ?></p>
                          </div>
                        </div>
                        <!-- Message End -->
                        </a>
                      <?php
                    }
                      ?>
                      <div class="dropdown-divider"></div>
                      <a href="../#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
              </li>

          <?php
            }
          }
          ?>

          <!-- Messages Dropdown Menu -->


          <?php
          if (!empty($_SESSION['user'])) { ?>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="../#" class="nav-link">Welcome: <?php echo $_SESSION['user']['first_name'] . " (" . $_SESSION['user']['user_role'] . ")"; ?></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="../forms/login.php?msg=logout" class="nav-link">Log out</a>
            </li>
          <?php
          } else { ?>

            <li class="nav-item d-none d-sm-inline-block">
              <a href="../forms/login.php" class="nav-link">login</a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
              <a href="../forms/register.php" class="nav-link">Register</a>
            </li>
          <?php
          }
          ?>

        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="../index.php" class="brand-link">
          <img src="../logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Farmer Connection</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <?php if (isset($_SESSION['user'])) { ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="../<?php echo $_SESSION['user']['user_image']; ?>" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                <a onclick="view_profile(<?php echo $_SESSION['user']['user_assign_role_id']; ?>)" href="../#" class="d-block">
                  <?php
                  echo $_SESSION['user']['first_name'] ?? '';
                  echo " (" . $_SESSION['user']['user_role'] . ")";
                  ?></a>
              </div>
            </div>
          <?php } ?>


          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <?php
              if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != "Other") { ?>

                <li class="nav-item">
                  <a onclick="_dashboard()" id="dashboard" href="../#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="display: none;">

                    <?php
                    if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'Admin') {
                    ?>
                      <li class="nav-item">
                        <a onclick="_manage()" href="../#" class="nav-link">
                          <i class="fa fa-users nav-icon"></i>
                          <p> Manage Users</p>
                        </a>
                      </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                      <a onclick="_products()" href="../#" class="nav-link">
                        <i class="fas fa-shopping-bag nav-icon"></i>
                        <p> Manage Products</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a onclick="_comments()" href="../#" class="nav-link">
                        <i class="fas fa-clone nav-icon"></i>
                        <p> Manage Post</p>
                      </a>
                    </li>

                  </ul>
                </li>

              <?php
              } ?>

              <li class="nav-item">
                <a onclick="_knowledge_base()" id="knowledge_base" href="../#" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Knowledge Base
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                  <?php
                  $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Knowledge_Base' AND parent_category IS NULL");
                  if ($db->result->num_rows) {
                    while ($c = mysqli_fetch_assoc($db->result)) {
                  ?>
                      <li class="nav-item">
                        <a onclick="category_post(<?php echo $c['category_id']; ?>,1)" href="../#" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p><?php echo $c['category']; ?></p>
                        </a>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </li>

              <li class="nav-item">
                <a onclick="_discussion_forum()" id="forum" href="../#" class="nav-link">
                  <i class="fab fa-rocketchat"></i>
                  <p>
                    Discussion Forum
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                  <?php
                  $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='discussion_forum' AND parent_category IS NULL");
                  if ($db->result->num_rows) {
                    while ($c = mysqli_fetch_assoc($db->result)) {
                  ?>
                      <li class="nav-item">
                        <a onclick="category_post(<?php echo $c['category_id']; ?>,2)" href="../#" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p><?php echo $c['category']; ?></p>
                        </a>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </li>


              <li class="nav-item">
                <a onclick="_consultant()" id="consultant" href="../#" class="nav-link">
                  <i class="fa fa-user-md"></i>
                  <p>Consultancy Service</p>
                </a>
              </li>

              <li class="nav-item">
                <a onclick="_e_commerce()" id="forum" href="../#" class="nav-link">
                  <i class="fa fa-shopping-bag"></i>
                  <p>E-Commerce</p>
                </a>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      <div id="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Invoice</h1>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">



                  <!-- Main content -->
                  <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                      <div class="col-12">
                        <h4>
                          <i class="fas fa-globe"></i> Farmer Connection
                          <small class="float-right"><?php echo "Date: " . date("d/m/Y", time()); ?></small>
                          </h2>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                      <div class="col-sm-3 invoice-col">
                        From
                        <address>
                          <strong>Farmer Connection</strong><br>
                          795 Folsom Ave, Suite 600<br>
                          San Francisco, CA 94107<br>
                          Phone: (123) 123-5432<br>
                          Email: info@farmerconnection.com
                        </address>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-3 invoice-col">
                        Billing Address
                        <address>
                          <strong><?php echo $_REQUEST['firstname'] ?? ''; ?></strong><br>
                          <?php echo $_REQUEST['address'] ?? ''; ?><br>
                          Phone: <?php echo $_REQUEST['phone_number'] ?? ''; ?><br>
                          Email: <?php echo $_REQUEST['email'] ?? ''; ?>
                        </address>
                      </div>
                      <!-- /.col -->
                      <?php
                      if (isset($_REQUEST['sameadr']) && $_REQUEST['sameadr'] == 'on') {
                      ?>
                        <div class="col-sm-3 invoice-col">
                          Shipping Address
                          <address>
                            <strong> Same as Billing Address </strong><br>
                          </address>
                        </div>
                      <?php
                      } else {
                      ?>
                        <div class="col-sm-3 invoice-col">
                          Shipping Address
                          <address>
                            <strong><?php echo $_REQUEST['s_firstname'] ?? ''; ?></strong><br>
                            <?php echo $_REQUEST['s_address'] ?? ''; ?><br>
                            Phone: <?php echo $_REQUEST['s_phone_number'] ?? ''; ?><br>
                            Email: <?php echo $_REQUEST['s_email'] ?? ''; ?>
                          </address>
                        </div>
                      <?php
                      }
                      ?>
                      <!-- /.col -->
                      <div class="col-sm-3 invoice-col">
                        <b>Invoice #<?php echo rand(); ?></b><br>
                        <br>
                        <b>Order ID:</b> <?php echo $last_id; ?><br>
                        <b>Payment Due:</b> <?php echo "Date: " . date("d/m/Y", time() + (24 * 60 * 60)); ?><br>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Item #</th>
                              <th>Product Name</th>
                              <th>Description</th>
                              <th>Qty</th>
                              <th>Subtotal</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $total = 0;
                            $a = 1;

                            foreach ($_SESSION['cart'] as $key => $value) {

                              $db->_result("SELECT * FROM product,product_image WHERE product.product_id=product_image.product_id AND product.is_featured=1 AND product_image.is_main=1 AND product.is_active=1 AND product.product_id=" . $key);
                              $cart = mysqli_fetch_assoc($db->result);
                            ?>
                              <tr>
                                <td><?php echo $a++; ?></td>
                                <td><?php echo $cart['product_title']; ?></td>
                                <td><?php echo $cart['product_description']; ?></td>
                                <td><?php echo $_SESSION['cart'][$key]['quantity']; ?></td>
                                <td>Rs. <?php echo ($cart['price'] * $_SESSION['cart'][$key]['quantity']);
                                        $total += ($cart['price'] * $_SESSION['cart'][$key]['quantity']); ?></td>
                              </tr>
                            <?php }
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                      <!-- accepted payments column -->
                      <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="../dist/img/credit/visa.png" alt="Visa">
                        <img src="../dist/img/credit/mastercard.png" alt="Mastercard">
                        <img src="../dist/img/credit/american-express.png" alt="American Express">
                        <img src="../dist/img/credit/paypal2.png" alt="Paypal">
                        <img src="../dist/img/credit/cod2.jpg" alt="Cash on Delivery">

                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                          Currently Available Payment Methods is : <br>
                          1. Cash on delivery. <input checked disabled type="checkbox" name="cash" id="cash">
                        </p>
                      </div>
                      <!-- /.col -->
                      <div class="col-6">
                        <p class="lead">Amount Due <?php echo "Date: " . date("d/m/Y", time() + (24 * 60 * 60)); ?></p>

                        <div class="table-responsive">
                          <table class="table">
                            <tr>
                              <th style="width:50%">Subtotal:</th>
                              <td>Rs. <?php echo $total; ?></td>
                            </tr>
                            <tr>
                              <th>Tax (<?php echo $tax_rate = 0; ?>%)</th>
                              <td>Rs. <?php
                                      echo  $tax = $total * $tax_rate / 100;
                                      $total = $total + $tax;
                                      $calculatedTaxRate = (($total - $total) / $total) * 100;  ?></td>
                            </tr>
                            <tr>
                              <th>Shipping:</th>
                              <td>Rs. <?php echo $shipping = 0; ?></td>
                            </tr>
                            <tr>
                              <th>Total:</th>
                              <td>Rs. <?php echo ($shipping + $total); ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <?php
                    if ($sess) {
                      unset($_SESSION['cart']);
                    }

                    ?>
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                      <div class="col-12">
                        <a href="#" onclick="print_invoice()" class="btn btn-default"><i class="fas fa-print"></i> Print / Generate PDF</a>
                        <a href="../index.php" type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Return Home </a>
                      </div>
                    </div>
                  </div>
                  <!-- /.invoice -->
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
        </div>
      </div>


      <!-- Main Footer -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2014-<?php echo date("Y", time()); ?><a href="../#"> Farmer Connection</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 3.1.0-rc
        </div>
      </footer>
    </div>
    <!-- ./wrapper -->

    <script>
      function print_invoice() {

        window.addEventListener("load", window.print());
      }
    </script>

    <!-- REQUIRED SCRIPTS -->
    <script type="text/javascript" src="../script/functions.js"></script>
    <!-- Bootstrap 5 Js -->

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="../plugins/raphael/raphael.min.js"></script>
    <script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="../plugins/chart.js/Chart.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js"></script>
  </body>

  </html>

<?php
} else {
  header("location:../index.php?msg=Your Cart is Empty");
}
?>