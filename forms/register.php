<?php
require_once '../require/database.php';

$db->_select("country");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farmer connection | Registration Page</title>

  <!-- W3 CSS -->
  <link rel="stylesheet" type="text/css" href="../css/w3.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <script type="text/javascript">
    if (window.location == "http://localhost/11100/Farmer/Project/forms/register.php?msg=Registration%20Successfull..!") {
      var txt;
      var r = confirm("Registration success. Login Now?");
      if (r == true) {
        txt = "You pressed OK!";
        window.location = "login.php";
      } else {
        txt = "You pressed Cancel!";
      }
    }

    function get_State(obj) {

      var country = obj.value;
      var aj;
      if (window.XMLHttpRequest) {
        aj = new XMLHttpRequest();
      } else {
        aj = new ActiveXObject("Microsoft.XMLHTTP");
      }

      aj.onreadystatechange = function() {

        if (aj.readyState == 4 && aj.status == 200) {
          document.getElementById('state').innerHTML = aj.responseText;
        }
      }

      aj.open("POST", "reg_process.php");
      aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      aj.send("action=state&country=" + country);
    }

    function get_City(obj) {

      var city = obj.value;
      var aj;
      if (window.XMLHttpRequest) {
        aj = new XMLHttpRequest();
      } else {
        aj = new ActiveXObject("Microsoft.XMLHTTP");
      }

      aj.onreadystatechange = function() {

        if (aj.readyState == 4 && aj.status == 200) {
          document.getElementById('city').innerHTML = aj.responseText;
        }
      }

      aj.open("POST", "reg_process.php");
      aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      aj.send("action=city&city=" + city);
    }

    function consultant_category(role) {

      if (role == 4) {
        var aj;
        if (window.XMLHttpRequest) {
          aj = new XMLHttpRequest();
        } else {
          aj = new ActiveXObject("Microsoft.XMLHTTP");
        }

        aj.onreadystatechange = function() {

          if (aj.readyState == 4 && aj.status == 200) {
            document.getElementById('consultant_type').innerHTML = aj.responseText;
            // alert(aj.responseText);
          }
        }

        aj.open("POST", "reg_process.php");
        aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        aj.send("action=role&role_id=" + role);
      }
    }
  </script>
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../index.php" class="h2"><b>Farmer</b>Connection</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="reg_process.php" method="post" enctype="multipart/form-data">

          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <input type="text" name="first_name" class="form-control" placeholder="First name">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <input type="text" name="last_name" class="form-control" placeholder="Last name">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <input type="email" name="email" class="form-control" placeholder="Email">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Password">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <input type="password" name="confirm_password" class="form-control" placeholder="Retype password">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
            <input type="text" name="number" class="form-control" placeholder="Phone Number">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-address-card"></span>
              </div>
            </div>
            <input type="text" name="address" class="form-control" placeholder="Address">
          </div>

          <div class="form-group">

            <select name="expert" class="form-control select2" style="width: 100%;" required>
              <option value="">Select Level</option>
              <option>Beginner</option>
              <option>Intermediate</option>
              <option>Expert</option>
            </select>
          </div>

          <div class="form-group">

            <select name="role_id" onchange="consultant_category(this.value)" class="form-control select2" style="width: 100%;" required>
              <option value="">Select Role Type</option>
              <?php
              $query = "SELECT * FROM user_role";
              $res = mysqli_query($db->connection, $query);
              if ($res->num_rows) {
                while ($role = mysqli_fetch_assoc($res)) {
                  if ($role['user_role'] == "Admin") {
                    continue;
                  }
              ?>
                  <option value="<?php echo $role['user_role_id']; ?>"><?php echo $role['user_role']; ?></option>
              <?php

                }
              }
              ?>
            </select>
          </div>
          <div id="consultant_type"></div>

          <div class="form-group">

            <select name="country" class="form-control select2" style="width: 100%;" required onchange="get_State(this)">

              <option value="">Select Country</option>
              <?php
              if ($db->result->num_rows) {
                while ($city = mysqli_fetch_assoc($db->result)) {
              ?>
                  <option value="<?php echo $city['country_name'] ?>"><?php echo $city['country_name']; ?></option>

              <?php
                }
              } else {
                die("OK");
              }
              ?>
            </select>
          </div>
          <div id="state"></div>
          <div id="city"></div>

          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-file-image"></span>
                <input type="file" name="picture" class="w3-input">
              </div>
            </div>
          </div>

          <div class="row">

            <!-- /.col -->
            <div class="col-12">
              <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>





        </form>



        <a href="login.php" class="text-center">I already have an account ( Login )</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>