<?php
	//phpinfo(); exit;
	error_reporting(0);
	require_once("../config/config.php");
	require("response_handler.php");
	
	$data = file_get_contents('php://input'); 
	
	if (!empty($data))
	{
		parse_str($data, $params);
		
		$apikey = !empty($params['apikey']) ? $params['apikey'] : "123";
		$action = !empty($params['action']) ? $params['action'] : _sendResponse(200, json_encode(array('status' => 'Error', 'message' => 'Not a valid action')), 'application/json');
		
		$api_url = PROTOCOL.HOST."/".BASE_FOLDER."/app/request_handler.php";
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,$api_url);
		//curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($curl_handle, CURLOPT_USERPWD, "$apikey");
		curl_setopt($curl_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl_handle, CURLOPT_POST, TRUE);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS,"data={$data}");
		curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($curl_handle,CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$response = curl_exec($curl_handle);
		print_r($response); exit;
	} 
	else 
	{
		$error = json_last_error_msg();
		$outstate['status'] = "Error";	
		$outstate['message'] = "Not valid request."; 
		_sendResponse(200, json_encode($outstate), 'application/json');
	} 
	//exit;
?>