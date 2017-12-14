<?php
spl_autoload_register(function ($class_name) {
    include '../classes/'.$class_name . '.php';
});

$fn = new functions(DB_TYPE, HOST, DATABASE, DB_USER, DB_PASSWORD, PORT);
$conn = $fn->conn;

function getUsers(){
	
}
?>