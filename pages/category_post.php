<?php

if (isset($_POST['action']) && $_POST['action'] == 'df') {

  require_once '../require/database.php';

$q = "SELECT * FROM post
        INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id 
        INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id 
        INNER JOIN category ON category.category_id=post.category_id 
        INNER JOIN USER ON user.user_id=user_assign_role.user_id 
        WHERE post_type='Discussion Forum'
        AND category.category_id='" . $_POST['id'] . "'
        ORDER BY post.post_id DESC";

  $db->_result($q);
  $res = $db->result;
?>
  <?php
  if ($res->num_rows) {

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
            <p>
            <p><i class="fa fa-clock"> Posted on:
                <?php echo date('h:i a d-M-y', strtotime($time['added_on'])); ?></i></p>
            </p>
          </div>
        </div>
      </div>
  <?php
    }
  }
}



if (isset($_POST['action']) && $_POST['action'] == 'kb') {
  require_once '../require/database.php';

  $q = "SELECT * FROM post
        INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id 
        INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id 
        INNER JOIN category ON category.category_id=post.category_id 
        INNER JOIN USER ON user.user_id=user_assign_role.user_id 
        WHERE post_type='Knowledge Base'
        AND category.category_id='" . $_POST['id'] . "'
        ORDER BY post.post_id DESC";
  $db->_result($q);
  $res = $db->result;
  ?>
  <?php
  if ($res->num_rows) {

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
  }
}
?>