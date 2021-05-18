<?php
session_start();
require_once '../require/database.php';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_profile') {
  $id = $_REQUEST['id'];

  $db->_result("SELECT *,CONCAT(first_name,' ',last_name) AS 'full_name' FROM user INNER JOIN user_assign_role ON user.user_id=user_assign_role.user_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id WHERE user_assign_role.user_assign_role_id=$id");

  if ($db->result->num_rows) {
    $profile = mysqli_fetch_assoc($db->result);
?>


    <div class="content-wrapper">
      <div class="container-fluid">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Profile</h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle" src="<?php echo $profile['user_image']; ?>" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center"><?php echo $profile['full_name']; ?></h3>

                    <p class="text-muted text-center"><?php echo $profile['user_role']; ?></p>
                    <p class="text-muted text-center"><?php echo "Joined on: " . date("F d, Y", strtotime($profile['added_on'])); ?></p>

                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">About</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                      B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                    <p class="text-muted"><?php echo $profile['address']; ?></p>

                    <hr>

                    <strong><i class="far fa-thumbs-up mr-1"></i> Total # of Likes</strong>

                    <p class="text-muted"><b>
                        <?php
                        $db->_result("SELECT COUNT(*) AS 'likes' FROM post INNER JOIN post_like ON post.post_id=post_like.post_id WHERE post.is_active=1 AND post.user_assign_role_id=$id AND post_like.is_like=1");
                        $likes = mysqli_fetch_assoc($db->result);
                        echo $likes['likes'];
                        ?></b>
                    </p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Total # of Posts</strong>

                    <p class="text-muted"><b>
                        <?php
                        $db->_result("SELECT COUNT(post_id) AS 'total' FROM post WHERE is_active=1 AND user_assign_role_id=$id");
                        $posts = mysqli_fetch_assoc($db->result);
                        echo $posts['total'];
                        ?></b>
                    </p>
                  </div>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="col-sm-6">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">

                      <li class="nav-item active"><a class="nav-link active" href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active" id="settings">

                        <form class="form-horizontal" onsubmit="return false">

                          <p><b>Change Password</b></p>
                          <hr>
                          <div class=" form-group row">
                            <label for="c_password" class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="c_password">
                            </div>
                          </div>
                          <div class=" form-group row">
                            <label for="n_password" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="n_password">
                            </div>
                          </div>
                          <div class=" form-group row">
                            <label for="r_password" class="col-sm-2 col-form-label">Repeat Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="r_password">
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                              <button onclick="update_profile()" class="btn btn-danger">Submit</button>
                            </div>
                          </div>

                        </form>

                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <div class="col-sm-3">
                <div class="card">
                  <div class="card-body">
                    <h2>Latest posts</h2>

                    <?php
                    $query  = "SELECT * FROM post
                              INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id 
                              INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id 
                              INNER JOIN category ON category.category_id=post.category_id 
                              INNER JOIN USER ON user.user_id=user_assign_role.user_id 
                              AND post.is_active=1
                              AND post.post_type='Knowledge Base'
                              AND user_assign_role.user_assign_role_id=$id
                              ORDER BY post.post_id DESC LIMIT 4";
                    $result = mysqli_query($db->connection, $query);
                    if ($result->num_rows) {
                      while ($rec = mysqli_fetch_assoc($result)) {

                        $query2  = "SELECT * FROM post_attachment WHERE file_type='image' AND post_id=" . $rec['post_id'] . " LIMIT 1";
                        $result2 = mysqli_query($db->connection, $query2);
                        $rec2 = mysqli_fetch_assoc($result2);

                    ?>
                        <div class="card mb-2 bg-gradient-dark">

                          <img style="width: auto;height: 280px; opacity: 0.2;" class="card-img-top" src="<?php echo $rec2['file_name']; ?>">

                          <div class="card-img-overlay d-flex flex-column justify-content-end">

                            <div>
                              <h5 class="card-title text-primary text-white"><?php echo $rec['post_title']; ?></h5>
                              <p class="card-text text-white pb-2 pt-1" style="text-shadow: 2px 2px 1px black;">
                              <p><?php echo $rec['first_name'] . " " . $rec['last_name'] . " (" . $rec['user_role'] . ")"; ?></p>

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
                      echo "No Posts Available ..!";
                    }
                    ?>
                  </div>
                </div>
              </div>

              <!-- /.col -->


            </div>


            <!-- /.col -->
          </div>
          <!-- /.row -->
      </div><!-- /.container-fluid -->
      </section>
    </div>
    </div>

<?php
  }
}
?>