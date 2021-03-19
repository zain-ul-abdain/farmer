<?php
  include 'include/head.php';
?>

<!-- JS functions on click -->
<script type="text/javascript" src="script/functions.js"></script>

<div id="content">
  <div class="content-wrapper">
    <div class="container-fluid">


      <div class="row">

        <div class="col-12">
          <h2 align="center" id="msg"><?php echo $_GET['msg'] ?? ''; ?></h2>
          <hr>
        </div>

      </div>

      <div class="row">

        <div class="col-12">
          <div class="w3-panel w3-blue w3-center">
            <h1 class="w3-text-orange" style="text-shadow:1px 1px 0 #444">
              <img style="width: 100px;" src="logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
              <b>Welcome To The Farmer Connection Site</b>
            </h1>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-12">

          <div class="w3-card w3-margin w3-padding">

            <?php include 'slider/main.php'; ?>
          </div>
        </div>
      </div>



    </div>
  </div>

  <div class="w3-card-4 w3-margin">

    <?php include 'pages/kb.php'; ?>
  </div>
  <div class="w3-card-4 w3-margin">

    <?php include 'pages/df.php'; ?>
  </div>


</div>



<?php
include 'include/footer.php';
?>