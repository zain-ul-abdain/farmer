<?php
if (isset($_POST['action']) && $_POST['action'] == 'detail') {
  session_start();
  require_once '../require/database.php';
  $id = $_POST['post_id'];
  if ($_POST['num'] == 2) {
    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Discussion Forum' AND post.post_id=$id ORDER BY post.post_id DESC";
  } else {

    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Knowledge Base' AND post.post_id=$id ORDER BY post.post_id DESC";
  }
  $db->_result($q);
  $res = $db->result;

  $a = ($_POST['num'] == 2) ? 2 : 1;

?>
  <!-- Post -->
  <style type="text/css">
    a[href $=".ppt"]::before,
    a[href $=".pptx"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/ppt.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".xls"]::before,
    a[href $=".xlsx"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/excel.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".doc"]::before,
    a[href $=".docx"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/word.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".zip"]::before,
    a[href $=".rar"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/doc.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".pdf"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/pdf.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }
  </style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php
            if ($_POST['num'] == 2) {
            ?>
              <h1>Discussion Forum</h1>
            <?php
            } else {
            ?>
              <h1>Knowledge Base</h1>
            <?php
            }
            ?>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div id="display_box" style="display: none;">
          <div class="row">

            <div class="col-9" style="position: absolute;">
              <div class="card card-widget">
                <div class="card-header">
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button onclick="_close()" type="button" class="btn btn-tool">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <img id="img_box" src="https://dummyimage.com/vga">
                </div>
              </div>
            </div>

          </div>
        </div>
        <?php
        if ($res->num_rows) {

          while ($post = mysqli_fetch_assoc($res)) {
            // print_r($post);
            // $time = "SELECT added_on FROM post WHERE post_id=".$post['post_id'];
            // $r = mysqli_query($db->connection,$time);
            // $t = mysqli_fetch_assoc($r);
            // $t = date('h:i',$t['added_on']);
            // echo time();
            // $query = "SELECT count(file_type) FROM user_assign_role_id WHERE post_id='".$post['post_id']."' AND file_type='picture'";
            // $result = mysqli_query($db->connection,$query);
            // $pics = mysqli_fetch_assoc($result);
        ?>
            <div id="blur" class="row">
              <div <?php if ($_POST['num'] != 2) {
                      echo "class='col-6'";
                    } else {
                      echo "class='col-12'";
                    } ?>>
                <!-- Box Comment -->
                <div class="card card-widget">
                  <div class="card-header">
                    <div class="user-block">
                      <img class="img-circle" src="<?php echo $post['user_image']; ?>" alt="User Image">
                      <span class="username"><a href="#"><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?></a></span>
                      <span class="description">Shared publicly - 7:30 PM Today</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- post text -->
                    <p><b><?php echo $post['post_title']; ?></b></p>

                    <p><?php echo $post['post_summary']; ?></p>

                    <h4>Description</h4>
                    <p><?php echo $post['post_description']; ?></p>

                    <!-- Social sharing buttons -->
                    <?php
                    if (isset($_SESSION['user'])) {
                      $query55 = "SELECT * FROM post_like WHERE is_like='1' AND post_id='" . $post['post_id'] . "' AND user_assign_role_id=" . $_SESSION['user']['user_assign_role_id'];
                      $db->_result($query55);
                      if ($db->result->num_rows) {
                    ?>
                        <button style="color: blue;" type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Liked</button>
                      <?php
                      } else {
                      ?>
                        <button id="like" onclick="_like(<?php echo $id; ?>,<?php echo $_SESSION['user']['user_assign_role_id']; ?>,<?php echo $a; ?>)" type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                    <?php

                      }
                    }

                    $qw = "SELECT count(post_like_id) AS 'likes' FROM post_like WHERE is_like=1 AND post_id=" . $post['post_id'];
                    $db->_result($qw);
                    $like = mysqli_fetch_assoc($db->result);
                    $qw = "SELECT count(post_reply_id) AS 'comments' FROM post_reply WHERE post_id=" . $post['post_id'];
                    $db->_result($qw);
                    $comment = mysqli_fetch_assoc($db->result);
                    ?>
                    <span class="float-right text-muted"><?php echo $like['likes'] . " likes - ";
                                                          echo $comment['comments'] . " comments"; ?></span>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer card-comments">
                    <?php
                    $db->_result("SELECT * FROM post_reply INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=post_reply.user_assign_role_id INNER JOIN user ON user.user_id=user_assign_role.user_id WHERE post_reply.is_approved=1 AND post_reply.post_id=$id");
                    if ($db->result->num_rows) {
                      while ($comment = mysqli_fetch_assoc($db->result)) {
                    ?>
                        <div class="card-comment">
                          <!-- User image -->
                          <img class="img-circle img-sm" src="<?php echo $comment['user_image']; ?>" alt="User Image">

                          <div class="comment-text">
                            <span class="username">
                              <?php echo $comment['first_name']; ?>
                              <span class="text-muted float-right"><?php echo $comment['added_on']; ?></span>
                            </span><!-- /.username -->
                            <?php echo $comment['message']; ?>
                          </div>
                          <!-- /.comment-text -->
                        </div>
                    <?php
                      }
                    }
                    ?>
                    <!-- /.card-comment -->
                  </div>

                  <?php
                  if (isset($_SESSION['user'])) {
                  ?>
                    <div class="card-footer">
                      <img class="img-fluid img-circle img-sm" src="<?php echo $_SESSION['user']['user_image']; ?>" alt="Alt Text">
                      <div class="input-group-append">
                        <div class="input-group">
                          <div class="img-push">
                            <input id="comment" type="text" class="form-control" placeholder="Post your comment here ..!">
                          </div>
                          <button onclick="_comment(<?php echo $id; ?>,<?php echo $_SESSION['user']['user_assign_role_id']; ?>,<?php echo $a; ?>)" class="btn btn-danger">Send</button>
                        </div>
                      </div>
                    </div>

                  <?php
                  }
                  ?>
                  <!-- /.card-footer -->
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <?php
              if ($_POST['num'] != 2) {
              ?>
                <div class="col-6">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="mt-5 ">Post Attachments</h4>
                      <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">

                        <li class="nav-item active">
                          <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Images</a>
                        </li>

                        <li class="nav-item">
                          <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Audio</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-content-above-messages-tab" data-toggle="pill" href="#custom-content-above-messages" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">Video</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="custom-content-above-settings-tab" data-toggle="pill" href="#custom-content-above-settings" role="tab" aria-controls="custom-content-above-settings" aria-selected="false">Documents</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="custom-content-above-tabContent">
                        <div class="tab-pane fade active in show" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                          <?php
                          $query1   = "SELECT * FROM post_attachment WHERE file_type='image' AND post_id = $id";
                          $result1  = mysqli_query($db->connection, $query1);

                          if ($result1->num_rows) {
                            while ($img = mysqli_fetch_assoc($result1)) {
                          ?>
                              <img onclick="light_box(this)" style="width: 150px;height: 150px;" src="<?php echo $img['file_name']; ?>">
                          <?php
                            }
                          }

                          ?>
                        </div>
                        <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                          <?php
                          $query1   = "SELECT * FROM post_attachment WHERE file_type='audio' AND post_id = $id";
                          $result1  = mysqli_query($db->connection, $query1);

                          if ($result1->num_rows) {
                            $a = 0;
                            while ($img = mysqli_fetch_assoc($result1)) {
                              $a++;
                          ?>
                              <br>
                              <audio controls>
                                <source src="<?php echo $img['file_name']; ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                              </audio>
                          <?php
                            }
                          }

                          ?>
                        </div>
                        <div class="tab-pane fade" id="custom-content-above-messages" role="tabpanel" aria-labelledby="custom-content-above-messages-tab">
                          <?php
                          $query1   = "SELECT * FROM post_attachment WHERE file_type='video' AND post_id = $id";
                          $result1  = mysqli_query($db->connection, $query1);

                          if ($result1->num_rows) {
                            $a = 0;
                            while ($img = mysqli_fetch_assoc($result1)) {
                              $a++;
                          ?>
                              <video width="320" height="240" controls>
                                <source src="<?php echo $img['file_name']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                              </video>
                          <?php
                            }
                          }

                          ?>
                        </div>
                        <div class="tab-pane fade" id="custom-content-above-settings" role="tabpanel" aria-labelledby="custom-content-above-settings-tab">
                          <?php
                          $query1   = "SELECT * FROM post_attachment WHERE file_type='application' AND post_id = $id";
                          $result1  = mysqli_query($db->connection, $query1);

                          if ($result1->num_rows) {
                            $a = 0;
                            while ($img = mysqli_fetch_assoc($result1)) {
                              $a++;
                          ?>
                              <br>
                              <a href="<?php echo $img['file_name']; ?>"><?php echo "Document_" . $a; ?></a>
                          <?php
                            }
                          }

                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>

            </div>
        <?php
          }
        }
        ?>
        <!-- /.row -->





      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php } ?>