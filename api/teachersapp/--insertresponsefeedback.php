<?php 

if(isset($_REQUEST['teacher_id']) && isset($_REQUEST['feedid'])  && isset($_REQUEST['response'])  && isset($_REQUEST['staffname']) ){

    if(isset($_REQUEST['registration_no'])){
	   $registration_no= $_REQUEST['registration_no'];     
    }else{
	  $registration_no='';  
    }
    include('myfunction.php');

	$teacher_id=$_REQUEST['teacher_id'];	
	$feedid=$_REQUEST['feedid'];	
	$response=$_REQUEST['response'];	
	$staffname=$_REQUEST['staffname'];	

	if(isset($_REQUEST['session'])){
	 $session= $_REQUEST['session'];     
   }else{
	 $session='';  
   }
   
    $result=insertresponsefeedback($session,$feedid,$response,$staffname);
    if(!empty($result)){
    	$response['status']=1;
    	$response['message']="Success";
    	$response['result']=$result;
    	echo json_encode($response);
    }else{
    	$response["status"] = 0;

	    $response["message"] = "No Record Found";   

        echo json_encode($response); 
    }


	// echo insertresponsefeedback($object->feedid,$object->response,$object->staffname);

}else{
	$response['status']=2;
	$response['message']="Required Parameters Teacherid, Feeid, response, staffname, ";
	echo json_encode($response);

}

?>