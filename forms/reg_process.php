<?php
require_once '../require/database.php';

if (isset($_POST['action']) && $_POST['action'] == "state") {
  $db->_result("SELECT * FROM state INNER JOIN country ON country.country_id=state.country_id WHERE country.country_name='" . $_POST['country'] . "'");
?>
  <div class="form-group">

    <select name="state" class="form-control select2" style="width: 100%;" required onchange="get_City(this)">

      <option value="">Select State</option>
      <?php
      if ($db->result->num_rows) {
        while ($state = mysqli_fetch_assoc($db->result)) {
          print_r($state);
      ?>
          <option><?php echo $state['state_name']; ?></option>

      <?php
        }
      } else {
        die("OK");
      }
      ?>
    </select>
  </div>
<?php
}


if (isset($_POST['action']) && $_POST['action'] == "city") {
  $db->_result("SELECT * FROM city INNER JOIN state ON state.state_id=city.state_id WHERE state.state_name='" . $_POST['city'] . "'");
?>
  <div class="form-group">

    <select name="city" class="form-control select2" style="width: 100%;" required>

      <option value="">Select State</option>
      <?php
      if ($db->result->num_rows) {
        while ($state = mysqli_fetch_assoc($db->result)) {
          print_r($state);
      ?>
          <option value="<?php echo $state['city_id']; ?>"><?php echo $state['city_name']; ?></option>

      <?php
        }
      } else {
        die("OK");
      }
      ?>
    </select>
  </div>
  <?php
}
if (isset($_POST['register'])) {
  echo "<pre>";
  print_r($_POST);
  print_r($_FILES);
  if (move_uploaded_file($_FILES['picture']['tmp_name'], "../images/" . $_FILES['picture']['name'])) {
    echo "Picture Uploaded";
    if (isset($_POST['category'])) {
      # code...
    }
    $db->_register($_POST['first_name'], $_POST['last_name'], $_POST['email'], hash("md5", $_POST['password']), "images/" . $_FILES['picture']['name'], $_POST['city'], $_POST['expert'], $_POST['number'], $_POST['address'],$_POST['category']);
    if ($db->result) {
      echo "User Registered";
      $insert = "INSERT INTO user_assign_role(user_id,user_role_id) VALUES('" . $db->last_id . "','" . $_POST['role_id'] . "')";
      $res = mysqli_query($db->connection, $insert);
      if ($res) {
        echo "Role Inserted";
        // header("location:register.php?msg=Registration Successfull..!");
      } else {
        // header("location:register.php?msg=Role not inserted");
        echo "Role not Inserted";
      }
    } else {
      echo "User not Registered";
      // header("location:register.php?msg=Registration Failed");
    }
  } else {
    echo "image not uploaded";
    // header("location:register.php?msg=Image not uploaded");
  }
}


if (isset($_POST['action']) && $_POST['action'] == "role") {
  $db->_result("SELECT * FROM category_assign INNER JOIN category ON category.category_id=category_assign.category_id WHERE post_type='Consultancy'");

  if ($db->result->num_rows) {
  ?>
    <div class="form-group">
      <select name="category" name="category" id="category" class="form-control select2" required>
        <option value="">Select Consultancy Type</option>
        <?php
        while ($rec = mysqli_fetch_assoc($db->result)) {
        ?>
          <option value="<?php echo $rec['category_id']; ?>"><?php echo $rec['category']; ?></option>
        <?php
        }
        ?>
      </select>
    </div>
<?php
  }
}



?>