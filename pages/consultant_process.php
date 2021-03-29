<?php

require_once '../require/database.php';
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'consultant_chat') {


  $query = $_POST['chat_message'];
  $user_id = $_SESSION['user']['user_assign_role_id'];
  $last_id = $_SESSION['consultant_chat_last_id'];

  $insert = "INSERT INTO consultancy_service_chat (consultancy_service_id,chat_message,user_assign_role_id) VALUES ('$last_id','" . htmlspecialchars($query, true) . "','$user_id')";
  $db->_result($insert);

  if ($db->result) {
    echo "ok";
  } else {
    echo "not ok";
  }
}

if (isset($_POST['action']) && $_POST['action'] == 'consultant_rate') {

  $star   = $_POST['star'];
  $msg    = $_POST['feedback'];

  $db->_result("UPDATE consultancy_service SET STATUS ='Complete', rating=$star, feedback='$msg',discussion_end=NOW() WHERE consultancy_service_id=" . $_SESSION['consultant_chat_last_id']);
  if ($db->result) {
    echo 'ok';
  } else {
    echo 'not ok';
  }
}


if (isset($_POST['action']) && $_POST['action'] == 'chat_open') { ?>

  
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

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
      color: #deb217;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
      color: #c59b08;
    }
  </style>
 
<?php
    $user_id = $_POST['user_id'];
    $_SESSION['consultant_chat_last_id'] = $chat_id = $_POST['chat_id'];

    $db->_result("SELECT * FROM user_assign_role INNER JOIN user ON user.user_id=user_assign_role.user_id  WHERE user_assign_role.user_assign_role_id=" . $user_id);

    if ($db->result->num_rows) {

      $user = mysqli_fetch_assoc($db->result);
    } else {
      echo "not ok";
    }
  ?>
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="card card-primary card-outline direct-chat direct-chat-primary shadow-large">
              <div class="card-header">
                <h3 class="card-title">Chat with <?php echo $_SESSION['user']['first_name']; ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button>
                  <button onclick="_consultant()" type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                  <!-- Message. Default to the left -->

                  <?php
                  $msg_query = "SELECT * FROM consultancy_service_chat WHERE consultancy_service_id = '$chat_id'";
                  $db->_result($msg_query);
                  if ($db->result->num_rows) {
                    while ($msg = mysqli_fetch_assoc($db->result)) {
                      if ($msg['user_assign_role_id'] == $_SESSION['user']['user_assign_role_id']) {
                  ?>
                        <!-- Message to the right -->
                        <div class="direct-chat-msg right">
                          <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-right"><?php echo $_SESSION['user']['first_name']; ?></span>
                            <span class="direct-chat-timestamp float-left"><?php echo $msg['added_on']; ?></span>
                          </div>
                          <!-- /.direct-chat-infos -->
                          <img class="direct-chat-img" src="<?php echo $_SESSION['user']['user_image']; ?>" alt="Message User Image">
                          <!-- /.direct-chat-img -->
                          <div class="direct-chat-text">
                            <?php echo $msg['chat_message']; ?>
                          </div>
                          <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->
                      <?php
                      } else {
                        $c = "SELECT * FROM user,user_assign_role WHERE user_assign_role.user_id =user.user_id AND user_assign_role_id=$user_id";
                        $res = mysqli_query($db->connection, $c);
                        if ($db->result->num_rows) {
                          $res = mysqli_fetch_assoc($res);
                          ?>
                          <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                              <span class="direct-chat-name float-left"><?php echo $user['first_name']; ?></span>
                              <span class="direct-chat-timestamp float-right"><?php echo $msg['added_on']; ?></span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="<?php echo $user['user_image']; ?>" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                              <?php echo $msg['chat_message']; ?>
                            </div>
                            <!-- /.direct-chat-text -->
                          </div>
                          
                          <?php
                        } else {
                          echo "empty";
                        }
                      ?>
                        <!-- /.direct-chat-msg -->
                  <?php
                      }
                    }
                  }
                  ?>

                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <input id="txt" type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button onclick="_chat_start(<?php echo $_SESSION['consultant_chat_last_id']; ?>,<?php echo $user_id;?>)" type="button" class="btn btn-primary">Send</button>
                    </span>
                  </div>
                  <input type="hidden" id="category_id" value="<?php echo $_POST['category_id'] ?? ''; ?>">
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
          </div>




        </div>
      </div>
    </div>
    <!-- /.col -->

<?php
}

if (isset($_POST['action']) && $_POST['action'] == 'add_consultant_reply') {

  $query = $_POST['chat_message'];
  $user_id = $_SESSION['user']['user_assign_role_id'];
  $last_id = $_SESSION['consultant_chat_last_id'];

  $insert = "INSERT INTO consultancy_service_chat (consultancy_service_id,chat_message,user_assign_role_id) VALUES ('$last_id','" . htmlspecialchars($query, true) . "','$user_id')";
  $db->_result($insert);

  if ($db->result) {
    echo "ok";
  } else {
    echo "not ok";
  }
}
?>