<?php 

  session_start();
  require_once '../require/database.php';
?>
<style>

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>

       <h2>Add Product</h2>
            <div class="container">
              <form action="forms/product_process.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-25">
                  <label for="fname">Product Title</label>
                </div>
                <div class="col-75">
                  <input type="text" id="fname" name="p_title" placeholder="Product Title">
                </div>
              </div>
              <div class="row">
                <div class="col-25">
                  <label for="lname">Description</label>
                </div>
                <div class="col-75">
                  <input type="text" id="lname" name="p_desc" placeholder="Product Description">
                </div>
              </div>
              <div class="row">
                <div class="col-25">
                  <label for="price">Price</label>
                </div>
                <div class="col-75">
                  <input type="number" id="price" class="form-control" name="price" placeholder="Price">
                </div>
              </div>
              <div class="row">
                <div class="col-25">
                  <label for="qty">Quantity</label>
                </div>
                <div class="col-75">
                  <input type="number" id="qty" class="form-control" name="quantity" placeholder="Quantity">
                </div>
              </div>
              <div class="row">
                <div class="col-25">
                  <label for="country">Category</label>
                </div>
                <div class="col-75">
                  <select id="category" class="form-control" name="category">
                <option value="">Select category</option>
                <?php 
                  $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='E-Commerce' AND parent_category IS NULL");
                    $a = $db->result;
                    while ($category = mysqli_fetch_assoc($db->result)) {
                      ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category']; ?></option>
                      <?php
                    }

                ?>
              </select>
                </div>
              </div>
              <div class="row">
                <div class="col-25">
                  <label for="subject">Subject</label>
                </div>
                <div class="col-75">
                  <input class="w3-input" type="file" name="file[]" multiple>
                </div>
              </div>
              <div class="row">
                <input type="submit" value="Add Product">
              </div>
              </form>
            </div>