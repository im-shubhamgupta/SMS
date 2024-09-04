<?php 
if (isset($_REQUEST['mobile']) && isset($_REQUEST['password']) ) {

    if(isset($_REQUEST['registration_no'])){
       $registration_no= $_REQUEST['registration_no'];     
    }else{
      $registration_no='';  
    } 
    
   include('myfunction.php'); 
    
    $mobile=  $_REQUEST['mobile'];
    $password= $_REQUEST['password'];
    $user_type= $_REQUEST['user_type'];
    
    if(isset($_REQUEST['session'])){
      $session= $_REQUEST['session'];  
        
    }else{
       $session=1; 
    }
    // tokenId
    if(isset($_REQUEST['token_id'])){
      $token_id= $_REQUEST['token_id'];  
        
    }else{
       $token_id=''; 
    }
    $api_url= $_REQUEST['api_url'];
    
    $Result = login( $mobile,$password,$user_type, $session,$token_id,$api_url,$registration_no);
    if($Result != false) {        
        $response["result"] = $Result;
        $response["status"] = 1;
		$response["message"] = "Success";
        echo json_encode($response);
    }else{
        // Data are not found with the credentials
        $response["status"] = 0;
        $response["message"] = "Username/mobile or password do not match, please try again!";
        
        echo json_encode($response);
    }
    
    
}else{
    // required post params is missing
    $response["status"] = 2;
    $response["message"] = "Required Mobile Number or Password or registration_no  is missing!";
    
    echo json_encode($response);
}
    
?>