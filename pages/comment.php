<?php 

	require_once '../require/database.php';

	if (isset($_POST['action']) && $_POST['action'] == "comment") {
		
		$db->_result("INSERT INTO post_reply(message,user_assign_role_id,post_id) VALUES('".htmlspecialchars($_POST['comment'],true)."','".$_POST['user_id']."','".$_POST['post_id']."')");
		if ($db->result) {
			echo "true";
		}else{
			echo "false";
		}
	}

	if (isset($_POST['action']) && $_POST['action'] == "like") {
		
		echo $q = "INSERT INTO post_like(user_assign_role_id,post_id,is_like) VALUES('".$_POST['user_id']."','".$_POST['post_id']."','1')";
		$db->_result($q);
		if ($db->result) {
			echo "true";
		}else{
			echo "false";
			print_r($_POST);
		}
	}

?>