<?php 
// -------This is for Change DB Access by School Registration Number-----
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';

include_once('myfunction.php');

if(isset($_REQUEST['teacher_id'])){

	$TeacherID = $_REQUEST['teacher_id'];
    // $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

    if(!empty($_REQUEST['session_id'])){
      $SessionID = $_REQUEST['session_id'];     
    }else{
      $response["status"] = 3;
      $response["message"] = "Session_id not Found";   
      $response["result"] = [];   
      echo json_encode($response);  die;
    } 

    $SubjectID = isset($_REQUEST['subjectid']) ? $_REQUEST['subjectid'] : '';
    $CurrentPage = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
    $PerPage = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';
    
	if(!empty($_REQUEST['classid']) && !empty($_REQUEST['sectionid'])){
		$ClassID = $_REQUEST['classid'];
		$SectionID = $_REQUEST['sectionid'];
	}elseif(!empty($_REQUEST['classid']) && empty($_REQUEST['sectionid'])){
		$ClassID = $_REQUEST['classid'];
		$SectionID = '';
	}else{
		$ClassID=''; 
		$SectionID='';
	} 
	
	$result = ShowHomework($SessionID, $TeacherID, $ClassID, $SectionID, $SubjectID, $CurrentPage, $PerPage);

	echo $result;
    // if(!empty($result)){


    // 	$response["status"] = 1;

    // 	$response["message"] = "Success";  

    // 	$response["current_page"] = $result['current_page'];
    // 	$response["per_page"] = $result['per_page'];
    // 	$response["total_page"] = $result['total_page'];
    // 	$response["total_records"] = $result['total_records'];
    // 	$response["result"] = $result['data'];



    // 	echo json_encode($response);   

    // }else{

    // 	$response["status"] = 0;

    // 	$response["message"] = "No Message";

    // 	echo json_encode($response);   

    // }
}else{
    $response["status"] = 2;
    $response["message"] = "Required Parameter teacher_id "; 
    $response["result"] = [];   
    echo json_encode($response);
}
?>