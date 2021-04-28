<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <style>
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      vertical-align: middle;
    }

    @media screen and (max-width: 600px) {
      table#cart tbody td .form-control {
        width: 20%;
        display: inline !important;
      }

      .actions .btn {
        width: 36%;
        margin: 1.5em 0;
      }

      .actions .btn-info {
        float: left;
      }

      .actions .btn-danger {
        float: right;
      }

      table#cart thead {
        display: none;
      }

      table#cart tbody td {
        display: block;
        padding: .6rem;
        min-width: 320px;
      }

      table#cart tbody tr td:first-child {
        background: #333;
        color: #fff;
      }

      table#cart tbody td:before {
        content: attr(data-th);
        font-weight: bold;
        display: inline-block;
        width: 8rem;
      }



      table#cart tfoot td {
        display: block;
      }

      table#cart tfoot td .btn {
        display: block;
      }

    }
  </style>

  <style>
    body {
      font-family: Arial;
      font-size: 17px;
      padding: 8px;
    }

    * {
      box-sizing: border-box;
    }

    .row {
      display: -ms-flexbox;
      /* IE10 */
      display: flex;
      -ms-flex-wrap: wrap;
      /* IE10 */
      flex-wrap: wrap;
      margin: 0 -16px;
    }

    .col-25 {
      -ms-flex: 25%;
      /* IE10 */
      flex: 25%;
    }

    .col-50 {
      -ms-flex: 50%;
      /* IE10 */
      flex: 50%;
    }

    .col-75 {
      -ms-flex: 75%;
      /* IE10 */
      flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
      padding: 0 16px;
    }

    .container {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=text] {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btn {
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .btn:hover {
      background-color: #45a049;
    }

    a {
      color: #2196F3;
    }

    hr {
      border: 1px solid lightgrey;
    }

    span.price {
      float: right;
      color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
      .row {
        flex-direction: column-reverse;
      }

      .col-25 {
        margin-bottom: 20px;
      }
    }
  </style>

</head>

<body>

  <h1 class="text-center">Shopping Cart</h1>
  <hr>
  <?php

  require_once '../require/database.php';
  session_start();
  if (isset($_SESSION['cart'])) {
  ?>
    <div class="container">





      <table id="cart" class="table table-hover table-condensed">
        <thead>
          <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
          </tr>
        </thead>
        <tbody>
          <?php



          $total = 0;

          foreach ($_SESSION['cart'] as $key => $value) {

            $db->_result("SELECT * FROM product,product_image WHERE product.product_id=product_image.product_id AND product.is_featured=1 AND product_image.is_main=1 AND product.is_active=1 AND product.product_id=" . $key);
            $cart = mysqli_fetch_assoc($db->result);
          ?>
            <tr>
              <td data-th="Product">
                <div class="row">
                  <div class="col-sm-2 hidden-xs"><img src="../<?php echo $cart['image_path']; ?>" alt="..." class="img-responsive" /></div>
                  <div class="col-sm-10">
                    <h4 class="nomargin"><?php echo $cart['product_title']; ?></h4>
                    <p><?php echo $cart['product_description']; ?></p>
                  </div>
                </div>
              </td>
              <td data-th="Price">Rs. <?php echo $cart['price']; ?></td>
              <td data-th="Quantity">
                <input type="number" class="form-control text-center" value="<?php echo $_SESSION['cart'][$key]['quantity']; ?>">
              </td>
              <td data-th="Subtotal" class="text-center"><?php echo ($cart['price'] * $_SESSION['cart'][$key]['quantity']);
                                                          $total += ($cart['price'] * $_SESSION['cart'][$key]['quantity']); ?></td>
              <td class="actions" data-th="">
                <button class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>

          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <div class="row">
      <div class="col-75">
        <div class="container">
          <form action="<?php if (isset($_SESSION['user'])) {
                          echo 'checkout.php';
                        } else {
                          echo '../forms/login.php';
                        } ?>" method="POST">

            <div class="row">
              <div class="col-50">
                <h3>Billing Address</h3>
                <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                <input type="text" id="fname" name="firstname" placeholder="John M. Doe">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" id="email" name="email" placeholder="john@example.com">

                <label for="phone_number"><i class="fa fa-phone"></i> Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" placeholder="0300-1231231">

                <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
                <label for="city"><i class="fa fa-institution"></i> City</label>
                <input type="text" id="city" name="city" placeholder="New York">

                <div class="row">
                  <div class="col-50">
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" placeholder="NY">
                  </div>
                  <div class="col-50">
                    <label for="zip">Zip</label>
                    <input type="text" id="zip" name="zip" placeholder="10001">
                  </div>
                </div>
              </div>

            </div>
            <label>
              <input id="chkbx" onclick="shipping_address(this.value)" type="checkbox" checked="checked" value="on" name="sameadr"> Shipping address same as billing
            </label>
            <h3>Payment Methods: </h3>
            <input id="cash" checked disabled type="checkbox" value="Cash on delivery" name="cash"> Cash on delivery <br>
            <input disabled id="visa" type="checkbox" value="Visa" name="visa"> Visa <br>
            <input disabled id="master" type="checkbox" value="Master" name="master"> Master <br>
            <div id="shipping_address" class="row" style="display: none;">
              <div class="col-50">
                <h3>Shipping Address</h3>
                <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                <input type="text" id="fname" name="s_firstname" placeholder="John M. Doe">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" id="email" name="s_email" placeholder="john@example.com">

                <label for="phone_number"><i class="fa fa-phone"></i> Phone Number</label>
                <input type="text" id="phone_number" name="s_phone_number" placeholder="0300-1231231">

                <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                <input type="text" id="adr" name="s_address" placeholder="542 W. 15th Street">
                <label for="city"><i class="fa fa-institution"></i> City</label>
                <input type="text" id="city" name="s_city" placeholder="New York">

                <div class="row">
                  <div class="col-50">
                    <label for="state">State</label>
                    <input type="text" id="state" name="s_state" placeholder="NY">
                  </div>
                  <div class="col-50">
                    <label for="zip">Zip</label>
                    <input type="text" id="zip" name="s_zip" placeholder="10001">
                  </div>
                </div>
              </div>

            </div>
            <a href="../index.php?action=shop" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
            <input type="submit" value="Continue to checkout >" class="btn">
          </form>
        </div>
      </div>
    </div>

    <script>
      function shipping_address(value) {

        var a = document.getElementById("chkbx");
        // alert(a.checked);
        if (a.checked) {
          document.getElementById("shipping_address").style.display = "none";

        } else {
          document.getElementById("shipping_address").style.display = "block";

        }
      }
    </script>

</body>

</html>

<?php } else {
?>
  <h3 class="text-center">Your Cart Is Empty <a href="../index.php?action=shop" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></h3>

<?php
  } ?>