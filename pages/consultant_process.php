<?php

require_once '../require/database.php';
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'consultant_chat') {


  $query = $_POST['chat_message'];
  $user_id = $_SESSION['user']['user_assign_role_id'];
  $last_id = $_SESSION['consultant_chat_last_id'];

  $insert = "INSERT INTO consultancy_service_chat (consultancy_service_id,chat_message,user_assign_role_id) VALUES ('$last_id','" . htmlspecialchars($query, true) . "','$user_id')";
  $db->_result($insert);

  if ($db->result) {
    echo "ok";
  } else {
    echo "not ok";
  }
}

if (isset($_POST['action']) && $_POST['action'] == 'consultant_rate') {

  $star   = $_POST['star'];
  $msg    = $_POST['feedback'];

  $db->_result("UPDATE consultancy_service SET STATUS ='Complete', rating=$star, feedback='$msg',discussion_end=NOW() WHERE consultancy_service_id=" . $_SESSION['consultant_chat_last_id']);
  if ($db->result) {
    echo 'ok';
  } else {
    echo 'not ok';
  }
}
