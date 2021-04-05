<?php
require_once '../require/database.php';
session_start();
if (isset($_POST['action']) && $_POST['action'] == "manage_comments") {

  if ($_SESSION['user']['user_role'] == 'Admin') {
    echo 'Admin';
    $db->_result("SELECT * FROM post ORDER BY post.post_id DESC");
  } elseif ($_SESSION['user']['user_role'] == 'Consultant') {
    echo 'Consultant';
    $db->_result("SELECT * FROM post WHERE post_type='Knowledge Base' AND user_assign_role_id=" . $_SESSION['user']['user_assign_role_id'] . " ORDER BY post_id DESC");
  } else {
    echo 'Else';
    $db->_result("SELECT * FROM post WHERE post.user_assign_role_id=" . $_SESSION['user']['user_assign_role_id'] . " ORDER BY post.post_id DESC");
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
                <h2>Manage Post</h2>
                <span id="manage_user_msg"></span>

                <table class="w3-table-all w3-hoverable" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Post ID</th>
                      <th>Category Id</th>
                      <th>User Id</th>
                      <th>Title</th>
                      <th>Post Type</th>
                      <th>Is Active</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    while ($product = mysqli_fetch_assoc($db->result)) {
                    ?>
                      <tr>
                        <td><?php echo $product['post_id']; ?></td>
                        <td><?php echo $product['category_id']; ?></td>
                        <td><?php echo $product['user_assign_role_id']; ?></td>
                        <td><?php echo $product['post_title']; ?></td>
                        <td><?php echo $product['post_type']; ?></td>

                        <td>
                          <label class="switch">
                            <?php
                            if ($product['is_active'] == 1) {
                            ?>
                              <input onclick="active_post(this,<?php echo $product['post_id']; ?>)" checked type="checkbox" name="<?php echo "Active"; ?>">
                            <?php
                            } else {
                            ?>
                              <input onclick="active_post(this,<?php echo $product['post_id']; ?>)" type="checkbox" name="<?php echo "Inactive"; ?>">
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
?>