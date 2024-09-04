<?php 
if(isset($_REQUEST['registration_no'])){
       $registration_no= $_REQUEST['registration_no'];     
}
include('myfunction.php');

//New Code 

if (isset($_REQUEST['mobile']) && isset($_REQUEST['password'])) {
    
    $mobile=  $_REQUEST['mobile'];
    $password= $_REQUEST['password'];
    $user_type= $_REQUEST['user_type'];

    if(isset($_REQUEST['session']) && !empty($_REQUEST['session'])) {
        $session= $_REQUEST['session'];
    }else{
        // $session= '1';
        
      $response["status"] = 3;
      $response["message"] = "Session_id no Found";   
      $response["result"] = [];
      echo json_encode($response);  die;
    }
$token_id=isset($_REQUEST['token_id']) ? $_REQUEST['token_id'] : '';


    $Result = login( $mobile,$password,$user_type, $session,$token_id);
    if($Result != false) {        
        $response["result"] = $Result;
        $response["status"] = 1;
		$response["message"] = "Success";
        echo json_encode($response);
    }else{
        // Data are not found with the credentials
        $response["status"] = 0;
        $response["message"] = "Wrong Mobile Number or Password, please try again!";
        $response["result"] = [];
        echo json_encode($response);
    }
    
    
}else{
    // required post params is missing
    $response["status"] = 2;
    $response["message"] = "Required Mobile Number or Password is missing!";
    $response["result"] = [];
    echo json_encode($response);
}
