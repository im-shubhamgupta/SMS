<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['sessionid'])){

 $sessionid= $_REQUEST['sessionid'];
 if($_REQUEST['sid']){
	 
	$staff_id= $_REQUEST['sid']; 
 }else{
	$staff_id=''; 
	 
 }
 $current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';
 
 if(!empty($staff_id)){
	$result=staffdetail_byid($sessionid,$staff_id);
}else{
	$result=staffdetail($sessionid,$staff_id,$current_page, $per_page);
}


		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Invalid Data";

			echo json_encode($response);   

		}

}else{
    
    	$response["status"] = 0;
    	$response["message"] = "Provide Required Parameter";

	    echo json_encode($response);
    
    
}


	

?>