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
				_sendResponse(200, json_encode($response));
                break;
				
			case "add_new_user":
				$post = $_POST;
				unset($post['apikey']);
				unset($post['action']);
				//$post['password'] = md5($post['password']);
				$dup = $fn->checkDuplicate('users', 'mobile', $post['mobile']);
				
				$response['status'] = "error";
				$response['response'] = "Something went wrong.";
				$response['message'] = "Something went wrong.";
				
				if(count($dup) == 0){
					$res = $fn->insertUpdate('users', $post);
					$response = array();
					if($res == "success"){
						$response['status'] = "success";
						$response['response'] = $res;
						$response['message'] = "Registered successfully";
						goto toregresponse;
					}
				} else{
					$response['response'] = "Mobile number already exists.";
					$response['message'] = "Mobile number already exists.";
				}
				
				toregresponse:
				_sendResponse(200, json_encode($response));
				break;
				
			case "check_duplicate":
				$post = $_POST;
				$fn->checkDuplicate();
				break;
				
			case "user_login":
				$post = $_POST;
				$dup = $fn->checkDuplicate('users', 'mobile', $post['mobile']);
				if(count($dup) > 0){
					if($post['password'] == $dup[0]['password']){
						$response['status'] = "success";
						$response['response'] = $dup[0];
						$response['message'] = "Logged-in successfully";
						goto tologinresponse;
					}
				}
				$response['status'] = "error";
				$response['response'] = "Invalid login credentials.";
				$response['message'] = "Invalid login credentials.";
				tologinresponse:
				_sendResponse(200, json_encode($response));
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