<?php
include('connection.php');
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
function get_textsms_byid($id){
	$response=array();

	global $con;
	$quec=$con->query("SELECT * FROM `textsms_templates` WHERE `status`='1' AND `id`='$id' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['id']=$resc['id'];
		$response['msg_type']=$resc['msg_type'];
		$response['temp_id']=$resc['temp_id'];
		$response['title']=$resc['title'];
		$response['description']=$resc['description'];

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
function get_sms_setting_byid($id){
	$response=array();
	global $con;
	$quec=$con->query("select * from sms_setting where `sms_id`='$id'  ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['sender_id']=$resc['sender_id'];
		$response['api_key']=$resc['api_key'];
		$response['status']=$resc['status'];
		
		return $response;
    }else{
    	return "";
    }

}
function get_whatsapp_sms_setting(){
	$response=array();
	global $con;
	$quec=$con->query("select * from sms_setting where `sms_id`='2'  ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['sender_id']=$resc['sender_id'];
		$response['api_key']=$resc['api_key'];
		$response['status']=$resc['status'];
		
		return $response;
    }else{
    	return "";
    }

}
function get_text_sms_setting(){
	$response=array();
	global $con;
	$quec=$con->query("select * from sms_setting where `sms_id`='1' ");
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$response['sender_id']=$resc['sender_id'];
		$response['api_url']=$resc['api_url'];
		$response['api_key']=$resc['api_key'];
		$response['status']=$resc['status'];
		
		return $response;
    }else{
    	return "";
    }
}
function get_financial_year(){
	$months = array(1=> 'April', 2 => 'May',  3=> 'June', 4 => 'July', 5 => 'August', 6 => 'September', 7 => 'October', 8 => 'November', 9=> 'December',10 => 'January', 11=> 'February', 12 => 'March', ); 
	return $months;
}
function get_general_year(){
	$months = array(4=> 'April', 5 => 'May',  6=> 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12=> 'December',1 => 'January', 2=> 'February', 3 => 'March', ); 
	return $months;
}
function get_no_remaining_months($starting_month){ //input general year

    if($starting_month==1){
        $x=13;
    }elseif($starting_month==2){
        $x=14;
    }elseif($starting_month==3){
        $x=15;
    }else{
        $x=$starting_month;
    }
    for($i=$x; $i<=15; $i++){
        $arr[]=$i;
    }    
    return count($arr);
}


 function gettermName($id,$con){	$query= $con->query("select `name` from  `parent_exam` where id='".$id."'");    if($query->num_rows>0){	$Row= $query->fetch_assoc();     $term_name=$Row['name'];		 return $term_name;			}		  }
       //Send message via whatsapp
		// $whatsapp_query=mysqli_query($con,"select * from sms_setting where `sms_id`='2' and `status`=
		// 	1' ");
		// $rwhatsapp_query=mysqli_fetch_array($whatsapp_query);
		// $instance_id=$rwhatsapp_query['sender_id'];
		// $tokenid=$rwhatsapp_query['api_key'];
		// $status=$rwhatsapp_query['status'];
		
	function sendwhatsappMessage($mobile, $msgg, $messagetype,$pathimg=''){
		/*date_default_timezone_set("Asia/Kolkata");
		global $con;
		if(is_array($mobile)){
			$hits=count($mobile);
			$mobile=implode(',',$mobile);
		}else{
			$hits=1;
			$mobile=$mobile;
		}

		// echo $mobile;
		// echo $msgg;
		// die;
		
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
			if(!empty($pathimg)){  //if attachment is sending
				$filename=basename($pathimg);
				$completeurl="https://ziper.io/api/send.php?number=91".$mobile."&type=media&message=".$message."&media_url=".$pathimg."&filename=".$filename."&instance_id=".$instance_id."&access_token=".$tokenid;
			}else{
			   $completeurl="https://ziper.io/api/send.php?number=91".$mobile."&type=text&message=".$message."&instance_id=".$instance_id."&access_token=".$tokenid;
			}
			
			$curl1 = curl_init();
			curl_setopt_array($curl1, array(
			CURLOPT_URL =>$completeurl,
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
		*/
	}
	

		
			
	
//Send message via whatsapp
/*
// send whatsapp by image
function sendwhatsappMessage_Image($mobile, $msgg, $messagetype,$pathimg,$filename){
	date_default_timezone_set("Asia/Kolkata");
	global $con;
	if(is_array($mobile)){
		$hits=count($mobile);
		$mobile=implode(',',$mobile);
	}else{
		$hits=1;
		$mobile=$mobile;
	}

	// echo $mobile;
	// echo $msgg;
	// die;
	
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
		// echo $completeurl="https://ziper.io/api/send.php?number=91.$mobile.'&type=text&message='.$message.'&instance_id='.$instance_id.'&access_token='.$tokenid";
		$message = str_replace(' ', '%20', $msg);
		$completeurl="https://ziper.io/api/send.php?number=91".$mobile."&type=media&message=".$message."&media_url=".$pathimg."&filename=".$filename."&instance_id=".$instance_id."&access_token=".$tokenid;
	
		
		
		$curl1 = curl_init();
		curl_setopt_array($curl1, array(
		CURLOPT_URL =>$completeurl,
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
*/




//Send text message
		// $set=mysqli_query($con,"select * from sms_setting where sms_id= 1 ");
		// $rset=mysqli_fetch_array($set);
		// $apiurl=$rset['api_url'];
		// $senderid=$rset['sender_id'];
		// $apikey=$rset['api_key'];
		
	function sendtextMessage($mobile, $msg, $messagetype){
		/*date_default_timezone_set("Asia/Kolkata");

		global $con;
	
		if(is_array($mobile)){
			$hits=count($mobile);
			$remain_sms=get_log_sms_count_byid(2)['count_sms'];  //send only remaining sms
			if($remain_sms>=$hits){ 		//if hits is greater then remaining sms then it,s will be trimed
				$mobile=implode(',',$mobile);
			}else{
				$not_send=$hits-$remain_sms;
				$hits=count($mobile);
				$mobile=array_slice($mobile, 0, $remain_sms);  
				$mobile=implode(',',$mobile);
				
			}
			
		}else{
			$hits=1;
			$mobile=$mobile;
		}
		
		if((get_log_sms_count_byid(2)['count_sms'] > 0)  &&  !empty(get_textsms_by_msgtype($messagetype)['temp_id']) && get_text_sms_setting()['status']==1 ){ 
		
		
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
			// $url='http://sms.infrainfotech.com/sms-panel/api/http/index.php?username=ISOFTSMS&apikey=F47D2-27A1C&apirequest=Text';
			// $sender_id='ISCTDT';
	        $route_name='TRANS';
	        
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
	          $complete_u=$api_url.'&apikey='.$api_key.'&apirequest='.$request.'&sender='.$sender_id.'&mobile='.$mobile.'&message='.$message.'&route='.$route_name.'&TemplateID='.$template_id.'&format=JSON';

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
				CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache"
				),
				));
			   $SMSresponse1 = curl_exec($curl1);
				
			   $msg=json_decode($SMSresponse1,true);
			if($msg['status']=='error'){
				// echo "message not send;";
			}else{
				// echo "message sent sucessfully";
			}
			// echo $SMSresponse1->status;
			$err = curl_error($curl1);
			
			if($err) {
			//    echo "<br>cURL Error #: $err";
			}else{
				return "success";
			}
			curl_close($curl1);
		
		}else{
			return "";
		}*/
		
	}

	function SendEmail($Email, $subject, $message,$from){
 // global $mail;
		/*require_once 'PHPMailer/class.smtp.php';
        require 'PHPMailer/class.phpmailer.php';
        $mail = new PHPMailer;    //make object
        // SMTP configuration
        //$mail->isSMTP();
        $mail->Host = 'phindbooks.ae';
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 1;  
        $mail->Username = 'developer@phindbooks.ae';
        $mail->Password = 'Developer@#123$';
        $mail->SMTPSecure = 'TSL';
        $mail->Port = 465;
        $mail->setFrom('developer@phindbooks.ae' );
        $mail->addReplyTo('info@phindbooks.ae', );

        // Add a recipient
        $mail->addAddress($Email);
        //$mail->addAddress('govindakumar3865@gmail.com');
        // Add cc or bcc 
        //$mail->addCC('test@gmail.com');
        //$mail->addBCC('test@gmail.com');
        // Email subject
        $mail->Subject = $subject;
        // Set email format to HTML
        $mail->isHTML(true);
        // Email body content
        $mailContent = $message;
        // for send an attatchment    
        //$path       = "../work-report/";
        //$file_name  = $newfilename;
        $mail->Body = $mailContent;
        //$mail->addAttachment($path.$file_name); 
        $mail->SMTPOptions = array(
        'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true
         )
        );
        // Send email
        if(!$mail->send()){
        
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            $response = array(
                "type" => "error"
            );
        }else{
        
            $response = array(
                "type" => "successful",
            );
        }
    return $response;*/
    }

function get_school_details(){
	$response=array();
	global $con;
	$quec=mysqli_query($con,"select * from setting "); //where company_id='1'
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['company_name']=$resc['company_name'];
	$response['company_short_name']=$resc['company_short_name'];
	$response['registration_number']=$resc['registration_number'];
	$response['affiliation_number']=$resc['affiliation_number'];
	
	$response['company_address']=$resc['company_address'];
	$response['company_email']=$resc['company_email'];
	$response['company_number']=$resc['company_number'];
	$response['company_image']=$resc['company_image'];
	if(!empty($resc['company_image']) && file_exists("images/profile/".$resc['company_image'])){
		$response['company_image_path']='images/profile/'.$resc['company_image'];
	}else{
		$response['company_image_path']='';
	}
	// $response['company_image_path']='images/profile/'.$resc['company_image'];
	$response['show_email']=$resc['show_email'];
	$response['show_number']=$resc['show_number'];
	$response['watermark']=$resc['watermark'];

	return $response;
    }else{
    	return "";
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
function get_admission_byid($admid){
	$response=array();
	global $con;
	$quec=$con->query("select * from `admission` where admission_id='$admid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['phone']=$resc['phone'];

	return $response;

    }else{
    	return "";
    }
}
function get_grade_byid($grade_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from `grade` where grade_id='$grade_id'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['grade_name']=$resc['grade_name'];

	return $response;

    }else{
    	return "";
    }
}
function get_grade_by_percent($per1,$per2){
	$response=array();
	global $con;
	$quec=$con->query("select * from grade where condition1 <='$per1' && condition2 >='$per2'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['grade_name']=$resc['grade_name'];

	return $response;

    }else{
    	return "";
    }
}

function get_message_type_byid($msgid){
	$response=array();
	global $con;
	$quec=$con->query("select * from message_type where msg_type_id='$msgid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['msg_name']=$resc['msg_name'];

	return $response;

    }else{
    	return "";
    }
}

function get_religion_byid($regid){
	$response=array();
	global $con;
	$quec=$con->query("select * from religion where religion_id ='$regid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['religion_name']=$resc['religion_name'];

	return $response;

    }else{
    	return "";
    }
}
function get_social_category_byid($scid){
	$response=array();
	global $con;
	$quec=$con->query("select * from social_category where soc_cat_id='$scid'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['soc_cat_name']=$resc['soc_cat_name'];

	return $response;
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

		$only_year=explode('-',$resc['year']);
		$response['only_year']=$only_year[0];
	return $response;
    }else{
    	return "";
    }
}
function getAttendendeType($short_name){
    $response=array();
	global $con;
	$quec=$con->query("select * from `attendance_type` where `short_name`='$short_name'");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['att_type_name']=$resc['att_type_name'];

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
	$response['student_name']=$resc['student_name'];
	$response['admission_nos']=str_pad($resc['admission_no'], 4 , "0", STR_PAD_LEFT);

	$response['register_no']=$resc['register_no'];
	$response['msg_type_id']=$resc['msg_type_id'];
	$response['admission_date']=$resc['admission_date'];
	$response['roll_no']=$resc['roll_no'];
	$response['gender']=$resc['gender'];
	$response['parent_no']=$resc['parent_no'];
	$response['stu_image']=$resc['stu_image'];
	if(!empty($resc['stu_image']) && file_exists('images/student/'.str_replace('/','-',$resc['register_no']).'/'.$resc['stu_image'])){
		$response['stu_image_path']='images/student/'.str_replace('/','-',$resc['register_no']).'/'.$resc['stu_image'];
	}else{
		$response['stu_image_path']='images/no_image.png';
	}

	return $response;
    }else{
    	return "";
    }
}
function getStudent_byAdmission_id($admission_id){
    $response=array();
	global $con;
	$quec=$con->query("select * from `admission` where `admission_id`='$admission_id' ");
	if($quec->num_rows > 0){
		$res=$quec->fetch_assoc();
		$response['admission_id']=$res['admission_id'];
		$response['name']=$res['name'];
		$response['fathername']=$res['fathername'];
		$response['gender']=$res['gender'];
		$response['dob']=$res['dob'];
		$response['email']=$res['email'];
		$response['phone']=$res['phone'];
		$response['aadhar']=$res['aadhar'];
		$response['qualification'] = $res['qualification'];
		$response['address'] = $res['address'];
		$response['city']=$res['city'];
		$response['pincode']=$res['pincode'];
		$response['state']=$res['state'];
		$response['religion']=$res['religion'];
		$response['grade']=$res['grade'];
		$response['previous_school']=$res['previous_school'];
		$response['status']=$res['status'];
		$response['student_id']=$res['student_id'];
	return $response;
    }else{
    	return "";
    }
}
function get_student_records_by_stuid($stu_id){
	$response=array();
	global $con;
	$quec=$con->query("select * from `student_records` where `stu_id`='$stu_id' and session='".$_SESSION['session']."' ");
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['id']=$resc['id'];
	$response['class_id']=$resc['class_id'];
	$response['section_id']=$resc['section_id'];
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
	// $sql="select * from `students` where `student_id`='$student_id' and session='$session' and `msg_type_id`='1'  ";
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
	// $sql="select * from `students` where `student_id`='$student_id' and session='$session' and `msg_type_id`='2'  ";
	// add msg type later when whatsup enable
	$sql="select `student_name`,`register_no`,`parent_no` from `students` as s join student_records as sr on s.student_id=sr.stu_id where `student_id`='$student_id' and sr.session='$session'   ";
	
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

function get_leave_type_byid($id){
    $response=array();
	global $con;
	$sql="select * from leave_type where leave_id='$id'";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['leave_id']=$resc['leave_id'];
	$response['leave_name']=$resc['leave_name'];

	return $response;
    }else{
    	return "";
    }
}
function get_stu_daily_attendence_byid($id){
    $response=array();
	global $con;
	$sql="select * from `student_daily_attendance` where student_att_id='$id'";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
	$resc=$quec->fetch_assoc();
	$response['student_id']=$resc['student_id'];
	$response['class_id']=$resc['class_id'];
	$response['section_id']=$resc['section_id'];
	$response['type_of_attend']=$resc['type_of_attend'];
	$response['reason']=$resc['reason'];
	$response['date']=$resc['date'];

	return $response;
    }else{
    	return "";
    }
}
function get_new_admission_no(){
	global $con;
	$sql1="select student_id,admission_no from students  where admission_no!=''  order by student_id desc limit 1";
	$q2 = mysqli_query($con,$sql1);
	$row2 = mysqli_num_rows($q2);
	$r2 = mysqli_fetch_assoc($q2);
	if($row2 > 0){
		$admsn_no = ltrim($r2['admission_no'],'0');
		// $admission_no = str_pad(intval($admsn_no) + 1, 4 , "0", STR_PAD_LEFT);
		$admission_no = intval($admsn_no) + 1;
	}else{
		$admission_no = "0001";
	}
	return $admission_no;
}
function get_student_route_bystuid($stu_id,$session){
	global $con;
	$sql1="select * from `student_route` where student_id='$stu_id' and `session`='$session' ";
	$q2 = mysqli_query($con,$sql1);
	if(mysqli_num_rows($q2)){
		$r2 = mysqli_fetch_assoc($q2);
		$response['trans_id']=$r2['trans_id'];
		$response['price']=$r2['price'];
		$response['no_of_months']=$r2['no_of_months'];
		$response['fee_start_month']=$r2['fee_start_month'];
		$response['create_date']=$r2['create_date'];

		return $response;
	}else{
		return '';
	}
}
function get_months_byid($month_id){
	global $con;
	$sql1="select * from `months` where fee_order_month='$month_id' ";
	$q2 = mysqli_query($con,$sql1);
	if(mysqli_num_rows($q2)){
		$r2 = mysqli_fetch_assoc($q2);
		$response['fee_order_month']=$r2['fee_order_month'];
		$response['month_name']=$r2['month_name'];
		return $response;
	}else{
		return '';
	}
}
function get_route_name($trans_id){
	global $con;
	$sql1="select `route_name` from `transports` where trans_id='$trans_id' ";
	$q2 = mysqli_query($con,$sql1);
	if(mysqli_num_rows($q2)){
		$r2 = mysqli_fetch_assoc($q2);
		$response['route_name']=$r2['route_name'];
		
		return $response['route_name'];
	}else{
		return '';
	}
}
//Android push notifications
function push_notification_android($device_id,$Title, $Remarks,$type=''){
	return false;
	//API URL of FCM
	/*$url = 'https://fcm.googleapis.com/fcm/send';

	$api_key = 'AAAAsLIm0Hs:APA91bEhnFkeaBmtoJ9UxdYN6v_BuUMdP1cIXAs9DPdfsbsaDWij-QEMzfwSXk_sxcFkyYERHz2jTM90iVa0Cfo8-NAUyIqB9PqBB-WDNb_yt-8P0cBtlYJTitX9UvLBFiyf4o_wvYNR';
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
	return $result;*/
}
   //Android push notification start end


   function send_push_notification($msg_type, $token_id,$MsgArray=''){
	$response=array();
	// global $con;
	switch($msg_type){
		
		case 'push_announcement';
			$Title="New Announcement has been received ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_message';
			$resp=push_notification_android($token_id,$Title, $Remarks,$type);
		break;
		case 'push_assignment';
			$Title="Assignment/Homework has been received ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_message';
			$resp=push_notification_android($token_id,$Title, $Remarks,$type);
		break;
		case 'push_message';
			$Title="Message has been received ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_message';
			$resp=push_notification_android($token_id,$Title, $Remarks,$type);
		break;

		case 'push_gallery';
			$Title="New Gallery has been created ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_gallery';
			$resp=push_notification_android($token_id,$Title, $Remarks,$type);
		break;

		case 'push_important_info';
			$Title="Important Information has been received ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_message';
			$resp=push_notification_android($token_id,$Title, $Remarks,$type);
		break;

		case 'push_study_material';
			$Title="Study Materials has been received ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_message';
		    push_notification_android($token_id, $Title, $Remarks, $type);
		break;
		case 'push_attendance';
			$Title="Attendance Taken Today. ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_attendance';
		    push_notification_android($token_id, $Title, $Remarks, $type);
		break;

		case 'push_attendance_update';
			$Title="Your Attendance Updated. ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_attendance';
		    push_notification_android($token_id, $Title, $Remarks, $type);
		break;

		case 'push_fee_collect';
			$Title="School Fees received Sucessfully ";
			$Remarks='Regards : '.get_school_details()['company_name'];
			$type='notification_attendance';
		    push_notification_android($token_id, $Title, $Remarks, $type);
		break;

	}
}


