<?php

session_start();
require_once '../require/database.php';

if (isset($_POST['submit'])) {

  $id       = $_SESSION['user']['user_assign_role_id'];
  $user_id    = $_SESSION['user']['user_id'];
  $category_id   = $_POST['category'];
  $title       = $_POST['title'];
  $summary     = $_POST['summary'];
  $desc       = $_POST['desc'];
  $post_type     = 'Knowledge Base';

  $db->_result("INSERT INTO post(category_id,user_assign_role_id,post_title,post_summary,post_description,post_type) VALUES('$category_id','$id','" . htmlspecialchars($title, true) . "','" . htmlspecialchars($summary, true) . "','" . htmlspecialchars($desc, true) . "','$post_type')");
  echo "Last id = " . $last_id = mysqli_insert_id($db->connection);

  if ($db->result) {

    if (isset($_FILES['file'])) {

      $file = $_FILES['file'];
      $count = 0;
      echo "mkdir = " . mkdir("../uploads/$last_id");

      foreach ($_FILES['file']['name'] as $key => $value) {

        $arr = explode("/", $file['type'][$key]);
        $file_type = $arr[0];
        $file_name = "uploads/$last_id/" . $_FILES['file']['name'][$key];
        $tmp_name = $_FILES['file']['tmp_name'][$key];

        if (move_uploaded_file($tmp_name, "../" . $file_name)) {
          $count++;
          $insert = "INSERT INTO post_attachment(post_id,file_name,file_type) VALUES('$last_id','$file_name','$file_type')";
          $db->_result($insert);
          echo "Image uploaded";
        }
      }
      header("location:../index.php?action=blog&msg=Post updated Successfully ..! $count files uploaded");
      exit();
    } else {
      header("location:../index.php?action=blog&msg=Post updated Successfully ..!");
      exit();
    }
  } else {
    echo "Post not added";
    header('location:../index.php?action=blog&msg=Post not updated ..!');
    exit();
  }
}

// Discussion Forum
if (isset($_POST['discussion'])) {

  echo "<pre>";
  print_r($_POST);

  $id       = $_SESSION['user']['user_assign_role_id'];
  $user_id    = $_SESSION['user']['user_id'];
  $category_id   = $_POST['category'];
  $title       = $_POST['title'];
  $summary     = $_POST['summary'];
  $desc       = $_POST['desc'];
  $post_type     = 'Discussion Forum';
  echo $q = "INSERT INTO post(category_id,user_assign_role_id,post_title,post_summary,post_description,post_type) 
  VALUES('$category_id','$id','" . htmlspecialchars($title, true) . "','" . htmlspecialchars($summary, true) . "','" . htmlspecialchars($desc, true) . "','$post_type')";
  $db->_result($q);

  if ($db->result) {

    header("location:../index.php?action=blog&msg=Post updated Successfully ..!");
    exit();
  } else {

    header('location:../index.php?action=blog&msg=Post not updated ..!');
    exit();
  }
}
