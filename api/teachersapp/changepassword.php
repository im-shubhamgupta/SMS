<?php 

if (isset($_REQUEST['id']) && isset($_REQUEST['currentpassword']) && isset($_REQUEST['newpassword'])) {

  if(isset($_REQUEST['registration_no'])){
     $registration_no= $_REQUEST['registration_no'];     
    }else{
    $registration_no='';  
    }
  include('myfunction.php');    
  $teacher_id= $_REQUEST['id'];
  $currentpassword= $_REQUEST['currentpassword'];
  $newpassword= $_REQUEST['newpassword'];
  $result=changepassword($teacher_id,$currentpassword,$newpassword);  
  
  if(!empty($result)){
    
    $response["result"] = $result;
    $response["status"] = 1;
	$response["message"] = "Success"; 
	
	echo json_encode($response);
      
  }else{
      
    $response["status"] = 0;
	$response["message"] = "NO Class is Assigne Yet";   
    echo json_encode($response);  
  }
  
}else{
     $response["status"] = 2;
	 $response["message"] = "Requires Parameters is Missing";   
	 echo json_encode($response);
    
    
    
}

?>