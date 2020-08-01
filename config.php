<?php
class Database {
	
	private $db_host = 'bqhddhrb5loxiqkkqa3n-mysql.services.clever-cloud.com';
	private $db_name = 'bqhddhrb5loxiqkkqa3n';
	private $db_username = 'u8v236m22oph6n7p';
	private $db_password = '7WKM3TYIZGXj1s9BgYZd';
	
	public function dbConnection () {
		try {
			$conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch(PDOException $e){
			echo "connection error".$e->getMessage();
			exit;
		}
	}
}
?>