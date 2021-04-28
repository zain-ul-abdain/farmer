<?php
session_start();

if (isset($_REQUEST['action'])) {


  if (isset($_SESSION['cart'][$_REQUEST['id']])) {

    $_SESSION['cart'][$_REQUEST['id']]['quantity'] += $_REQUEST['qty'];
  } else {
    $_SESSION['cart'][$_REQUEST['id']]['quantity'] = 1;
  }


  echo "Product: " . $_REQUEST['id'] . " added to cart";
}
