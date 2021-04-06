<?php

session_start();
if (isset($_POST['action']) && $_POST['action'] == 'discussion_forum') {

  require_once '../require/database.php';
  $con = $db->connection;

  $page_no = $_POST['page_no'];
  $limit = 2;
  $total_records_per_page = $limit;

  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;
  $adjacents = "2";

  $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM post WHERE post_type='Discussion Forum'");
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
				WHERE post_type='Discussion Forum' 
        AND post.is_active=1
				ORDER BY post.post_id DESC 
				LIMIT $offset, $total_records_per_page";
  $db->_result($q);
  $res = $db->result;

?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Discussion Forum</h1>
              </div>

            </div>
          </div><!-- /.container-fluid -->
        </section>
        <div class="row">
          <div class="col-12">
            <div class="w3-bar w3-card w3-padding">
              <p>Categories</p>
              <?php
              $db->_result("SELECT * FROM category 
                            INNER JOIN category_assign ON category.category_id=category_assign.category_id 
                            WHERE category_assign.post_type='discussion_forum' 
                            AND parent_category IS NULL");
              if ($db->result->num_rows) {
                while ($c = mysqli_fetch_assoc($db->result)) {
              ?>
                  <a href="#" class="w3-bar-item w3-button" onclick="category_post(<?php echo $c['category_id']; ?>,2)"><?php echo $c['category']; ?></a>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>

        <?php
        if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other' && $_SESSION['user']['user_role'] != 'Consultant') {
        ?>

          <div class="card direct-chat direct-chat-danger shadow-lg collapsed-card">

            <div class="card-header">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"> Create Thread</i>
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
                          <select name="category" id="cat" class="form-control">
                            <option value="">Select Category</option>
                            <?php
                            $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='discussion_forum' AND parent_category IS NULL");
                            if ($db->result->num_rows) {
                              while ($set = mysqli_fetch_assoc($db->result)) {
                            ?>
                                <option value="<?php echo $set['category_id']; ?>"><?php echo $set['category']; ?></option>
                              <?php
                              }
                            } else {
                              ?>
                              <option value="">No Category</option>
                            <?php
                            }
                            ?>
                          </select>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="2" align="center"><input type="submit" class="w3-button w3-green" name="discussion" value="POST"></td>
                        </t>
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
          <div class="col-9">
            <div class="card">
              <div class="card-body" id="filter">

                <?php
                $db->_result($q);
                if ($db->result->num_rows) {
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
                      <p><?php echo substr($post['post_summary'], 0, 80); ?>..<a href="#" onclick="_detail(<?php echo $post['post_id']; ?>,2)">Show details</a></p>
                      <div class="row mb-3">
                        <div class="col-sm-6">
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

                    <li><a href='#' onclick="_discussion_forum(1)">First Page</a></li>
                  <?php } ?>

                  <li <?php if ($page_no <= 1) {
                        echo "class='disabled'";
                      } ?>>
                    <a <?php if ($page_no > 1) { ?> href='#' onclick="_discussion_forum(<?php echo $previous_page; ?>)" <?php } ?>>
                      Previous</a>
                  </li>

                  <?php

                  if ($total_no_of_pages <= 10) {
                    for ($counter = 1; $counter <= ceil($total_no_of_pages / $limit); $counter++) {
                      if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                      } else { ?>
                        <li><a href='#' onclick="_discussion_forum(<?php echo $counter; ?>)"><?php echo $counter; ?></a>
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
                    <a <?php if ($page_no < ceil($total_no_of_pages / $limit)) { ?> href='#' onclick="_discussion_forum(<?php echo $next_page; ?>)" <?php } ?>>Next</a>
                  </li>

                  <?php if ($page_no < ceil($total_no_of_pages / $limit)) { ?>

                    <li><a href='#' onclick="_discussion_forum(<?php echo ceil($total_no_of_pages / $limit); ?>)">Last
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
                              WHERE post_type='Discussion Forum' 
                              AND post.is_active=1
                              ORDER BY post.post_id DESC LIMIT 4";
                $result = mysqli_query($db->connection, $query);
                if ($result->num_rows) {
                  while ($rec = mysqli_fetch_assoc($result)) {

                ?>
                    <div class="card mb-2 bg-gradient-dark">

                      <img style="width: auto;height: 300px;" class="card-img-top" src="https://i.pinimg.com/originals/af/8d/63/af8d63a477078732b79ff9d9fc60873f.jpg" alt="Dist">

                      <div class="card-img-overlay d-flex flex-column justify-content-end">

                        <div style="text-shadow: 1px 1px 2px black">
                          <h5 class="card-title text-primary text-white"><?php echo $rec['post_title']; ?></h5>
                          <p class="card-text text-white pb-2 pt-1">
                          <p><?php echo $rec['first_name'] . " " . $rec['last_name']; ?></p>
                          <p><?php echo substr($rec['post_summary'], 0, 50); ?>...<a href="#" onclick="_detail(<?php echo $rec['post_id']; ?>,2)">Show details</a></p>
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