<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if( isset($_REQUEST['login_user_id']) &&  isset($_REQUEST['msgtype'])  && $_REQUEST['sessionid'] ){
    $login_user_id = $_REQUEST['login_user_id'];
    $sessionid = $_REQUEST['sessionid'];
    $msgtype = $_REQUEST['msgtype'];
    
    $current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
    $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

    $result = staff_message_list($msgtype,$sessionid, $login_user_id, $current_page, $per_page);



    if($result!=false){

        $response["result"] = $result;

        $response["status"] = 1;

        $response["message"] = "Success";  

        echo json_encode($response);   

    }elseif($result=="error"){

        $response["result"] = $result;

        $response["status"] = 3;

        $response["message"] = "Something went wrong plesae try again";  

        echo json_encode($response); 
    }
}else{

$response["status"] = 2;

$response["message"] = "Required Parameter message, login_userid, msgtype  is missing"; 

echo json_encode($response);

}


