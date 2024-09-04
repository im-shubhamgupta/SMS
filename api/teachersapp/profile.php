<?php 
if (isset($_REQUEST['id']) ) {
    
    $id=$_REQUEST['id'];
    
     if(isset($_REQUEST['registration_no'])){
     $registration_no= $_REQUEST['registration_no'];     
   }else{
     $registration_no='';  
   }
   include('myfunction.php');
   
   $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
    $result= profile($id);
   if(!empty($result)){
     
    $response["result"] = $result;
    $response["status"] = 1;
	$response["message"] = "Success"; 
	echo json_encode($response);
       
   }else{
     
     $response["status"] = 0;
	$response["message"] = "No Record Found";   
    echo json_encode($response);    
       
   }
}else{
    
     $response["status"] = 2;
	 $response["message"] = "Requires Parameters is Missing";   
	 echo json_encode($response); 
    
}

?>