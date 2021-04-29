<?php
session_start();
require_once '../require/database.php';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "product_rate") {

  if (isset($_REQUEST['star']) && $_REQUEST['star'] != 0) {
    $db->_result("INSERT INTO product_rating ( user_assign_role_id, product_id, rating) VALUES ('" . $_SESSION['user']['user_assign_role_id'] . "','" . $_REQUEST['p_id'] . "','" . $_REQUEST['star'] . "')");
    if ($db->result) {
      echo "Rating added successfully..!   ";
    }
  }
  if (isset($_REQUEST['feedback']) && $_REQUEST['feedback'] != '') {
    $db->_result("INSERT INTO product_comment ( user_assign_role_id, product_id, comment) VALUES ('" . $_SESSION['user']['user_assign_role_id'] . "','" . $_REQUEST['p_id'] . "','" . $_REQUEST['feedback'] . "')");
    if ($db->result) {
      echo "Comment added successfully..!";
    }
  }
}
