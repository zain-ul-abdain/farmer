<?php 
	date_default_timezone_set("Asia/Karachi");
	
	interface db{

		public function database_connection($hostname,$username,$password,$database);
	}

	/**
	 * Abstract class contains properties and methods
	 */
	abstract class db_drivers implements db{
		public $hostname 	= "localhost";
		public $username 	= "root";
		public $password 	= "";
		public $database 	= "farmer";
	
		public $connection 	= NULL;
		public $result 		= NULL;
		public $query	 	= NULL;
		public $last_id	 	= NULL;
		
	}

	/**
	 * Database Connection
	 */
	class DbConnection extends db_drivers {

		public function __construct(){

			$this->connection 	= mysqli_connect($this->hostname,$this->username,$this->password,$this->database);
			if (!mysqli_connect_errno()) {
				// echo "Database connected";
			}
		}
		
		public function database_connection($hostname,$username,$password,$database){
			
			$this->connection 	= mysqli_connect($hostname,$username,$password,$database);
		}


		public function _select($table){

			$this->query = "SELECT * FROM $table";
			$this->result = mysqli_query($this->connection,$this->query);
		}

		public function _result($query){

			$this->result = mysqli_query($this->connection,$query);
		}

		public function _register($first_name,$last_name,$email,$password,$img,$city_id,$exp_lvl,$phone,$add,$category_id){

			$q = "INSERT INTO user(first_name,last_name,user_email,user_password,user_image,city_id,expert_level,phone_number,address,category_id)
					VALUES('$first_name','$last_name','$email','$password','$img','$city_id','$exp_lvl','$phone','$add','$category_id')";
			$this->result = mysqli_query($this->connection,$q);
			$this->last_id = mysqli_insert_id($this->connection);
		}
	}

	$db = new DbConnection();
