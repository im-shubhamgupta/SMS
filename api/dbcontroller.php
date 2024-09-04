<?php  
include_once('config.php');

function Call_Baseurl(){   //https://abhigya.in/beta/sms
			return sprintf(
			"%s://%s%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME'],dirname(dirname(dirname($_SERVER['PHP_SELF']))),
			);
}

function get_current_session(){
    $response=array();
	global $con;
	$Y=date('Y');
	$m=date('m');
	if($m>3){  // after april take next year
		$year=date('Y',strtotime('+1year'));
	}else{
		$year=$Y;
	}
	$quec=$con->query("select * from session where year LIKE '%$year%' ");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['id']=$resc['id'];
	$response['year']=$resc['year'];
	return $response;
    }else{
    	return "";
    }
} 
function get_event_type_byid($event_id){
	$response=array();
	global $con;
	$quec=$con->query("SELECT * FROM `event_type` WHERE `event_id`='$event_id' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['event_id']=$resc['event_id'];
		$response['event_name']=$resc['event_name'];
		return $response;
    }else{
    	return "";
    }
}
function get_textsms_by_msgtype($msg_type){
	$response=array();

	global $con;
	$quec=$con->query("SELECT * FROM `textsms_templates` WHERE `status`='1' AND `msg_type`='$msg_type' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['msg_type']=$resc['msg_type'];
		$response['temp_id']=$resc['temp_id'];

		return $response;
    }else{
    	return "";
    }
}
function get_log_sms_count_byid($id){
	$response=array();
	global $con;
	$quec=$con->query("SELECT * FROM `log_sms_count` WHERE `id`='$id' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['count_sms']=$resc['count_sms'];
		$response['limit']=$resc['limit'];

		return $response;
    }else{
    	return "";
    }

}
function getCategoryName_byid($id){
	$response=array();
	// global $con;
	switch($id){
		case '1';
		 return "Announcement";
		break;
		case '2';
		 return "Homework";
		break;
		case '3';
		 return "Message";
		break;
		case '4';
		 return "Photo Gallery";
		break;
		case '5';
		 return "Important Information";
		break;
		case '6';
		 return "Study Material";
		break;
	}
}
function get_class_byid($clid){
	$response=array();
	global $con;
		$quec=$con->query("select * from class where class_id='$clid'");
		if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['class_name']=$resc['class_name'];

		return $response;
	    }else{
	    	return "";
	    }
}

function get_section_byid($seid){
	$response=array();
	global $con;
	$quec=$con->query("select * from section where section_id='$seid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['section_name']=$resc['section_name'];

	return $response;

    }else{
    	return "";
    }
}
function get_subject_byid($sub_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from `subject` where subject_id='$sub_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['subject_name']=$resc['subject_name'];
	// $response['max_marks']=$resc['max_marks'];

	return $response;

    }else{
    	return "";
    }
}

function get_admission_type_byid($admid){
	$response=array();
	global $con;
	$quec=$con->query("select * from admission_type where adm_type_id='$admid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['adm_type_name']=$resc['adm_type_name'];

	return $response;

    }else{
    	return "";
    }
}
function get_attendance_type_byid($type_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from attendance_type where att_type_id='$type_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['att_type_name']=$resc['att_type_name'];
	$response['short_name']=$resc['short_name'];

	return $response;

    }else{
    	return "";
    }
}
function get_test_byid($test_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from test where test_id='$test_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['test_name']=$resc['test_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_request_type_byid($req_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from request_type where request_id='$req_id' ");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['request_name']=$resc['request_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_leave_type_byid($leave_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from leave_type where leave_id='$leave_id' ");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['leave_name']=$resc['leave_name'];
	return $response;
    }else{
    	return "";
    }
}

