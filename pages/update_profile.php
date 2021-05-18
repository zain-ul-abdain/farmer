<?php

session_start();

require_once '../require/database.php';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "update_profile") {

  if ($_SESSION['user']['user_password'] == hash('md5', $_REQUEST['c_pass'])) {
    $pass = hash('md5', $_REQUEST['n_pass']);
    $db->_result("UPDATE user set user_password='$pass'  WHERE user_id=" . $_SESSION['user']['user_id']);
    if ($db->result) {
      echo "Password updated successfully ..!";
      $_SESSION['user']['user_password'] = $pass;
    } else {
      echo "Password does not updated";
    }
  } else {
    echo "Your current password does not matched";
  }
}
