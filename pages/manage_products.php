<?php
require_once '../require/database.php';
session_start();
if (isset($_POST['action']) && $_POST['action'] == "manage_products") {

  $db->_select("product");
  if ($_SESSION['user']['user_role'] == 'Admin') {
    echo 'Admin';
    $db->_result("SELECT * FROM product ORDER BY product_id DESC");
  } else {
    echo 'Other';
    $db->_result("SELECT * FROM product WHERE user_assign_role_id=" . $_SESSION['user']['user_assign_role_id'] . " ORDER BY product_id DESC");
  }

  if ($db->result->num_rows) {
?>
    <style type="text/css">
      /* The switch - the box around the slider */
      .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
      }

      /* Hide default HTML checkbox */
      .switch input {
        opacity: 0;
        width: 0;
        height: 0;
      }

      /* The slider */
      .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
      }

      .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
      }

      input:checked+.slider {
        background-color: #2196F3;
      }

      input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
      }

      input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
        border-radius: 34px;
      }

      .slider.round:before {
        border-radius: 50%;
      }
    </style>
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="card-body">
            <div class="card">
              <!-- /.card -->
              <div id="users" class="col-12">
                <h2>Manage Products</h2>
                <span id="manage_user_msg"></span>

                <table class="w3-table-all w3-hoverable" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Category Id</th>
                      <th>User Id</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Is Active</th>
                      <th>Is Featured</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    while ($product = mysqli_fetch_assoc($db->result)) {
                    ?>
                      <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><?php echo $product['category_id']; ?></td>
                        <td><?php echo $product['user_assign_role_id']; ?></td>
                        <td><?php echo $product['product_title']; ?></td>
                        <td><?php echo $product['product_description']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>

                        <td>
                          <label class="switch">
                            <?php
                            if ($product['is_active'] == 1) {
                            ?>
                              <input onclick="active_p(this,<?php echo $product['product_id']; ?>)" checked type="checkbox" name="<?php echo "Active"; ?>">
                            <?php
                            } else {
                            ?>
                              <input onclick="active_p(this,<?php echo $product['product_id']; ?>)" type="checkbox" name="<?php echo "Inactive"; ?>">
                            <?php
                            }
                            ?>
                            <span class="slider round"></span>
                          </label>
                        </td>

                        <td>
                          <label class="switch">
                            <?php
                            if ($product['is_featured'] == 1) {
                            ?>

                              <input onclick="is_approved_p(this,<?php echo $product['product_id']; ?>)" checked type="checkbox" name="<?php echo "Approved"; ?>">
                            <?php
                            } else {
                            ?>
                              <input onclick="is_approved_p(this,<?php echo $product['product_id']; ?>)" type="checkbox" name="<?php echo "Inapproved"; ?>">
                            <?php
                            }
                            ?>
                            <span class="slider round"></span>
                          </label>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  } else {
    echo "not ok";
  }
}/* If closed Manage user*/


/* USer status active/inactive*/
if (isset($_POST['action']) && $_POST['action'] == "active_product") {

  $id = $_POST['id'];
  $status = $_POST['status'];

  if ($status == 'Active') {
    $q = "UPDATE product SET is_active=0 WHERE product_id=" . $id;
  }
  if ($status == 'Inactive') {
    $q = "UPDATE product SET is_active=1 WHERE product_id=" . $id;
  }

  $db->_result($q);
  if ($db->result) {
    echo "Status updated";
  } else {
    echo "Status not updated";
  }
}

/* Featured Products*/
if (isset($_POST['action']) && $_POST['action'] == "featured") {

  $id = $_POST['id'];
  $status = $_POST['status'];

  if ($status == 'Approved') {
    $q = "UPDATE product SET is_featured=0 WHERE product_id=" . $id;
  }
  if ($status == 'Inapproved') {
    $q = "UPDATE product SET is_featured=1 WHERE product_id=" . $id;
  }

  $db->_result($q);
  if ($db->result) {
    echo "Status updated";
  } else {
    echo "Status not updated";
  }
}


?>