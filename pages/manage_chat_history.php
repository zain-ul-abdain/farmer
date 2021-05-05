<?php
require_once '../require/database.php';
session_start();
if (isset($_POST['action']) && $_POST['action'] == "manage_chat_history") {

  $db->_select("product");
  if ($_SESSION['user']['user_role'] == 'Admin') {
    $q = "SELECT * FROM consultancy_service INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=consultancy_service.consultant INNER JOIN user ON user.user_id=user_assign_role.user_id INNER JOIN category ON category.category_id=consultancy_service.category_id ORDER BY consultancy_service.consultancy_service_id DESC";
    $db->_result($q);
  } else {
    $q = "SELECT * FROM consultancy_service INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=consultancy_service.consultant INNER JOIN user ON user.user_id=user_assign_role.user_id INNER JOIN category ON category.category_id=consultancy_service.category_id WHERE user_assign_role.user_assign_role_id='" . $_SESSION['user']['user_assign_role_id'] . "' ORDER BY consultancy_service.consultancy_service_id DESC";
    $db->_result($q);
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
                <h2>Manage Chat History</h2>
                <span id="manage_user_msg"></span>

                <table class="w3-table-all w3-hoverable" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Chat ID</th>
                      <th>Consultant</th>
                      <th>Client</th>
                      <th>Category</th>
                      <th>Query</th>
                      <th>Discussion Start</th>
                      <th>Discussion End</th>
                      <th>Status</th>
                      <th>Stars</th>
                      <th>Feedback</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    while ($product = mysqli_fetch_assoc($db->result)) {
                      // print_r($product);
                    ?>
                      <tr>
                        <td><?php echo $product['consultancy_service_id']; ?></td>
                        <td><?php echo $product['first_name']; ?></td>
                        <td><?php echo $product['client']; ?></td>
                        <td><?php echo $product['category']; ?></td>
                        <td><?php echo $product['query']; ?></td>
                        <td><?php echo $product['discussion_start']; ?></td>
                        <td><?php echo ($product['status'] == 'In-Process') ? "-" : $product['discussion_end']; ?></td>
                        <td><?php echo $product['status']; ?></td>
                        <td><?php echo $product['rating']; ?></td>
                        <td><?php echo $product['feedback']; ?></td>
                        <td><button onclick="chat_history_process(<?php echo $product['consultancy_service_id']; ?>)" class="btn btn-primary">View Detail</button></td>
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


if (isset($_POST['action']) && $_POST['action'] == "chat_history_process") {

  extract($_REQUEST);
  $db->_result("SELECT * FROM consultancy_service_chat 
  INNER JOIN user_assign_role 
  ON user_assign_role.user_assign_role_id=consultancy_service_chat.user_assign_role_id 
  INNER JOIN user
  ON user.user_id=user_assign_role.user_id
  WHERE consultancy_service_chat.consultancy_service_id=$chat_id");

  if ($db->result->num_rows) {

    while ($msg = mysqli_fetch_assoc($db->result)) {
    ?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="card-body">
              <div class="card">
                <!-- /.card -->
                <div id="users" class="col-12">
                  <h2>Chat History</h2>
                  <span id="manage_user_msg"></span>

                  <table class="w3-table-all w3-hoverable" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Chat ID</th>
                        <th>Message</th>
                        <th>Message By</th>
                        <th>Time</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      while ($product = mysqli_fetch_assoc($db->result)) {
                        // print_r($product);
                      ?>
                        <tr>
                          <td><?php echo $product['consultancy_service_id']; ?></td>
                          <td><?php echo $product['chat_message']; ?></td>
                          <td><?php echo $product['first_name']; ?></td>
                          <td><?php echo $product['added_on']; ?></td>
                          <td><button class="btn btn-primary">Action</button></td>
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
    }
  } else {
    echo "Has not record";
  }
}


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