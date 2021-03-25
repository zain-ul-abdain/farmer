<?php

    if (isset($_POST['action']) && $_POST['action'] == 'consultant_chat') {
        
        print_r($_POST);
        $user_id = $_POST['user_id'];
        $c_id = $_POST['consultant_id'];
        $query = $_POST['query'];
    }
?>