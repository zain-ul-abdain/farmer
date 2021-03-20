<?php

require_once 'require/database.php';
$q = "SELECT * FROM post 
      INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id 
      INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id 
      INNER JOIN category ON category.category_id=post.category_id 
      INNER JOIN USER ON user.user_id=user_assign_role.user_id 
      WHERE post_type='Knowledge Base' 
      ORDER BY post.post_id DESC";

$db->_result($q);
$res = $db->result;

?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="w3-teal w3-padding-16" align="center">Knowledge Base</h1>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <h2>Latest posts</h2>
      <div class="row">
        <?php
        $db->_result($q);
        $res = $db->result;
        $a = 0;
        while ($post = mysqli_fetch_assoc($res)) {

          $query2  = "SELECT * FROM post_attachment WHERE file_type='image' AND post_id=" . $post['post_id'] . " LIMIT 1";
          $result2 = mysqli_query($db->connection, $query2);
          $rec2 = mysqli_fetch_assoc($result2);

          $db->_result("SELECT added_on FROM post WHERE post_id=" . $post['post_id']);
          $time = mysqli_fetch_assoc($db->result);
          $a++;
          if ($a <= 4) {
        ?>
            <div class="col-3">
              <div class="card">
                <div class="card-body">
                  <div class="card mb-2 bg-gradient-dark">

                    <img style="width: auto;height: 300px; opacity: 0.5;" class="card-img-top" src="<?php echo $rec2['file_name']; ?>" alt="Dist">

                    <div class="card-img-overlay d-flex flex-column justify-content-end">

                      <div>
                        <h5 class="card-title text-primary text-white"><?php echo $post['post_title']; ?></h5>
                        <p class="card-text text-white pb-2 pt-1" style="text-shadow: 2px 2px 1px black;">
                        <p><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?></p>

                        <p><?php echo substr($post['post_summary'], 0, 50); ?>...<a href="#" onclick="_detail(<?php echo $post['post_id']; ?>,1)">Show details</a></p>
                        <p><i class="fa fa-tag"></i> <?php echo $post['category']; ?></p>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        }
        ?>
        <button onclick="_knowledge_base()" class="w3-btn w3-blue">Create Post</button>

      </div>
    </div>
  </section>