function get_expense_type_byid($eid){
	$response=array();
	global $con;
	$quec = $con->query("select * from expense_type where expense_type_id='$eid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['expense_type_name']=$resc['expense_type_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_transports_byid($tranid){
	$response=array();
	global $con;
	$quec = $con->query("select * from transports where trans_id='$tranid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['route_name']=$resc['route_name'];
	$response['price']=$resc['price'];

	return $response;

    }else{
    	return "";
    }
}
function get_driver_byid($id){
	$response=array();
	global $con;
	$quec = $con->query("select * from driver where id='$id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['name']=$resc['name'];
	return $response;
    }else{
    	return "";
    }
}
function get_vehicle_byid($vid){
	$response=array();
	global $con;
	$quec = $con->query("select * from vehicle where vehicle_id='$vid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['vehicle_name']=$resc['vehicle_name'];
	$response['vehicle_number']=$resc['vehicle_number'];
	return $response;
    }else{
    	return "";
    }
}
function get_transport_expense_type_byid($tid){
	$response=array();
	global $con;
	$quec = $con->query("select * from transport_expense_type where trans_expense_type_id='$tid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['trans_expense_type_name']=$resc['trans_expense_type_name'];
	return $response;
    }else{
    	return "";
    }
}

function get_fee_mode_byid($feemodeid){
	$response=array();
	global $con;
	$quec = $con->query("select * from fee_mode where fee_mode_id='$feemodeid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['fee_mode_name']=$resc['fee_mode_name'];

	return $response;

    }else{
    	return "";
    }
}
function get_fee_header($feeid){
	global $con;
	$FHquery = mysqli_query($con, "select `type` from fee_header where fee_header_id='$feeid'");
	if(mysqli_num_rows($FHquery)>0){
		$FHRow = mysqli_fetch_array($FHquery);
		$fheadtype = $FHRow['type'];
		return $fheadtype;
	}else{
		return '';
	}
	
}
function get_budget_header_byid($bh_id){
	$response=array();
	global $con;
	$quec = $con->query("select * from budget_header where budget_header_id='$bh_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['budget_header_name']=$resc['budget_header_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_stock_type_byid($st_id){
	$response=array();
	global $con;
	$quec = $con->query("select * from stock_type where stock_type_id='$st_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['stock_type_name']=$resc['stock_type_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_stock_vendor_byid($stv_id){
	$response=array();
	global $con;
	$quec = $con->query("select * from stock_vendor where stock_vendor_id='$stv_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['stock_vendor_name']=$resc['stock_vendor_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_publisher_byid($pid){
	$response=array();
	global $con;
	$quec = $con->query("select * from publisher where publisher_id='$pid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['publisher_name']=$resc['publisher_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_book_type_byid($bt_id){
	$response=array();
	global $con;
	$quec = $con->query("select * from book_type where book_type_id='$bt_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['book_type_name']=$resc['book_type_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_vendor_byid($vid){
	$response=array();
	global $con;
	$quec = $con->query("select * from vendor where vendor_id='$vid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['vendor_name']=$resc['vendor_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_branch_byid($bid){
	$response=array();
	global $con;
	$quec = $con->query("select * from branch where branch_id='$bid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['branch_name']=$resc['branch_name'];
	return $response;
    }else{
    	return "";
    }
}
function get_sms_setting_byid($id){
	$response=array();
	global $con;
	$sql="select * from sms_setting where `sms_id`='$id' and `status`='1' ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['sender_id']=$resc['sender_id'];
		$response['api_key']=$resc['api_key'];
		$response['status']=$resc['status'];
		
		return $response;
    }else{
    	return "NA";
    }

}
function get_text_sms_setting(){
	$response=array();
	global $con;
	$quec=$con->query("select * from sms_setting where `sms_id`='1' and `status`='1' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['api_url']=$resc['api_url'];
		$response['sender_id']=$resc['sender_id'];
		$response['api_key']=$resc['api_key'];
		$response['status']=$resc['status'];
		
		return $response;
    }else{
    	return "";
    }

}
function get_whatsapp_sms_count(){
	$response=array();
	global $con;
	$quec=$con->query("SELECT * FROM `log_sms_count` WHERE `id`='1' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['count_sms']=$resc['count_sms'];
		$response['limit']=$resc['limit'];

		return $response;
    }else{
    	return "";
    }
}
function get_text_sms_count(){
	$response=array();
	global $con;
	$quec=$con->query("SELECT * FROM `log_sms_count` WHERE `id`='2' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['count_sms']=$resc['count_sms'];
		$response['limit']=$resc['limit'];

		return $response;
    }else{
    	return "";
    }
}
function get_staff_byid($st_id){
    $response=array();
	global $con;
	$quec=$con->query("select * from `staff` where `st_id`='$st_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['token_id']=$resc['token_id'];
	$response['staff_name']=$resc['staff_name'];
	$response['staff_id']=$resc['staff_id'];
	$response['address']=$resc['address'];
	if(!empty($resc['image'])){
		$response['image_path']='staff/'.str_replace('/','-',$resc['staff_id']).'/'.$resc['image'];
	}else{
		$response['image_path']='images/no_image.png';
	}
	return $response;
    }else{
    	return "";
    }
}
function getStudent_byStudent_id($student_id){
    $response=array();
	global $con;
	$quec=$con->query("select * from `students` where `student_id`='$student_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['token_id']=$resc['token_id'];
	$response['student_name']=$resc['student_name'];
	$response['register_no']=$resc['register_no'];
	$response['parent_no']=$resc['parent_no'];
	$response['due']=$resc['due'];
	if(!empty($resc['stu_image'])){
		$response['stu_image_path']='images/student/'.str_replace('/','-',$resc['register_no']).'/'.$resc['stu_image'];
	}else{
		$response['stu_image_path']='images/no_image.png';
	}
	
	return $response;
    }else{
    	return "";
    }
}
function GetClass($class_id){
   	global $con;
   $classQuery= $con->query("SELECT class_name  FROM  class WHERE class_id='$class_id'");
   if($classQuery->num_rows>0){
     $ClassRow=$classQuery->fetch_assoc();  
     $class=   $ClassRow['class_name'];
     return $class;
   }else{
       $class='';
      return $class; 
   }
}
function GetSection($section_id){
   	global $con;
	$sql="SELECT section_name  FROM  section WHERE section_id='$section_id'";
    $sectionQuery= $con->query($sql);
   if($sectionQuery->num_rows>0){
     $SectionRow=$sectionQuery->fetch_assoc();  
     $section=   $SectionRow['section_name'];
     return $section;
   }else{
       $section='';
      return $section; 
   }
}
function get_student_records_by_stuid($stu_id,$session){  
	$response=array();
	global $con;
	$quec=$con->query("select * from `student_records` where `stu_id`='$stu_id' and session='$session' ");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['id']=$resc['id'];
	$response['class_id']=$resc['class_id'];
	$response['class_name']=GetClass($resc['class_id']);
	$response['section_id']=$resc['section_id'];
	$response['section_name']= Getsection($resc['section_id']);
	$response['roll_no']=$resc['roll_no'];
	$response['session']=$resc['session'];
	return $response;
    }else{
    	return "";
    }
}
function getStudents_whatsapp_mobno($student_id,$session){
    $response=array();
	global $con;
	$sql="select `student_name`,`register_no`,`parent_no` from `students` as s join student_records as sr on s.student_id=sr.stu_id where `student_id`='$student_id' and sr.session='$session' and `msg_type_id`='1'  ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['student_name']=$resc['student_name'];
	$response['register_no']=$resc['register_no'];
	$response['parent_no']=$resc['parent_no'];

	return $response;
    }else{
    	return "";
    }
}
function getStudents_text_mobno($student_id,$session){
    $response=array();
	global $con;
	$sql="select `student_name`,`register_no`,`parent_no` from `students` as s join student_records as sr on s.student_id=sr.stu_id where `student_id`='$student_id' and sr.session='$session' and `msg_type_id`='2'  ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['student_name']=$resc['student_name'];
	$response['register_no']=$resc['register_no'];
	$response['parent_no']=$resc['parent_no'];

	return $response;
    }else{
    	return "";
    }
}
function get_social_category_name($scid){
	$response=array();
	global $con;
	$quec=$con->query("select * from social_category where soc_cat_id='$scid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['soc_cat_name']=$resc['soc_cat_name'];
	return $response['soc_cat_name'];
    }else{
    	return "";
    }
}
function get_religion_name($regid){
	$response=array();
	global $con;
	$quec=$con->query("select * from religion where religion_id ='$regid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['religion_name']=$resc['religion_name'];
	return $response['religion_name'];
    }else{
    	return "";
    }
}
function get_message_type($msgid){
	$response=array();
	global $con;
	$quec=$con->query("select * from message_type where msg_type_id='$msgid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['msg_name']=$resc['msg_name'];

	return $response['msg_name'];

    }else{
    	return "";
    }
}
function getSessionByid($id){
    $response=array();
	global $con;
	$quec=$con->query("select * from session where id='$id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['year']=$resc['year'];
	return $response;
    }else{
    	return "";
    }
}
function comma_separated_to_array($string, $separator = ','){
		//Explode on comma
		$vals = explode($separator, $string);
		//Trim whitespace
		foreach($vals as $key => $val) {
			$vals[$key] = trim($val);
		}
		//Return empty array if no items found
		return array_diff($vals, array(""));
}
function comma_separated_to_array_path($path,$string, $separator = ','){
		//Explode on comma
		$vals = explode($separator, $string);
		//Trim whitespace
		foreach($vals as $key => $val) {

			$vals[$key] = trim($path).trim($val);
		}
		//Return empty array if no items found
		return array_diff($vals, array(""));
}
function get_array_monthname($id){	
	global $con;
	  $Query=$con->query("select * from months where fee_order_month IN ($id)");		
	  if($Query->num_rows>0){	 
	  while($MonthRow=$Query->fetch_assoc()){		
	   $Responce[]=$MonthRow['month_name'];		 		
	   }      		 
	  }	 		
	  if(!empty($Responce)){	
	   $Responce=implode(', ',$Responce);		
	   }			
	   return $Responce;
}	
function check_installed_app_bymob($parent_no){
    $response=array();
	global $con;
	$sql="select * from installed_app where parent_no='$parent_no'";
	$quec=$con->query($sql);
	if($quec->num_rows>0){
	    return '1';
    }else{
    	return '0';
    }
}
function get_monthname_byid($month_id){
    $response=array();
	global $con;
	$sql="select * from months where month_id='$month_id'";
	$quec=$con->query($sql);
	if($quec->num_rows>0){
		while($resc=$quec->fetch_assoc()){		
	      $response['month_name']=$resc['month_name'];		 		
	    } 
	    return $response;
    }else{
    	return '';
    }
}
function get_school_details(){
	$response=array();
	global $con;
	$quec=mysqli_query($con,"select * from setting "); //where company_id='1'
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['company_name']=$resc['company_name'];
	$response['registration_number']=$resc['registration_number'];
	$response['affiliation_number']=$resc['affiliation_number'];
	
	$response['company_address']=$resc['company_address'];
	$response['company_number']=$resc['company_number'];
	$response['company_image']=$resc['company_image'];
	$response['company_image_path']='images/profile/'.$resc['company_image'];
	$response['fcm_key']=$resc['fcm_key'];

	return $response;
    }else{
    	return "";
    }
}
function get_assign_fee_class($class_id,$session){
	$response=array();
	global $con;
	$sql="select * from assign_fee_class where `class_id`='$class_id' and `session`='$session' ";
	$quec=mysqli_query($con,$sql); //where company_id='1'
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['fee_header_id']=$resc['fee_header_id'];
	$response['fee_header_amount']=$resc['fee_header_amount'];
	$response['total_amount']=$resc['total_amount'];
	return $response;
    }else{
    	return "";
    }
}
function get_depart_bystaff($staffid){
	$response=array();
	global $con;
	$sql="SELECT *	FROM `assign_department` where staff_id='$staffid' ";
	$quec=mysqli_query($con,$sql); //where company_id='1'
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	return $resc['dept_id'];
    }else{
    	return "";
    }
}
function get_textsms_templates_byid($id){
	$response=array();
	global $con;
	$sql="SELECT *	FROM `textsms_templates` where 	id='$id' ";
	$quec=mysqli_query($con,$sql); //where company_id='1'
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['msg_type']=$resc['msg_type'];
		$response['temp_id']=$resc['temp_id'];
	return $response;
    }else{
    	return "";
    }
}

