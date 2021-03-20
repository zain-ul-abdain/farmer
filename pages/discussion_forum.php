<?php
session_start();
if (isset($_POST['action']) && $_POST['action'] == 'discussion_forum') {
  require_once '../require/database.php';
  $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=post.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Discussion Forum' ORDER BY post.post_id DESC ";
  $db->_result($q);
  $res = $db->result;

?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1 class="w3-teal w3-padding-16" align="center">Discussion Forum</h1>
        <div class="row">
          <div class="col-12">
            <div class="w3-bar w3-blue-gray w3-card w3-padding">
              <p>Categories</p>
              <?php
              $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Discussion_Forum' AND parent_category IS NULL");
              if ($db->result->num_rows) {
                while ($c = mysqli_fetch_assoc($db->result)) {
              ?>
                  <a href="#" class="w3-bar-item w3-button w3-text-white" onclick="category_post(<?php echo $c['category_id']; ?>,2)"><?php echo $c['category']; ?></a>
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
                          <select id="category" class="form-control" name="category" onchange="get_child_category()">
                            <option value="">Select category</option>
                            <option value="1">Rice</option>
                          </select>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="2" align="center"><input type="submit" class="w3-button w3-green" name="discussion" value="POST"></td>
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


      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">

          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">

              <div class="card-body" id="filter">
                <?php
                if ($res->num_rows) {
                  while ($post = mysqli_fetch_assoc($res)) {
                ?>
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo $post['user_image']; ?>" alt="User Image">
                        <span class="username">
                          <a href="#"><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?></a>
                          <p><i class="fa fa-tag"></i> <?php echo $post['category']; ?></p>
                        </span>
                        <span class="description"><?php echo $post['added_on']; ?></span>
                      </div>
                      <b>
                        <h4><?php echo $post['post_title']; ?></h4>
                      </b>
                      <p><?php echo $post['post_summary']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id']; ?>,2)">Show more</a></p>
                      <div class="row mb-3">
                      </div>
                    </div>
                <?php
                  }
                } else {
                  echo "<h1>No Threads available</h1>";
                }
                ?>
              </div>
            </div>
          </div>

          <div class="col-3">
            <div class="card">
              <div class="card-body">
                <h2>Latest posts</h2>
                <?php
                $db->_result($q);
                $a = 0;
                if ($db->result->num_rows) {


                  while ($post = mysqli_fetch_assoc($db->result)) {
                    $a++;
                    if ($a <= 4) {
                ?>
                      <div class="card mb-2 bg-gradient-dark">

                        <img style="width: auto;height: 300px;" class="card-img-top" src="images/b.jpg" alt="Dist Photo 1">

                        <div class="card-img-overlay d-flex flex-column justify-content-end">

                          <div style="text-shadow: 1px 1px 2px black;">
                            <h5 class="card-title text-primary text-white">
                              <?php echo $post['post_title']; ?></h5>
                            <p class="card-text text-white pb-2 pt-1">
                              <?php echo $post['post_summary']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id']; ?>)">Show more</a>

                            <p class="text-white"><?php echo date("h:i:s d/m/y", $post['added_on']); ?></p>

                            <p><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?>
                            </p>
                            <p><i class="fa fa-tag"></i> <?php echo "Category : " . $post['category']; ?>
                            </p>
                            </p>
                          </div>
                        </div>
                      </div>
                <?php
                    }
                  }
                } else {
                  echo "<h3>Not available</h3>";
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php
}
?>