//This is for Custom/Variable Messages
		// if(!empty($msg)){
		// 	$msg = $msg;
		// }
		// else{
		// 	if($messagetype=='fee_paid'){
		// 		$msg =$msg; 
		// 	}elseif($messagetype=='announcement'){
		// 		$msg = $msg; 
				
		// 	}elseif($messagetype=='assignment'){
		// 		$msg = $msg;
		// 	}elseif($messagetype=='messages'){
		// 		$msg =$msg;
				
		// 	}elseif($messagetype=='important_information'){
		// 		$msg =$msg;
		// 	}elseif($messagetype=='staff_notification'){
		// 		$msg = $msg;
		// 	}elseif($messagetype=='custome_announcement'){
		// 		$msg = $msg;
		// 	}elseif($messagetype=='custome_message'){
		// 		$msg = $msg;
			
		// 	}elseif($messagetype=='student_attendance'){
		// 			$msg = $msg; 

		// 	}elseif($messagetype=='create_test'){
		// 		$msg = $msg; 
				
		// 	}elseif($messagetype=='update_test'){
		// 		$msg = $msg; 
				
		// 	}elseif($messagetype=='send_result'){
		// 		$msg = $msg;
		// 	}elseif($messagetype=='transport_fee_paid'){
		// 		$msg = $msg;
		// 	}elseif($messagetype=='remedy_message'){
		// 		$msg = $msg;
		// 	}elseif($messagetype=="online_addmission"){
		// 		$msg=$msg;
		// 	}elseif($messagetype=="request_addmission"){
		// 		$msg=$msg;
		// 	}
		// 	elseif($messagetype="due_fees_remainder"){
		// 		$msg=$msg;
		// 	}
		// 	elseif($messagetype="Add_driver"){
		// 		$msg=$msg;
		// 	}elseif($messagetype="Update_driver"){
		// 		$msg=$msg;
		// 	}
			
			// if($messagetype='fee_paid'){
			// 	$msg = $msg;
			// }else if($messagetype='announcement'){
			// 	$msg = $msg;
			// }else if($messagetype='assignment'){
			// 	$msg = $msg;
			// }else if($messagetype='messages'){
			// 	$msg = $msg;
			// }else if($messagetype='important_information'){
			// 	$msg = $msg;
			// }else if($messagetype='staff_notification'){
			// 	$msg = $msg;
			// }else if($messagetype='custome_announcement'){
			// 	$msg = $msg;
			// }else if($messagetype='custome_message'){
			// 	$msg = $msg;
			// }else if($messagetype='student_attendance'){
			// 	$msg = $msg;
			// }else if($messagetype='create_test'){
			// 	$msg = $msg;
			// }else if($messagetype='update_test'){
			// 	$msg = $msg;
			// }else if($messagetype='send_result'){
			// 	$msg = $msg;
			// }else if($messagetype='transport_fee_paid'){
			// 	$msg = $msg;
			// }else if($messagetype='remedy_message'){
			// 	$msg = $msg;
			// }	



?>