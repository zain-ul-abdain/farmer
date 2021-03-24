<?php
echo "<pre>";
print_r($_POST);
session_start();

require_once '../require/database.php';

$q = "INSERT INTO product (category_id,user_assign_role_id,product_title,product_description,price,quantity) VALUES('" . $_POST['category'] . "','" . $_SESSION['user']['user_assign_role_id'] . "','" . $_POST['p_title'] . "','" . $_POST['p_desc'] . "','" . $_POST['price'] . "','" . $_POST['quantity'] . "')";
$db->_result($q);
if ($db->result) {
	echo 'ok';
	echo "Last id = " . $last_id = mysqli_insert_id($db->connection);
	if (isset($_FILES['file'])) {

		$file = $_FILES['file'];
		$count = 0;
		echo "mkdir = " . mkdir("../uploads/$last_id");

		foreach ($_FILES['file']['name'] as $key => $value) {

			$arr = explode("/", $file['type'][$key]);
			$file_type = $arr[0];
			$file_name = "uploads/$last_id/" . $_FILES['file']['name'][$key];
			$tmp_name = $_FILES['file']['tmp_name'][$key];

			if (move_uploaded_file($tmp_name, "../" . $file_name)) {
				$count++;
				$insert = "INSERT INTO post_attachment(post_id,file_name,file_type) VALUES('$last_id','$file_name','$file_type')";
				$db->_result($insert);
				echo "Image uploaded";
			}
		}
		header("location:../index.php?action=product&msg=Product updated Successfully ..! $count files uploaded");
		exit();
	}
} else {
	echo 'not ok';
}
