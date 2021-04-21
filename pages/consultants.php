<?php
if (isset($_POST['action']) && $_POST['action'] == 'consultant') {
  session_start();
  require_once '../require/database.php';
?>
  <script type="text/javascript">
    document.getElementById('consultant').className += ' active';
    // document.getElementById('consultant').setAttribute(class,'nav-link active');
  </script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consultants</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
            <?php
            $db->query = "SELECT * FROM USER INNER JOIN category ON category.category_id=user.category_id INNER JOIN user_assign_role ON user.user_id=user_assign_role.user_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id WHERE user.is_approved=1 AND user.is_active=1 AND user_role.user_role='Consultant'";
            $db->result = mysqli_query($db->connection, $db->query);
            if ($db->result->num_rows) {
              $res = $db->result;
              while ($consultant = mysqli_fetch_assoc($res)) {

                $db->_result("SELECT AVG(rating) AS 'Stars' FROM consultancy_service WHERE consultant=" . $consultant['user_assign_role_id']);
                if ($db->result->num_rows) {
                  $stars = mysqli_fetch_assoc($db->result);
                }

                if (isset($_SESSION['user']) && $consultant['user_id'] == $_SESSION['user']['user_id']) {
                  continue;
                }
            ?>

                <style type="text/css">
                  .rate {
                    float: left;
                    height: 46px;
                    padding: 0 10px;
                  }

                  .rate:not(:checked)>input {
                    position: absolute;
                    top: -9999px;
                  }

                  .rate:not(:checked)>label {
                    float: right;
                    width: 1em;
                    overflow: hidden;
                    white-space: nowrap;
                    cursor: pointer;
                    font-size: 30px;
                    color: #ccc;
                  }

                  .rate:not(:checked)>label:before {
                    content: '★ ';
                  }

                  .rate>input:checked~label {
                    color: #ffc700;
                  }
                </style>


                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                      <?php echo $consultant['expert_level']; ?>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b><?php echo $consultant['first_name']; ?></b></h2>
                          <p class="text-muted text-sm"><b>Consultancy Category: </b> <?php echo $consultant['category']; ?> </p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: <?php echo $consultant['address']; ?></li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $consultant['phone_number']; ?></li>
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <img style="width: 200px; height: 150px;" src="<?php echo $consultant['user_image']; ?>" alt="user-avatar" class="img-circle img-fluid">
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="text-right">


                        <i style="float: left;">
                          <div class="comment-form-rating">
                            <div class="rate">
                              <input type="radio" id="star5" name="rate<?php echo $consultant['user_id']; ?>" value="5" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 5) {
                                                                                                                          echo 'checked';
                                                                                                                        } ?> disabled />
                              <label for="star5" title="text">5 stars</label>
                              <input type="radio" id="star4" name="rate<?php echo $consultant['user_id']; ?>" value="4" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 4) {
                                                                                                                          echo 'checked';
                                                                                                                        } ?> disabled />
                              <label for="star4" title="text">4 stars</label>
                              <input type="radio" id="star3" name="rate<?php echo $consultant['user_id']; ?>" value="3" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 3) {
                                                                                                                          echo 'checked';
                                                                                                                        } ?> disabled />
                              <label for="star3" title="text">3 stars</label>
                              <input type="radio" id="star2" name="rate<?php echo $consultant['user_id']; ?>" value="2" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 2) {
                                                                                                                          echo 'checked';
                                                                                                                        } ?> disabled />
                              <label for="star2" title="text">2 stars</label>
                              <input type="radio" id="star1" name="rate<?php echo $consultant['user_id']; ?>" value="1" <?php if (isset($stars['Stars']) && $stars['Stars'][0] == 1) {
                                                                                                                          echo 'checked';
                                                                                                                        } ?> disabled />
                              <label for="star1" title="text">1 star</label>
                            </div>
                          </div>
                        </i>




                        <a <?php if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other') { ?> onclick="chat_open(<?php echo $consultant['user_assign_role_id']; ?>,<?php echo $consultant['category_id']; ?>)" <?php } else { ?> onclick="alert('Login First OR No permission')" <?php } ?> href="#" class="btn btn-sm bg-teal">
                          <i class="fas fa-comments"></i>
                        </a>
                        <a onclick="view_profile(<?php echo $consultant['user_assign_role_id']; ?>)" href="#" class="btn btn-sm btn-primary">
                          <i class="fas fa-user"></i> View Profile
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
              }
            } else {
              echo "not ok";
            }
            ?>
          </div>
        </div>
      </div>
  </div>
  </section>
  </div>
<?php
}
?>