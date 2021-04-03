<?php

session_start();
if (isset($_POST['action']) && $_POST['action'] == 'dashboard') {
  require_once('../require/database.php');

  //	Total Orders 
  $db->query  = "SELECT count(customer_order_id) FROM customer_order";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $total_orders = mysqli_fetch_assoc($db->result);
  }

  //  My Product Orders 
  $db->query  = "SELECT count(customer_order_id) FROM customer_order WHERE user_assign_role_id=" . $_SESSION['user']['user_assign_role_id'];
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $my_product_orders = mysqli_fetch_assoc($db->result);
  }

  //	Pending Orders 
  $db->_result("SELECT count(customer_order_id) FROM customer_order WHERE status='On The Way'");

  if ($db->result->num_rows) {
    $pending_orders = mysqli_fetch_assoc($db->result);
  }

  //	Completed Orders 
  $db->query = "SELECT count(customer_order_id) FROM customer_order WHERE status='Delivered'";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $completed_orders = mysqli_fetch_assoc($db->result);
  }

  //  Canceled Orders 
  $db->query = "SELECT count(customer_order_id) FROM customer_order WHERE status='Cancel'";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $canceled_orders = mysqli_fetch_assoc($db->result);
  }

  //	Total users 
  $db->query  = "SELECT count(user_id) FROM user";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $total_users = mysqli_fetch_assoc($db->result);
  }

  //  New users 
  $db->query  = "SELECT count(user_id) FROM user WHERE is_approved=0";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $new_users = mysqli_fetch_assoc($db->result);
  }

  //  Active users 
  $db->query  = "SELECT count(user_id) FROM user WHERE is_active=1";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $active_users = mysqli_fetch_assoc($db->result);
  }

  //  Inactive users 
  $db->query  = "SELECT count(user_id) FROM user WHERE is_active=0";
  $db->result = mysqli_query($db->connection, $db->query);

  if ($db->result->num_rows) {
    $inactive_users = mysqli_fetch_assoc($db->result);
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <h1>Dashboard</h1>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-12">
                <a href="#" onclick="_manage()">Manage Users</a>
                |
                <a href="#" onclick="_products()">Manage Products</a>
                |
                <a href="#" onclick="_comments()">Manage Post</a>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php
        if ($_SESSION['user']['user_role'] == "Admin") {
        ?>
          <h3>Users Statistics</h3>
          <div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php echo $pending_orders['count(customer_order_id)'] ?? "0"; ?></h3>

                  <p>Pending orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo $completed_orders['count(customer_order_id)'] ?? "0"; ?></h3>

                  <p>Completed Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php echo $canceled_orders['count(customer_order_id)'] ?? "0"; ?></h3>

                  <p>Canceled Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <!-- ./col -->



            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $total_orders['count(customer_order_id)'] ?? '0'; ?></h3>

                  <p>Total Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php echo $total_users['count(user_id)']; ?></h3>

                  <p>Total Users</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $new_users['count(user_id)']; ?></h3>

                  <p>New users</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $inactive_users['count(user_id)']; ?></h3>

                  <p>Inactive Users</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $active_users['count(user_id)']; ?></h3>

                  <p>Active Users</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <div class="col-lg-3 col-6">
              <div class="info-box bg-success">
                <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Likes</span>
                  <span class="info-box-number">41,410</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-lg-3 col-6">
              <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-comments"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Comments</span>
                  <span class="info-box-number">41,410</span>

                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <!-- /.row -->
        <?php
        } ?>
        <?php
        if ($_SESSION['user']['user_role'] != "Other") { ?>
          <h3>Personal Statistics</h3>
          <div class="row">
            <?php
            $q = "SELECT count(customer_order_id) AS count FROM customer_order WHERE status='On The Way' AND user_assign_role_id=" . $_SESSION['user']['user_assign_role_id'];
            $db->_result($q);
            $rec = mysqli_fetch_assoc($db->result);
            ?>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php echo $rec['count'] ?? 0; ?></h3>

                  <p>Pending orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php echo $my_product_orders['count(customer_order_id)'] ?? 0; ?></h3>

                  <p>My Product Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

          <?php
        }
          ?>
          </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<?php
}
?>