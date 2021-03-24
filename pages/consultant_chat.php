<?php
if (isset($_POST['action']) && $_POST['action'] == 'consultant_chat') {

  require_once '../require/database.php';

  $id = $_POST['id'];

  $db->_result("SELECT * FROM user WHERE user_id=" . $id);

  if ($db->result->num_rows) {

    $user = mysqli_fetch_assoc($db->result);
  } else {
    echo "not ok";
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
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="card card-primary card-outline direct-chat direct-chat-primary shadow-large">
            <div class="card-header">
              <h3 class="card-title">Chat with <?php echo $user['first_name']; ?></h3>

              <div class="card-tools">
                <span title="3 New Messages" class="badge bg-primary">3</span>
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
                <div class="direct-chat-msg">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                  </div>
                  <!-- /.direct-chat-infos -->
                  <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="Message User Image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                  <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->

                <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                  </div>
                  <!-- /.direct-chat-infos -->
                  <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="Message User Image">
                  <!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    You better believe it!
                  </div>
                  <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->

              </div>
              <!--/.direct-chat-messages-->

              <!-- Contacts are loaded here -->
              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="<?php echo $user['user_image']; ?>" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          <?php echo $user['first_name']; ?>
                          <small class="contacts-list-date float-right"><?php echo date("h:i:s d/m/y", time()) ?></small>
                        </span>
                        <span class="contacts-list-msg">Feedback</span>
                      </div>
                      <div class="rate">
                        <input onclick="_star(this.value)" type="radio" id="star5" name="rate" value="5" />
                        <label for="star5" title="text">5 stars</label>
                        <input onclick="_star(this.value)" type="radio" id="star4" name="rate" value="4" />
                        <label for="star4" title="text">4 stars</label>
                        <input onclick="_star(this.value)" type="radio" id="star3" name="rate" value="3" />
                        <label for="star3" title="text">3 stars</label>
                        <input onclick="_star(this.value)" type="radio" id="star2" name="rate" value="2" />
                        <label for="star2" title="text">2 stars</label>
                        <input onclick="_star(this.value)" type="radio" id="star1" name="rate" value="1" />
                        <label for="star1" title="text">1 star</label>
                      </div>
                      <input type="hidden"  id="star" value="0">
                      <!-- /.contacts-list-info -->
                    </a>
                  </li>
                  <li>
                    <textarea id="rating_msg"></textarea>
                    <button onclick="_rating(<?php echo $_SESSION['user']['user_assign_role_id'];?>,)" class="w3-button w3-success">Rate</button>
                  </li>
                  <!-- End Contact Item -->
                </ul>
                <!-- /.contatcts-list -->
              </div>
              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-primary">Send</button>
                  </span>
                </div>
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
?>
  <div class="content-wrapper">

        <div class="col-12">
          <!-- DIRECT CHAT DANGER -->
          <div class="card card-danger direct-chat direct-chat-danger shadow-lg">
            <div class="card-header">
              <h3 class="card-title">Shadow - Large</h3>

              <div class="card-tools">
                <span title="3 New Messages" class="badge">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                  <i class="fas fa-comments"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
            
                         
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-12">
                          <div class="w3-card-4 w3-margin">

                            <form class="w3-container" action="forms/post_process.php" method="POST" enctype="multipart/form-data">
                              <div class="w3-container w3-blue">
                                <h3>Create Post</h3>
                              </div>
                              <table class="w3-table">
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
                                  <td><textarea name="desc" class="form-control" cols="30" rows="5"></textarea></td>
                                </tr>
                                <tr>
                                  <td>Category</td>
                                  <td>
                                    <select id="category" class="form-control" name="category" onchange="get_child_category()">
                                      <option value="">Select category</option>
                                      <?php
                                      $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Knowledge_Base' AND parent_category IS NULL");
                                      $a = $db->result;
                                      while ($category = mysqli_fetch_assoc($db->result)) {
                                      ?>
                                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category']; ?></option>
                                      <?php
                                      }
                                      ?>
                                    </select>
                                  </td>
                                </tr>
                                <div id="child"></div>
                                <tr>
                                  <td>Attachments </td>
                                  <td>
                                    <div class="custom-file">
                                      <input type="file" name="file[]" class="custom-file-input" id="customFile" multiple>
                                      <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="center"><input type="submit" class="w3-button w3-green" name="submit" value="POST"></td>
                                </tr>
                              </table>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                 

                
              </div>
              <!--/.direct-chat-messages-->

              <!-- Contacts are loaded here -->
              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Count Dracula
                          <small class="contacts-list-date float-right">2/28/2015</small>
                        </span>
                        <span class="contacts-list-msg">How have you been? I was...</span>
                      </div>
                      <!-- /.contacts-list-info -->
                    </a>
                  </li>
                  <!-- End Contact Item -->
                </ul>
                <!-- /.contatcts-list -->
              </div>
              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.card-body -->
           
            <!-- /.card-footer-->
          </div>
          <!--/.direct-chat -->
        </div>