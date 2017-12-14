<?php
/* Basic operations to be done */
class functions {
	public static $conn = null;
	public static $session = array();
	public $user = array();
	
	public function __construct($db_type, $host, $db_name, $db_user, $db_pass, $port){
		session_start();
		if($db_type == "postgres"){
			try {
				$this->conn = new PDO("pgsql:host={$host};port={$port};dbname={$db_name}", $db_user, $db_pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage();
				exit;
			}
		} else{
			try {
				$this->conn = new PDO("mysql:host={$host};dbname={$db_name}", $db_user, $db_pass);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e){
				echo "Connection failed: " . $e->getMessage();
				exit;
			}
		}
	}
	
	public function getSession(){
		$this->session = isset($_SESSION['alert']) ? $_SESSION['alert'] : array();
	}
	
	public function setSession($values){
		foreach($values as $k => $v){
			$this->session[$k] = $v;
		}
	}
	
	public function getCurrentUser(){
		$this->user = $this->session['user'];
		return $this->user;
	}
	
	protected function clearSession(){
		$this->session = array();
		session_destroy();
	}
	
	public function getMasters($table, $id=null, $orderColumn = 'id', $order = 'ASC'){
		$where  = ($id > 0) ? " AND id = :id " : "";
		$sql = "SELECT * FROM `{$table}` WHERE status='active' {$where} ORDER BY `{$orderColumn}` {$order}";
		$qry = $this->conn->prepare($sql);
		
		if($id > 0){
			$qry->bindValue(':id', $id);
		}
		// array(':table' => $table, ':where' => $where, ':orderColumn' => $orderColumn, ':order' => $order)
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
}
?>