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
		//$qry->close();
		return $result;
	}
	
	public function insertUpdate($table, $inp, $other = null){
		$columns = array_keys($inp);
		$values = str_repeat("?, ", count($columns));
		$values = trim($values, ', ');
		$columns = implode(', ', $columns);
		$sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
		if(!empty($other)){
			if(isset($other['for']) && $other['for'] == "update"){
				$sql = "UPDATE {$table} ";
			}
		}
		$values = array_values($inp);
		$qry = $this->conn->prepare($sql);
		for($i = 1; $i <= count($values); $i++){
			$qry->bindValue($i, $values[$i-1]);
		}
		$qry->execute();
		//$qry->close();
		return "success";
	}
	
	public function checkDuplicate($table, $column, $value){
		$where  = " AND {$column} = :value ";
		$sql = "SELECT * FROM `{$table}` WHERE status='active' {$where}";
		$qry = $this->conn->prepare($sql);
		$qry->bindValue(':value', $value);
		
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_ASSOC);
		//$qry->close();
		return $result;
	}
}
?>