<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
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
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

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
      <tfoot>
        <tr class="visible-xs">
          <td class="text-center"><strong>Total 1.99</strong></td>
        </tr>
        <tr>
          <td><a href="../index.php?action=shop" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
          <td colspan="2" class="hidden-xs"></td>
          <td class="hidden-xs text-center"><strong>Total Rs. <?php echo $_SESSION['total'] = $total; ?></strong></td>
          <td>
            <a href="<?php if (isset($_SESSION['user'])) {
                        echo 'checkout.php';
                      } else {
                        echo 'forms/login.php';
                      }
                      ?>" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

<?php } else {
?>
  <h3 class="text-center">Your Cart Is Empty <a href="../index.php?action=shop" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></h3>

<?php
} ?>