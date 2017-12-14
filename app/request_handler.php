<?php
require_once('../config/config.php');
require_once('response_handler.php');
spl_autoload_register(function ($class_name) {
    include '../classes/'.$class_name . '.php';
});

$fn = new functions(DB_TYPE, HOST, DATABASE, DB_USER, DB_PASSWORD, PORT);
$conn = $fn->conn;

if (!$conn) {
    $error[] = 'Please try again later.';
    $errors['status'] = 0;
    $errors['error'] = $error;

    _sendResponse(301, json_encode($errors), 'application/json');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "gdfgfhdg";
    _sendResponse(400);
} else {
    _checkAuth(APIKEY);
	if (isset($_POST['action']) && !empty($_POST['action'])) {
        switch ($_POST['action']) {
            case "get_users":
				$ignore_columns = array("status", "created_at", "created_by", "updated_at", "updated_by");
                $users = $fn->getMasters('users');
				foreach($users as $k => $u){
					foreach($ignore_columns as $i){
						unset($users[$k][$i]);
					}
				}
				$response = array();
				$response['status'] = "success";
				$response['response'] = $users;
				_sendResponse(200, json_encode($users));
                break;
            default:
                _sendResponse(400);
                break;
        }
    } else {
        _sendResponse(400);
    }
}
?>