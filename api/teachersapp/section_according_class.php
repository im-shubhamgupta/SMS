<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['classid'])){   

  $classid=mysqli_real_escape_string($con,$_REQUEST['classid']);
   $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

  $Result= SectionAccordingClass($classid,$session_id);  
  
  if(!empty($Result)){
    
    $response["result"] = $Result;
    $response["status"] = 1;
	  $response["message"] = "Success"; 
  	echo json_encode($response);
      
  }else{
      
    $response["status"] = 0;
	  $response["message"] = "Invalid Class Id";   
    echo json_encode($response);  
  }
  
}else{
     $response["status"] = 2;
	   $response["message"] = "Requires Parameter Class id is Missing";   
	   echo json_encode($response);
    
}
?>