<?php
require_once("config/config.php");
class functions {
	public function __construct(){
		if(DB_TYPE == "postgres"){
			try {
				$this->conn = new PDO("pgsql:host=".HOST.";port=".PORT.";dbname=".DATABASE, DB_USER, DB_PASSWORD);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this->conn; 
			} catch(PDOException $e){
				return "Connection failed: " . $e->getMessage();
			}
		} else{
			try {
				$this->conn = new PDO("mysql:host=".HOST.";dbname=".DATABASE, DB_USER, DB_PASSWORD);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $this->conn; 
			} catch(PDOException $e){
				return "Connection failed: " . $e->getMessage();
			}
		}
	}
} 


$f = new functions();
print_r($f->conn);

?>