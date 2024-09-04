<?php 
include('myfunction.php');

//New Code 


    $Result = session();
    if($Result != false) {        
        $response["result"] = $Result;
        $response["status"] = 1;
		$response["message"] = "Success";
        echo json_encode($response);
    }else{
        // Data are not found with the credentials
        $response["status"] = 0;
        $response["message"] = "Not Found";
        $response["result"] = [];
        echo json_encode($response);
    }
    

    
?>