//Android push notifications
function push_notification_android($device_id,$Title, $Remarks,$type=''){
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        //demo fcm api key
        // $api_key = 'AAAAsLIm0Hs:APA91bEhnFkeaBmtoJ9UxdYN6v_BuUMdP1cIXAs9DPdfsbsaDWij-QEMzfwSXk_sxcFkyYERHz2jTM90iVa0Cfo8-NAUyIqB9PqBB-WDNb_yt-8P0cBtlYJTitX9UvLBFiyf4o_wvYNR';

		$api_key=get_school_details()['fcm_key'];

    
        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array (
                    "title" => $Title,
                    "body" => $Remarks,
                    "type"=>$type
                )
        );
    
        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
}
       //Android push notification start end




	function sendwhatsappMessage($mobile, $msgg, $messagetype){
		date_default_timezone_set("Asia/Kolkata");
		global $con;
		if(is_array($mobile)){
			$hits=count($mobile);
			$mobile=implode(',',$mobile);
		}else{
			$hits=1;
			$mobile=$mobile;
		}
		
		$instance_id=get_sms_setting_byid(2)['sender_id'];
		$tokenid=get_sms_setting_byid(2)['api_key'];
		$status=get_sms_setting_byid(2)['status'];

		if((get_log_sms_count_byid(1)['count_sms'] > 0) && ($status==1 )){  //stop the sms if limit is 0

			// $mobile="";
			$msg = str_replace('ISCTDT', '', $msgg);
			// $mobile="7004083341";

			//-------------make counting log-------------------------
			$month=date('m');
			$modify_date=date('Y-m-d H:i:s');



			$msql="SELECT * from `log_sms_count` WHERE `id`='1' and month(`modify_date`)='$month' ";
			$mquery=mysqli_query($con,$msql);
			//if the data not exist of current month then run this query
			if(mysqli_num_rows($mquery) >0){
				//if the data exist of current month then run this query
				$Wsql="UPDATE `log_sms_count` SET  `total_send`=(`total_send`+ '".$hits."') , `count_sms`=(`count_sms`- '".$hits."') , `curr_month`=(`curr_month`+ '".$hits."') , `modify_date`='$modify_date'  where `id`='1' ";
			    mysqli_query($con,$Wsql); 

			}else{
				$Othsql="SELECT * from `log_sms_count` WHERE `id`='1' ";
			    $Othquery=mysqli_query($con,$Othsql);

			    $Othrow=mysqli_fetch_assoc($Othquery);

				$curr_monthdata=$Othrow['curr_month'];

				//data update on previous month
				$psql="UPDATE `log_sms_count` SET  `prev_month`='$curr_monthdata', `curr_month`='0'  where `id`='1' ";
			    mysqli_query($con,$psql); 

			    //data update on this month
			    $csql="UPDATE `log_sms_count` SET `total_send`=(`total_send`+ '".$hits."') ,  `count_sms`=(`count_sms`- '".$hits."') , `curr_month`=(`curr_month`+ '".$hits."') , `modify_date`='$modify_date'  where `id`='1' ";
			    mysqli_query($con,$csql); 

			}
			//-------------make counting log-------------------------
			// echo $completeurl="https://ziper.io/api/send.php?number=91'.$mobile.'&type=text&message='.$message.'&instance_id='.$instance_id.'&access_token='.$tokenid";
			
			$message = str_replace(' ', '%20', $msg);
			
			$curl1 = curl_init();
			curl_setopt_array($curl1, array(
			CURLOPT_URL =>'https://ziper.io/api/send.php?number=91'.$mobile.'&type=text&message='.$message.'&instance_id='.$instance_id.'&access_token='.$tokenid,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache"
			),
			));
			$SMSresponse1 = curl_exec($curl1);
			$msg=json_decode($SMSresponse1,true);
			if($msg['status']=='error'){
				// echo "message not send;";
				 $sql2="UPDATE `sms_setting` SET `work_status`='0' ,`modify_date`='".date('Y-m-d H:i:s')."' where `sms_id`='2' " ;
				mysqli_query($con,$sql2);
			}else{
				 $sql2="UPDATE `sms_setting` SET `work_status`='1' ,`modify_date`='".date('Y-m-d H:i:s')."' where `sms_id`='2' " ;
				mysqli_query($con,$sql2);
				// echo "message sent sucessfully";
			}
			$err = curl_error($curl1);
			curl_close($curl1);
			if ($err) {
			// echo "<br>cURL Error #: $err";
			}else{
				return "success";
			}
		}else{
			return "";

		}
		
	}
	function sendtextMessage($mobile, $msg, $messagetype){
		// print_r($mobile);
		date_default_timezone_set("Asia/Kolkata");
		
		global $con;
	
		if(is_array($mobile)){
			$hits=count($mobile);
			$mobile=implode(',',array_unique($mobile));
		}else{
			$hits=1;
			$mobile=$mobile;
		}
		
		// if((get_log_sms_count_byid(2)['count_sms'] > 0)  &&  !empty(get_textsms_by_msgtype($messagetype)['temp_id'])){ 
		if((get_log_sms_count_byid(2)['count_sms'] > 0)  &&  !empty(get_textsms_by_msgtype($messagetype)['temp_id']) && get_text_sms_setting()['status']==1 ){ 
			// echo $msg;
			//-------------make counting log-------------------------
			$month=date('m');
			$modify_date=date('Y-m-d H:i:s');



			$msql="SELECT * from `log_sms_count` WHERE `id`='2' and month(`modify_date`)='$month' ";
			$mquery=mysqli_query($con,$msql);
			//if the data not exist of current month then run this query
			if(mysqli_num_rows($mquery) >0){
					//if the data exist of current month then run this query
					$Wsql="UPDATE `log_sms_count` SET  `total_send`=(`total_send`+ '".$hits."') , `count_sms`=(`count_sms`- '".$hits."') , `curr_month`=(`curr_month`+ '".$hits."') , `modify_date`='$modify_date'  where `id`='2' ";
				    mysqli_query($con,$Wsql); 

				}else{
					$Othsql="SELECT * from `log_sms_count` WHERE `id`='2' ";
				    $Othquery=mysqli_query($con,$Othsql);

				    $Othrow=mysqli_fetch_assoc($Othquery);

					$curr_monthdata=$Othrow['curr_month'];

					//data update on previous month
					$psql="UPDATE `log_sms_count` SET  `prev_month`='$curr_monthdata', `curr_month`='0'  where `id`='2' ";
				    mysqli_query($con,$psql); 

				    //data update on this month
				    $csql="UPDATE `log_sms_count` SET `total_send`=(`total_send`+ '".$hits."') ,  `count_sms`=(`count_sms`- '".$hits."') , `curr_month`=(`curr_month`+ '".$hits."') , `modify_date`='$modify_date'  where `id`='2' ";
				    mysqli_query($con,$csql); 

				}
				//-------------make counting log-------------------------
				
				$message = str_replace(' ', '%20', $msg);
				// $message = urlencode($msg);
				// $url='https://sms.infrainfotech.com/sms-panel/api/http/index.php?username=ISOFTSMS&apikey=F47D2-27A1C&apirequest=Text';
				// $sender_id='ISCTDT';
		        $route_name='TRANS';
		        // $template_id=get_textsms_by_msgtype($messagetype)['temp_id'];
		        // get_text_sms_setting(){

				$api_url=get_text_sms_setting()['api_url'];
				$sender_id=get_text_sms_setting()['sender_id'];
				$api_key=get_text_sms_setting()['api_key'];
				$template_id=get_textsms_by_msgtype($messagetype)['temp_id'];
	
				//change apirequest for hindi language
				$regex = '~^[a-zA-Z0-9_ !-@#$%^&*|\/)(]+$~';
				if(!preg_match($regex, $message)) {
					$request="Unicode";  //hindi
				} else {
					$request="Text";   //english
				}	
				if(!empty($api_url) && !empty($api_key) && !empty($request) && !empty($sender_id) && !empty($mobile) && !empty($message) && !empty($route_name) && !empty($template_id) ){

				 echo $complete_u=$api_url.'&apikey='.$api_key.'&apirequest='.$request.'&sender='.$sender_id.'&mobile='.$mobile.'&message='.$message.'&route='.$route_name.'&TemplateID='.$template_id.'&format=JSON';

				}else{
					$complete_u='';
				}

				$curl1 = curl_init();
				curl_setopt_array($curl1, array(
				CURLOPT_URL =>$complete_u,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_FAILONERROR=> true,
				CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache"
				),
				
				));
				   $SMSresponse1 = curl_exec($curl1);
					
				   $msg=json_decode($SMSresponse1,true);
				// print_r($msg);
				if($msg['status']=='error'){
					// echo "message not send;";
				}else{
					// echo "message sent sucessfully";
				}
				// echo $SMSresponse1->status;
				$err = curl_error($curl1);
				
				if($err) {
				   // echo "<br>cURL Error #: $err";
				}else{
					return "success";
				}
				curl_close($curl1);
		
		}else{
			return "";
		}
		
	}	
		


		



// function sendWhatsApp($phone, $msg){
//     // $ins_id="638789B490EE9";
// 	  $ins_id="63A289D1014B6"; 
//     $country='91';
//     // $phone='7004083341';
//     $curl1 = curl_init();
//     curl_setopt_array($curl1, array(
//     CURLOPT_URL => 'https://ziper.io/api/send.php?number='.$country.''.$phone.'&type=text&message='.$msg.'&instance_id='.$ins_id.'&access_token=0a6e36d8f847f3feeefb53807265173f',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "GET",
//     CURLOPT_HTTPHEADER => array(
//     "cache-control: no-cache"
//     ),
//     ));
//     $SMSresponse1 = curl_exec($curl1);
//     $err = curl_error($curl1);
//     curl_close($curl1);
// }

