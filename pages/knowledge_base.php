<?php

session_start();
if (isset($_POST['action']) && $_POST['action'] == 'knowledge_base') {

  require_once '../require/database.php';
  $con = $db->connection;

  $page_no = $_POST['page_no'];
  $limit = 2;
  $total_records_per_page = $limit;

  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;
  $adjacents = "2";

  $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM post WHERE post_type='Knowledge Base'");
  $total_records = mysqli_fetch_array($result_count);
  $total_records = $total_records['total_records'];
  $total_no_of_pages = $total_records;
  // $total_no_of_pages = ceil($total_records / $total_records_per_page);
  // $second_last = ceil($total_no_of_pages / $limit) - 1; // total pages minus 1

  $q = "SELECT * FROM post
				INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id 
				INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id 
				INNER JOIN category ON category.category_id=post.category_id 
				INNER JOIN USER ON user.user_id=user_assign_role.user_id 
				WHERE post_type='Knowledge Base' 
				ORDER BY post.post_id DESC 
				LIMIT $offset, $total_records_per_page";
  $db->_result($q);
  $res = $db->result;

?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">

        <h1 class="w3-teal w3-padding-16" align="center"> Knowledge Base</h1>
        <div class="row">
          <div class="col-12">
            <div class="w3-bar w3-blue-gray w3-card w3-padding">
              <p>Categories</p>
              <?php
              $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Knowledge_Base' AND parent_category IS NULL");
              if ($db->result->num_rows) {
                while ($c = mysqli_fetch_assoc($db->result)) {
              ?>
                  <a href="#" class="w3-bar-item w3-button w3-text-white" onclick="category_post(<?php echo $c['category_id']; ?>,1)"><?php echo $c['category']; ?></a>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>

        <?php
          if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other') {
          ?>

          <div class="card card-danger direct-chat direct-chat-danger shadow-lg collapsed-card">

            <div class="card-header">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"> Create Post</i>
              </button>
            </div>

            <div class="card-body" style="display: none;">
              <div class="direct-chat-messages" style="height: 470px;">

                <form class="w3-container" action="forms/post_process.php" method="POST" enctype="multipart/form-data">
                  <div id="child"></div>
                  <table class="w3-table">
                    <tbody>
                      <tr>
                        <td>Title</td>
                        <td><input type="text" class="form-control" name="title"></td>
                      </tr>
                      <tr>
                        <td>Summary</td>
                        <td><input type="text" class="form-control" name="summary"></td>
                      </tr>
                      <tr>
                        <td>Description</td>
                        <td><textarea name="desc" class="form-control" cols="30" rows="5"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td>Category</td>
                        <td>
                          <select id="category" class="form-control" name="category" onchange="get_child_category()">
                            <option value="">Select category</option>
                            <option value="1">Rice</option>
                            <option value="3">Fruit</option>
                          </select>
                        </td>
                      </tr>

                      <tr>
                        <td>Attachments </td>
                        <td>
                          <div class="custom-file">
                            <input type="file" name="file[]" class="custom-file-input" id="customFile" multiple="">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center"><input type="submit" class="w3-button w3-green" name="submit" value="POST"></td>
                      </tr>
                    </tbody>
                  </table>
                </form>

              </div>
            </div>
          </div>
        <?php
        }
        ?>

        <div class="row">
          <div class="col-8">
            <div class="card">
              <div class="card-body" id="filter">

                <?php
                if ($res->num_rows) {
                  $c = 0;
                  while ($post = mysqli_fetch_assoc($res)) {
                    $db->_result("SELECT added_on FROM post WHERE post_id=" . $post['post_id']);
                    $time = mysqli_fetch_assoc($db->result);



                ?>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo $post['user_image']; ?>" alt="User Image">
                        <span class="username">
                          <a href="#"><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?></a>
                          <p><i class="fa fa-tag"></i> <?php echo $post['category']; ?> </p>

                        </span>
                      </div>

                      <b>
                        <h4><?php echo $post['post_title']; ?></h4>
                      </b>
                      <p><?php echo substr($post['post_summary'], 0, 80); ?>..<a href="#" onclick="_detail(<?php echo $post['post_id']; ?>)">Show details</a></p>
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <?php
                          $db->_result("SELECT * FROM post_attachment WHERE file_type='image' AND post_id=" . $post['post_id']);
                          if ($db->result->num_rows) {
                            $img = mysqli_fetch_assoc($db->result);
                            $id = $post['post_id'];
                          ?>
                            <img style="width: 400px;height: 300px;" class="img-fluid" src="<?php echo $img['file_name']; ?>" alt="Photo">
                          <?php
                          }
                          ?>
                          <p>
                          <p><i class="fa fa-clock"> Posted on:
                              <?php echo date('h:i a d-M-y', strtotime($time['added_on'])); ?></i></p>
                          </p>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                } else {
                  ?>
                  <h1>No Posts Available come back later..!</h1>
                <?php
                  die();
                }
                ?>


                <!-- Pagination start -->
                <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                  <strong>Page
                    <?php echo $page_no . " of " . ceil($total_no_of_pages / $limit); ?></strong>
                </div>

                <ul class="pagination" align="center">
                  <?php if ($page_no > 1) { ?>

                    <li><a href='#' onclick="_knowledge_base(1)">First Page</a></li>
                  <?php } ?>

                  <li <?php if ($page_no <= 1) {
                        echo "class='disabled'";
                      } ?>>
                    <a <?php if ($page_no > 1) { ?> href='#' onclick="_knowledge_base(<?php echo $previous_page; ?>)" <?php } ?>>
                      Previous</a>
                  </li>

                  <?php

                  if ($total_no_of_pages <= 10) {
                    for ($counter = 1; $counter <= ceil($total_no_of_pages / $limit); $counter++) {
                      if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                      } else { ?>
                        <li><a href='#' onclick="_knowledge_base(<?php echo $counter; ?>)"><?php echo $counter; ?></a>
                        </li>
                  <?php
                      }
                    }
                  } elseif (ceil($total_no_of_pages / $limit) > 10) {
                    // Here we will add further conditions
                  }

                  ?>

                  <li <?php if ($page_no >= ceil($total_no_of_pages / $limit)) {
                        echo "class='disabled'";
                      } ?>>
                    <a <?php if ($page_no < ceil($total_no_of_pages / $limit)) { ?> href='#' onclick="_knowledge_base(<?php echo $next_page; ?>)" <?php } ?>>Next</a>
                  </li>

                  <?php if ($page_no < ceil($total_no_of_pages / $limit)) { ?>

                    <li><a href='#' onclick="_knowledge_base(<?php echo ceil($total_no_of_pages / $limit); ?>)">Last
                        &rsaquo;&rsaquo;</a></li>
                  <?php } ?>
                </ul>
                <!-- Pagination End -->


              </div>
            </div>
          </div>

          <!-- Latest posts -->


          <div class="col-3">
            <div class="card">
              <div class="card-body">
                <h2>Latest posts</h2>

                <?php
                $query  = "SELECT * FROM post
                              INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id 
                              INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id 
                              INNER JOIN category ON category.category_id=post.category_id 
                              INNER JOIN USER ON user.user_id=user_assign_role.user_id 
                              WHERE post_type='Knowledge Base' 
                              ORDER BY post.post_id DESC LIMIT 4";
                $result = mysqli_query($db->connection, $query);
                if ($result->num_rows) {
                  while ($rec = mysqli_fetch_assoc($result)) {

                    $query2  = "SELECT * FROM post_attachment WHERE file_type='image' AND post_id=" . $rec['post_id'] . " LIMIT 1";
                    $result2 = mysqli_query($db->connection, $query2);
                    $rec2 = mysqli_fetch_assoc($result2);

                ?>
                    <div class="card mb-2 bg-gradient-dark">

                      <img style="width: auto;height: 300px;" class="card-img-top" src="<?php echo $rec2['file_name']; ?>" alt="Dist">

                      <div class="card-img-overlay d-flex flex-column justify-content-end">

                        <div style="text-shadow: 1px 1px 2px black">
                          <h5 class="card-title text-primary text-white"><?php echo $rec['post_title']; ?></h5>
                          <p class="card-text text-white pb-2 pt-1">
                          <p><?php echo substr($rec['post_summary'], 0, 50); ?>...<a href="#" onclick="_detail(<?php echo $rec['post_id']; ?>,1)">Show details</a></p>
                          <p><i class="fa fa-tag"></i> <?php echo $rec['category']; ?></p>
                          </p>
                        </div>
                      </div>
                    </div>

                  <?php
                  }
                  ?>

                <?php
                } else {
                ?>
                  <div class="card mb-2 bg-gradient-dark">

                    <img style="width: auto;height: 300px;" class="card-img-top" src="" alt="bist">

                    <div class="card-img-overlay d-flex flex-column justify-content-end">

                      <div style="text-shadow: 1px 1px 2px black">
                        <h5 class="card-title text-primary text-white"></h5>
                        <p class="card-text text-white pb-2 pt-1">

                        <p></p>
                        <p><i class="fa fa-tag"></i></p>
                        </p>
                      </div>
                    </div>
                  </div>

                <?php
                }
                ?>



              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div><!-- /.container-fluid -->
  <!-- /.content -->

<?php } ?>