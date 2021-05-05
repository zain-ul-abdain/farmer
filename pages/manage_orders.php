<?php
require_once '../require/database.php';
session_start();


if (isset($_POST['action']) && $_POST['action'] == "order_status") {
  extract($_REQUEST);
  $q = "UPDATE customer_order SET status='$value' WHERE customer_order_id=$order_id";
  $db->_result($q);
  if ($db->result) {
    echo "Order Status Updated Successfully ..!";
    if ($value == "Cancel") {
      $db->_result("SELECT * FROM customer_order_detail WHERE customer_order_id=$order_id");
      if ($db->result) {
        while ($item = mysqli_fetch_assoc($db->result)) {
          $q = "SELECT * FROM product WHERE product_id=" . $item['product_id'];
          $res = mysqli_query($db->connection, $q);
          if ($res->num_rows) {
            $record = mysqli_fetch_assoc($res);
            $q2 = "UPDATE product SET quantity='" . ($item['quantity'] + $record['quantity']) . "' WHERE product_id=" . $item['product_id'];
            $res2 = mysqli_query($db->connection, $q2);
            if ($res2) {
              echo "Product: " . $item['product_id'] . " Quantity Updated";
            } else {
              echo "Product: " . $item['product_id'] . " Not Quantity Updated";
            }
          }
        }
      }
    }
  } else {
    echo "Order Status Not Updated..!";
  }
}
if (isset($_POST['action']) && $_POST['action'] == "manage_orders") {

  if ($_SESSION['user']['user_role'] == 'Admin') {
    $q = "SELECT * FROM customer_order INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=customer_order.user_assign_role_id INNER JOIN user ON user.user_id=user_assign_role.user_id ORDER BY customer_order_id DESC";
    $db->_result($q);
  } else {
    $db->_result("SELECT * FROM customer_order INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=customer_order.user_assign_role_id INNER JOIN user ON user.user_id=user_assign_role.user_id WHERE user_assign_role.user_assign_role_id='" . $_SESSION['user']['user_assign_role_id'] . "' ORDER BY customer_order_id DESC");
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
                <h2>Manage Orders</h2>
                <span id="manage_user_msg"></span>
                <div id="for_comment">
                  <table class="w3-table-all w3-hoverable" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Order By</th>
                        <th>Order Status</th>
                        <th>Payment Method</th>
                        <th>Order Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      while ($customer_order = mysqli_fetch_assoc($db->result)) {
                      ?>
                        <tr>
                          <td><?php echo $customer_order['customer_order_id']; ?></td>
                          <td><?php echo $customer_order['first_name']; ?></td>

                          <td>
                            <select <?php if ($customer_order['status'] == "Cancel") {
                                      echo "disabled";
                                    } ?> onchange="order_status(<?php echo $customer_order['customer_order_id']; ?>)" name="status" id="status">
                              <option><?php echo $customer_order['status']; ?></option>
                              <option value="Cancel">Cancel</option>
                              <option value="On The Way">On The Way</option>
                              <option value="Delivered">Delivered</option>
                            </select>
                          </td>

                          <td><?php echo $customer_order['payment_method']; ?></td>

                          <td><?php echo $customer_order['added_on']; ?></td>
                          <td><a href="pages/manage_order_detail.php?pro_id=<?php echo $customer_order['customer_order_id']; ?>" class="w3-button w3-circle w3-orange">View Details</a></td>
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
    </div>
  <?php
  }
}/* If closed Manage user*/


/* USer status active/inactive*/
if (isset($_POST['action']) && $_POST['action'] == "active_post") {

  $id = $_POST['id'];
  $status = $_POST['status'];

  if ($status == 'Active') {
    $q = "UPDATE post SET is_active=0 WHERE post_id=" . $id;
  }
  if ($status == 'Inactive') {
    $q = "UPDATE post SET is_active=1 WHERE post_id=" . $id;
  }

  $db->_result($q);
  if ($db->result) {
    echo "Post Status updated";
  } else {
    echo "Post Status not updated";
  }
}

/* Comment status active/inactive*/
if (isset($_POST['action']) && $_POST['action'] == "comment_allow") {

  $id = $_POST['id'];
  $p_id = $_POST['p_id'];
  $status = $_POST['status'];

  if ($status == 'Active') {
    $q = "UPDATE post_reply SET is_approved=0 WHERE post_reply_id=" . $id;
  }
  if ($status == 'Inactive') {
    $q = "UPDATE post_reply SET is_approved=1 WHERE post_reply_id=" . $id;
  }

  $db->_result($q);
  if ($db->result) {
    echo "Post ID = $p_id Comment Status updated";
  } else {
    echo "Post Comment Status not updated";
  }
}

/* Post Comment status active/inactive*/
if (isset($_POST['action']) && $_POST['action'] == "comment") {

  $id = $_POST['id'];

  $db->_result("SELECT * FROM post_reply WHERE post_id=$id ORDER BY post_reply_id DESC");

  if ($db->result->num_rows) {

  ?>
    <table class="w3-table-all w3-hoverable" style="width: 100%;">
      <thead>
        <tr>
          <th>Post ID</th>
          <th>Comment ID</th>
          <th>Message</th>
          <th>User Id</th>
          <th>Added On</th>
          <th>Is Approved</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($comment = mysqli_fetch_assoc($db->result)) {
        ?>
          <tr>
            <td><?php echo $comment['post_id']; ?></td>
            <td><?php echo $comment['post_reply_id']; ?></td>
            <td><?php echo $comment['message']; ?></td>
            <td><?php echo $comment['user_assign_role_id']; ?></td>
            <td><?php echo $comment['added_on']; ?></td>
            <td>
              <label class="switch">
                <?php
                if ($comment['is_approved'] == 1) {
                ?>
                  <input onclick="active_comment(this,<?php echo $comment['post_reply_id']; ?>,<?php echo $comment['post_id']; ?>)" checked type="checkbox" name="<?php echo "Active"; ?>">
                <?php
                } else {
                ?>
                  <input onclick="active_comment(this,<?php echo $comment['post_reply_id']; ?>,<?php echo $comment['post_id']; ?>)" type="checkbox" name="<?php echo "Inactive"; ?>">
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

<?php
  }
}
?>