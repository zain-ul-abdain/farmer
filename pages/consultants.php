<?php
if (isset($_POST['action']) && $_POST['action'] == 'consultant') {
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
            $db->query = "SELECT * FROM USER INNER JOIN category ON category.category_id=user.category_id INNER JOIN user_assign_role ON user.user_id=user_assign_role.user_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id WHERE user_role.user_role='Consultant'";
            $db->result = mysqli_query($db->connection, $db->query);
            if ($db->result->num_rows) {
              while ($consultant = mysqli_fetch_assoc($db->result)) {
            ?>
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
                        <a onclick="chat_open(<?php echo $consultant['user_assign_role_id']; ?>,<?php echo $consultant['category_id']; ?>)" href="#" class="btn btn-sm bg-teal">
                          <i class="fas fa-comments"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-primary">
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