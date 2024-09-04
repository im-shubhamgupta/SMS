<?php include('../myfunction.php')?>
<?php 

date_default_timezone_set('Asia/Kolkata');



if(isset($_POST['CommunicationSMS'])){


// echo "<pre>";
// print_r($_POST);
// echo "<pre>";

$Tcount=get_text_sms_count()['count_sms'];
$Wcount=get_whatsapp_sms_count()['count_sms'];
$Wstatus=get_whatsapp_sms_setting()['status'];
$Tstatus=get_text_sms_setting()['status'];

   $email=$_SESSION['user_logged_in'];
   $username=$_SESSION['user_roles'];
   $category=$_POST['category'];
   $check=$_POST['check'];
   $charcount=$_POST['charcount'];
   $stucount=$_POST['stucount'];

 
    $x=1;
if($_POST['category']=='1'){


	 $subject=$_POST['subject'];
	 $heading_announce=$_POST['heading_announce'];
	$compose=$_POST['composetext1'];
	
	
	$csql1 ="select `student_id`,`msg_type_id`,`token_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' && sr.session='".$_SESSION['session']."'";
	 $que = mysqli_query($con,$csql1);

	$row = mysqli_num_rows($que);

	if($row){

		$action = "Announcement Sent."; 
		$messagetype = "announcement";
		// $heading='Announcement';

	if(!($Wcount>=$row)){
			$Responce['status']="error";
		   $Responce['message']="You have Insufficient SMS Limit<br>Whatsapp sms: ".$Wcount." ";

		   echo json_encode($Responce);die;
	}elseif($Wstatus=='0' ){
		   $Responce['status']="error";
		   $Responce['message']="Please turn on your SMS service";

		   echo json_encode($Responce);die;
	}	

	
	while($resz=mysqli_fetch_array($que)){		

		$msgtype=$resz['msg_type_id'];

		$studid=$resz['student_id'];
		$section=$resz['section_id'];
		$classid=$resz['class_id'];
		$mobile=$resz['parent_no'];
		$token_id=$resz['token_id'];

		// if($check){

			if($msgtype==1){
				
				$sql1="insert into student_notifications(category,student_id,class_id,section_id,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session)
					   values('$category','$studid','$classid','$section','$mobile','$heading_announce','$compose','1','$username',now(),now(),'".$_SESSION['session']."')";
					$q1=mysqli_query($con,$sql1);
				$encod=urlencode($compose);
				sendwhatsappMessage($mobile, $encod, $messagetype);
			}else{
				$sql2="insert into student_notifications(category,student_id,class_id,section_id,selected_no,heading,message,loginuser,notice_datetime,date,session)
					   values('$category','$studid','$classid','$section','$mobile','$heading_announce','$compose','$username',now(),now(),'".$_SESSION['session']."')";
					$q2=mysqli_query($con,$sql2);
			}
			

			// -----------------send push notification for each parent----------------------	
			          
			if(!empty($token_id)){
				$msg_type='push_announcement';
				send_push_notification($msg_type, $token_id);
			}
				 
		  
		  // -----------------send push notification for each parent----------------------	











			//send push notification------------------------------------------------

			    $log_bulk_sms=mysqli_query($con," INSERT INTO `log_bulk_sms`(`loginuser`, `section`, `create_date`,`session` ) VALUES ('".$_SESSION['user_roles']."','Student Communication','".date('Y-m-d H:i:s')."','".$_SESSION['session']."') ");

	}
	   if($q1){
			$Responce['status']="success";
		   $Responce['message']="SMS send Successfuly";
		}else{
			$Responce['status']="error";
		   $Responce['message']="Somethings Went Wrong, Please try again";

		}




   }else{
   	   $Responce['status']="error";
		   $Responce['message']="Students not found";
   }

	
		 echo json_encode($Responce); die;	




}    
// ==========================================================================================
// Homework 
if($_POST['category']=='2'){
// echo "<pre>";
// print_r($_POST);	
// echo "</pre>";	


$class_id=$_POST['classid1'];
$section_id=$_POST['section1'];
$compose=$_POST['composetext2'];
$insert_sms=mysqli_real_escape_string($con,$_POST['composetext2']);
$subject=$_POST['subject'];
$heading=$_POST['heading2'];
// $subject_name=get_subject_byid($subject)['subject_name'] ?? 'ALL' ;

		
		 $csql2 ="select `student_id`,`msg_type_id`,`token_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' and sr.class_id='$class_id' and sr.section_id='$section_id'  && sr.session='".$_SESSION['session']."'";
	   $que = mysqli_query($con,$csql2);

		$row = mysqli_num_rows($que);

		if($row){
			if(!($Wcount>=$row)){
			$Responce['status']="error";
		   $Responce['message']="You have Insufficient SMS Limit<br>Whatsapp sms: ".$Wcount." ";
		   echo json_encode($Responce);die;

	   }elseif($Wstatus=='0' ){
		   $Responce['status']="error";
		   $Responce['message']="Please turn on your SMS service";

		   echo json_encode($Responce);die;
	   }	

			$cl = mysqli_query($con,"select * from class where class_id='$class_id'");

			$rcl = mysqli_fetch_array($cl);

			$clname = $rcl['class_name'];

			$se = mysqli_query($con,"select * from section where section_id='$section_id'");

			$rse = mysqli_fetch_array($se);

			$sename = $rse['section_name'];

			$action = "Homework Sent to Class ".$clname." Section ".$sename."."; 

			$messagetype = "assignment";
			//upload images----------------------------------------------------------
			$rand_time=time();
			$name1 = $_FILES["file22"]["name"];

				$img_name1 = $_FILES['file22']['name'];

				$imgstr = implode(",", $img_name1);
					if($imgstr!=""){
						$mul_img2=array();
						
						foreach ($_FILES["file22"]["error"] as $key => $error){

								if ($error == UPLOAD_ERR_OK){

									$tmp_name1 = $_FILES["file22"]["tmp_name"][$key];

									$name1 = $_FILES["file22"]["name"][$key];
									$name=explode('.',$name1);
									$ext=pathinfo($name1,PATHINFO_EXTENSION);
									$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
									// $image_name=$name[0].'_'.$rand_time.'.'.$ext;
									$mul_img2[]=$image_name;

									if(move_uploaded_file($tmp_name1, "../images/assignment/$image_name")){
										$image_uploaded=true;
									}else{
										$image_uploaded=false;
									} 
								}
						}
						$imgagestr = implode(', ', $mul_img2);
					}else{
						$imgagestr = '';
					} 
		
			//upload images----------------------------------------------------------		
			if($image_uploaded){		
				while($resz=mysqli_fetch_array($que)){		

					$msgtype=$resz['msg_type_id'];

					$studid=$resz['student_id'];
					$section=$resz['section_id'];
					$classid=$resz['class_id'];
					$mobile=$resz['parent_no'];
					$token_id=$resz['token_id'];

					

						
						$q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,attachment,msg_type,loginuser,notice_datetime,date,session)
						values('$category','$studid','$classid','$section','$subject','$mobile','$heading','$insert_sms','$imgagestr','1','$username',now(),now(),'".$_SESSION['session']."')");
					
					if($msgtype=='1'){
						
						$encod=urlencode($compose);
						$pathh=dirname($baseurl);
						$pathimage=$pathh.'/images/assignment/'.$imgagestr;
						// sendwhatsappMessage_Image($mobile, $encod, $messagetype, $pathimage, $imgagestr);
						sendwhatsappMessage($mobile, $encod, $messagetype, $pathimage);
						
					}
					// -----------------send push notification for each parent----------------------	
					
						
						if(!empty($token_id)){
							$msg_type='push_assignment';
							send_push_notification($msg_type, $token_id);
						}
				
				
				// -----------------send push notification for each parent----------------------	

					$log_bulk_sms=mysqli_query($con," INSERT INTO `log_bulk_sms`(`loginuser`, `section`, `create_date`,`session` ) VALUES ('".$_SESSION['user_roles']."','Student Communication','".date('Y-m-d H:i:s')."','".$_SESSION['session']."') ");

			    }//while
					if($q1){
						$Responce['status']="success";
					    $Responce['message']="SMS send Successfuly";
					}else{
						$Responce['status']="error";
					    $Responce['message']="Somethings Went Wrong, Please try again";
					}
			}else{
				$Responce['status']="error";
				$Responce['message']="Problems on image uploading,Please Try again";
			}		

      }else{

      	 $Responce['status']="error";
		   $Responce['message']="Students not found";
      }
  
			
				 echo json_encode($Responce); die;	

 }
// ==========================================================================================
if($_POST['category']=='3'){

	$compose=$_POST['composetext3'];
	$class_id=$_POST['classid2'];
	$section_id=$_POST['section2'];
	$heading3=$_POST['heading3'];
	$composetext3=$_POST['composetext3'];

   // $cat="select * from students where stu_status='0' and class_id='$class_id' and section_id='$section_id'  && session='".$_SESSION['session']."'";
   $cat ="select `student_id`,`msg_type_id`,`token_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' and sr.class_id='$class_id' and sr.section_id='$section_id'  && sr.session='".$_SESSION['session']."'";
	
	$que=mysqli_query($con,$cat);

		$row = mysqli_num_rows($que);

		if($row){
			if(!($Wcount>=$row)){
				$Responce['status']="error";
			   $Responce['message']="You have Insufficient  SMS Limit<br>Whatsapp sms: ".$Wcount." ";

			   echo json_encode($Responce);die;
	      }elseif($Wstatus=='0' ){
				   $Responce['status']="error";
				   $Responce['message']="Please turn on your SMS service";

				   echo json_encode($Responce);die;
	      }	

			$cl = mysqli_query($con,"select * from class where class_id='$class_id'");
			$rcl = mysqli_fetch_array($cl);
			$clname = $rcl['class_name'];

			$se = mysqli_query($con,"select * from section where section_id='$section_id'");
			$rse = mysqli_fetch_array($se);
			$sename = $rse['section_name'];

			$action = "Message Sent to Class ".$clname."Section ".$sename.".";
			$messagetype = "messages";

			while($resz=mysqli_fetch_array($que)){		

				$msgtype=$resz['msg_type_id'];
				$studid=$resz['student_id'];
				$section=$resz['section_id'];
				$classid=$resz['class_id'];
				$mobile=$resz['parent_no'];
				$token_id=$resz['token_id'];

				$sql3="insert into student_notifications(category,student_id,class_id,section_id,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values('$category','$studid','$classid','$section','$mobile','$heading3','$compose','1','$username',now(),now(),'".$_SESSION['session']."')";
						$q1=mysqli_query($con,$sql3);
						     

				if($msgtype==1){
					// echo "category message";
					 
				   
				
					$encod=urlencode($compose);
					sendwhatsappMessage($mobile, $encod, $messagetype);

				
				    $log_bulk_sms=mysqli_query($con," INSERT INTO `log_bulk_sms`(`loginuser`, `section`, `create_date`,`session` ) VALUES ('".$_SESSION['user_roles']."','Student Communication','".date('Y-m-d H:i:s')."','".$_SESSION['session']."') ");

				}
				// -----------------send push notification for each parent----------------------	
				
					if(!empty($token_id)){
						$msg_type='push_message';
						send_push_notification($msg_type, $token_id);
					}
		   // -----------------send push notification for each parent----------------------
			

			}//while
			if($q1){
				$Responce['status']="success";
			   $Responce['message']="SMS send Successfuly";
			}else{
				$Responce['status']="error";
			   $Responce['message']="Somethings Went Wrong, Please try again".mysqli_error($con);

			}
			   

		}else{

      	 $Responce['status']="error";
		   $Responce['message']="Students not found";
      }
	
	 echo json_encode($Responce); die;	
}		
// ====================================================================================
if($_POST['category']=='4'){   //gallery

	$classid=$_POST['classid3'];
	$section=$_POST['section3'];
	$heading=$_POST['heading'];
	$message4=$_POST['message4'];

		if($classid=="All" && $section=="All"){

			// $quen=mysqli_query($con,"select * from students where stu_status='0'  && session='".$_SESSION['session']."' ");
			$csql4 ="select `student_id`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0'  && sr.session='".$_SESSION['session']."'";
			$quen=mysqli_query($con,$csql4);

				$clname = "All";

				$sename = "All";

		}elseif($classid!="" && $section=="All"){

			// $quen=mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid'  && session='".$_SESSION['session']."'");	
			$csql4 ="select `student_id`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' and `sr`.`class_id`='$classid'   && sr.session='".$_SESSION['session']."'";
			$quen=mysqli_query($con,$csql4);

				$cl = mysqli_query($con,"select * from class where class_id='$classid'");

				$rcl = mysqli_fetch_array($cl);

				$clname = $rcl['class_name'];

				$sename = "All";

		}else{
		
		
			$csql4 ="select `student_id`,`token_id`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' and `sr`.`class_id`='$classid' and `sr`.`section_id`='$section'    && sr.session='".$_SESSION['session']."'";
			$quen=mysqli_query($con,$csql4);

				$cl = mysqli_query($con,"select * from class where class_id='$classid'");

				$rcl = mysqli_fetch_array($cl);

				$clname = $rcl['class_name'];

				

				$se = mysqli_query($con,"select * from section where section_id='$section'");

				$rse = mysqli_fetch_array($se);

				$sename = $rse['section_name'];

		}


				$row = mysqli_num_rows($quen);

				if($row){

					$action = "Photo Gallery Sent to Class ".$clname." Section ".$sename."."; 

					$messagetype = "photogallery";

				// if(!($Wcount>=$row)){
				// 	$Responce['status']="error";
				//    $Responce['message']="You have Insufficient  SMS Limit<br>Whatsapp sms: ".$Wcount." ";

				//    echo json_encode($Responce);die;
	         // }	


			
		while($resz1=mysqli_fetch_array($quen)){

			$mul_img2=array();

			$msgtype=$resz1['msg_type_id'];

			$studid=$resz1['student_id'];

			$classid=$resz1['class_id'];

			$section=$resz1['section_id'];

			$mobile=$resz1['parent_no'];
			$token_id=$resz1['token_id'];
		
			$name1 = $_FILES["file1"]["name"];

			$img_name1 = $_FILES['file1']['name'];

			$imgstr = implode(",", $img_name1);
			

				if($imgstr!=""){
					foreach ($_FILES["file1"]["error"] as $key => $error){

							if ($error == UPLOAD_ERR_OK){

								$tmp_name1 = $_FILES["file1"]["tmp_name"][$key];

								$name1 = $_FILES["file1"]["name"][$key];
								// move_uploaded_file($tmp_name1, "../gallery/$name1");

								$name=explode('.',$name1);
								$ext=pathinfo($name1,PATHINFO_EXTENSION);
								$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
								$mul_img2[]=$image_name;

								if(move_uploaded_file($tmp_name1, "../gallery/$image_name")){
									$image_uploaded=true;
								}else{
									$image_uploaded=false;
								} 

								// $img_name1=$_FILES['file1']['name'];

								// $imgagestr = implode(",", $img_name1);

							}

					}
					 $imgagestr = implode(', ', $mul_img2);
					$sql4="insert into student_notifications(category,student_id,class_id,section_id,selected_no,heading,message,msg_type,photos,loginuser,notice_datetime,date,session)values('$category','$studid','$classid','$section','$mobile','$heading','$message4','1','$imgagestr','$username',now(),now(),'".$_SESSION['session']."')";
					$q1=mysqli_query($con,$sql4);
				}
				// -----------------send push notification for each parent----------------------	
					
				
					if(!empty($token_id)){
						$msg_type='push_gallery';
						send_push_notification($msg_type, $token_id);
				
					}
		 
				// -----------------send push notification for each parent----------------------
		} //while
		if($q1){
			$Responce['status']="success";
		   $Responce['message']="Gallery Images uploaded";
		}else{
			$Responce['status']="error";
		   $Responce['message']="Somethings Went Wrong, Please try again";

		}
	}else{

      	$Responce['status']="error";
		   $Responce['message']="Students not found";
   }
		
	   echo json_encode($Responce);
				 die;

}

// =====================================================================================
if($_POST['category']=='5'){

	   $text_template=$_POST['text_template'];
	   $stuid=$_POST['to_student_id'];
	   $textsms5=$_POST['textsms5'];
	   $stu_count=count($_POST['to_student_id']);

		// if(!($Wcount>=$stu_count) || !($Tcount>=$stu_count)){
		if(!($Tcount>=$stu_count)){  //only text sms validation
			$Responce['status']="error";
		   // $Responce['message']="You have Insufficient SMS Limit<br>Whatsapp sms: ".$Wcount." <br> Text sms: ".$Tcount." ";
		   $Responce['message']="You have Insufficient SMS Limit<br> Text sms: ".$Tcount." ";
		   echo json_encode($Responce); die;
		// }elseif($Wstatus=='0' || $Tstatus=='0' ){
		}elseif($Tstatus=='0' ){
		   $Responce['status']="error";
		   $Responce['message']="Please turn on your SMS service";

		   echo json_encode($Responce);die;
	   }

	   // if(empty($textsms5)){
	   // 	$Responce['status']="empty";
		//    $Responce['message']="Please Enter Message";
		//    echo json_encode($Responce); die;
	   // }

			function str_replace_first($search, $replace, $subject)
			{
			    $search = '/'.preg_quote($search, '/').'/';
			    return preg_replace($search, $replace, $subject, 1);
			}
	
			$tsql="SELECT * FROM `textsms_templates` where `status`='1' and `id`='$text_template' ";
			mysqli_set_charset( $con, 'utf8');
			$tquery=mysqli_query($con,$tsql);
			if(mysqli_num_rows($tquery) > 0){
				$row=mysqli_fetch_assoc($tquery);

				$template=$row['description'];
	            $count= substr_count($template, "{#var#}", 0); 

	            for($j=0;$j<$count;$j++){

	              $template5= str_replace_first("{#var#}",$textsms5[$j] , $template);
	              $template=$template5;
	            }  
	            
	          
	           $compose=$template;
				}

			$totalcount = count($stuid);

			if($totalcount>0){

				$action = "Important Information Sent."; 

				// $messagetype = "important_information";
				$messagetype =get_textsms_byid($text_template)['msg_type'];

			}

			

		foreach($stuid as $k){


			
			$csql5 ="select `student_id`,`token_id`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.student_id='$k' and  s.stu_status='0'   && sr.session='".$_SESSION['session']."'";
			$que1=mysqli_query($con,$csql5);


			$r1 = mysqli_fetch_array($que1);

			$classid=$r1['class_id'];

			$section=$r1['section_id'];

			$mobile=$r1['parent_no'];
			$token_id=$r1['token_id'];

			$msgtype=$r1['msg_type_id'];
		   $encod=urlencode($compose);
			

			if($check=='on'){

				if($msgtype==1){
				// echo	$sql=;
				//  $que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)values('$category','$k','$classid','$section','$mobile','$compose','1','$username',now(),now(),'".$_SESSION['session']."')");

				//Send message via whatsapp
				sendwhatsappMessage($mobile, $encod, $messagetype);


				}
				// if($msgtype==2){

					 $que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)values('$category','$k','$classid','$section','$mobile','$compose','2','$username',now(),now(),'".$_SESSION['session']."')");

				
				sendtextMessage($mobile,$compose,$messagetype);  //use $compose due error on hindi sms     


				// }


				 $log_bulk_sms=mysqli_query($con," INSERT INTO `log_bulk_sms`(`loginuser`, `section`, `create_date`,`session` ) VALUES ('".$_SESSION['user_roles']."','Student Communication','".date('Y-m-d H:i:s')."','".$_SESSION['session']."') ");

			    

				//Send text message
			}else{

				if($msgtype==1){

					$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)

					values('$category','$k','$classid','$section','$mobile','$compose','1','$username',now(),now(),'".$_SESSION['session']."')");

					sendwhatsappMessage($mobile, $encod, $messagetype);
				}



			}
			// -----------------send push notification for each parent----------------------	
				
			if(!empty($token_id)){
				$msg_type='push_important_info';
				send_push_notification($msg_type, $token_id);
			}
		   // -----------------send push notification for each parent----------------------

		}//for each
		if($que2){
			$Responce['status']="success";
		   $Responce['message']="SMS send Successfuly";
		}else{
			$Responce['status']="error";
		   $Responce['message']="Somethings Went Wrong";

		}
   echo json_encode($Responce); die;


}
if($_POST['category']=='6'){

 $classid=$_POST['classid5'];
 $section=$_POST['section5'];
 if($section=='All'){
 	$section_sql='';
 	$section=$classid;
 }else{
 	$section_sql=" and sr.section_id='$section' ";
 }
 $heading6=!empty($_POST['heading6']) ? $_POST['heading6'] : '' ;
 $compose=$_POST['heading1'];
 $heading1=mysqli_real_escape_string($con,$_POST['heading1']);



 	$csql6 ="select `student_id`,`token_id`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.stu_status='0'  and sr.class_id='$classid'   $section_sql && sr.session='".$_SESSION['session']."'";
			$quen=mysqli_query($con,$csql6);

				$row = mysqli_num_rows($quen);

		if($row){
				// if(!($Wcount>=$row)){
				// 	$Responce['status']="error";
				//    $Responce['message']="You have Insufficient  SMS Limit<br>Whatsapp sms: ".$Wcount." ";

				//    echo json_encode($Responce);die;
	         // }	

 

					$cl = mysqli_query($con,"select * from class where class_id='$classid'");

					$rcl = mysqli_fetch_array($cl);

					$clname = $rcl['class_name'];

					$se = mysqli_query($con,"select * from section where class_id='$classid'");

					$rse = mysqli_fetch_array($se);

					$sename = $rse['section_name'];

					$action = "Study Material Sent to Class ".$clname." Section ".$sename."."; 

					$messagetype = "study_material";
					//save image-----------------------------------------------------
					foreach ($_FILES["file2"]["error"] as $key => $error){
						if ($error == UPLOAD_ERR_OK){
							$tmp_name2 = $_FILES["file2"]["tmp_name"][$key];
	
							$name2 = $_FILES["file2"]["name"][$key];
								  $name=explode('.',$name2);
									$ext=pathinfo($name2,PATHINFO_EXTENSION);
									$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
									$mul_img2[]=$image_name;
	
									if(move_uploaded_file($tmp_name2, "../gallery/$image_name")){
										$image_uploaded=true;
									}else{
										$image_uploaded=false;
									} 
						}
						
					}
					$imgagestr2 = implode(', ', $mul_img2);
	    if($image_uploaded){	
			while($resz1=mysqli_fetch_array($quen)){	
				$mul_img2=array();


				$msgtype=$resz1['msg_type_id'];

				$studid=$resz1['student_id'];

				$classid=$resz1['class_id'];

				$section=$resz1['section_id'];

				$mobile=$resz1['parent_no'];
				$token_id=$resz1['token_id'];

				$name2 = $_FILES["file2"]["name"];

				$img_name2 = $_FILES['file2']['name'];

				$imgstr2 = implode(",", $img_name2);
						

				if($imgstr2!=""){
					
					$sql6="insert into student_notifications(category,student_id,class_id,section_id,selected_no,heading,message,msg_type,photos,loginuser,notice_datetime,date,session)values('$category','$studid','$classid','$section','$heading6','$mobile','$heading1','1','$imgagestr2','$username',now(),now(),'".$_SESSION['session']."')";
					$q1=mysqli_query($con,$sql6);

					if($msgtype=='1'){
						$encod=urlencode($compose);
						$pathh=dirname($baseurl);
						$pathimage=$pathh.'/gallery/'.$imgagestr2;
						sendwhatsappMessage($mobile, $encod, $messagetype, $pathimage);
					}
					// -----------------send push notification for each parent----------------------	
					
					if(!empty($token_id)){
											
						$msg_type='push_study_material';
						send_push_notification($msg_type, $token_id);
				
					}
				// -----------------send push notification for each parent----------------------
				

				}
			}//while		

			if($q1){
				$Responce['status']="success";
			    $Responce['message']="Study Materials Uploaded";
			}else{
				$Responce['status']="error";
			    $Responce['message']="Somethings Went Wrong Please try again";

			}
		}else{
			$Responce['status']="error";
		    $Responce['message']="Problem on Image uploading , please try again";
		}	


	}else{

		$Responce['status']="error";
		$Responce['message']="Student not found";
	}
   echo json_encode($Responce); die;

}
}
// -----------------------------------------------send_staff_notification-------------------------------------------

if(isset($_POST['send_staff_notification'])){
// echo "<pre>";
// print_r($_POST);
// echo "<pre>";

$Wcount=get_whatsapp_sms_count()['count_sms'];
$Wstatus=get_whatsapp_sms_setting()['status'];

  $category=$_POST['category'];
  $dept=$_POST['dept'];
  $composetext1=$_POST['composetext1'];
  $charcount=$_POST['charcount'];
  $staffcount=trim($_POST['staffcount']);
  $check=$_POST['check'];

$x=1;

$email=$_SESSION['user_logged_in'];

$username=$_SESSION['user_roles'];
if($staffcount<=0){
   $Responce['status']="error";
   $Responce['message']="No any staff in this Department ";
   echo json_encode($Responce); die;

}elseif(!($Wcount>=$staffcount) ){
	$Responce['status']="error";
   $Responce['message']="You have Insufficient SMS Limit<br>Whatsapp sms: ".$Wcount." ";
   echo json_encode($Responce); die;
}elseif($Wstatus=='0' ){
   $Responce['status']="error";
   $Responce['message']="Please turn on your Whatsapp SMS service";

   echo json_encode($Responce);die;
}else{


   if($category=='1'){

		$compose = $composetext1;

		$messagetype = "staff_notification";


	$que=mysqli_query($con,"select * from assign_department where dept_id='$dept'");

		if($check=='on'){
			while($resz=mysqli_fetch_array($que)){		

				$stid=$resz['staff_id'];

				

				$q1 = mysqli_query($con,"select * from staff where st_id='$stid'");

				$r1 = mysqli_fetch_array($q1);
				// echo "<pre>";
				// print_r($r1);

				$msgtype=$r1['msg_type_id'];

				 $mobile=$r1['mobno'];

				

				

					if($msgtype==1){
						$ssql="insert into staff_notifications(category,dept_id,staff_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session) values('$category','$dept','$stid','$mobile','$compose','1','$username',now(),now(),'".$_SESSION['session']."')";
						$q2=$con->query($ssql);

						//Send message via whatsapp

						$encod=urlencode($compose);

						 $msg = $encod;
					
						sendwhatsappMessage($mobile, $msg, $messagetype);
					}

					

			}//while
			      if($q2){
						 $Responce['status']="success";
		              $Responce['message']="SMS send Successfuly";
					}else{
						$Responce['status']="error";
		              $Responce['message']="Error on SMS sending";
					}

		}else{
			   $Responce['status']="error";
		      $Responce['message']="Plese check SMS box, SMS not sent.";
		}
	}else{
		$Responce['status']="error";
      $Responce['message']="Something went wrong";
	}


}
echo json_encode($Responce);

}


// ------------------------------------------Custom Communication--------------------------------------------------

if(isset($_POST['create_group'])){
// echo "<pre>";
// print_r($_POST);
$group=mysqli_real_escape_string($con,$_POST['group']);
		$sql=mysqli_query($con,"select * from custome_group where group_name='$group'");

		$row=mysqli_num_rows($sql);

		if($row){
		  $Responce['status']="error";
        $Responce['message']="This Group Is Already Exists";
		}else{
			$query="insert into custome_group (group_name,create_date,modify_date) values('$group',now(),now())";	

			if(mysqli_query($con,$query)){
				$Responce['status']="success";
            $Responce['message']="Group Created Successfully";
			}else{
					$Responce['status']="error";
               $Responce['message']="Something went wrong plesae try again";
			}
		}
echo json_encode($Responce);
}

if(isset($_POST['update_group'])){
// echo "<pre>";
// print_r($_POST);
$id=mysqli_real_escape_string($con,$_POST['id']);
$ngroup=mysqli_real_escape_string($con,$_POST['ngroup']);
$flag=false;
if(!empty($id)){
	$flag=true;
}else{
	$Responce['status']="error";
   $Responce['message']="Something went wrong ,Id not found";
}
	if($flag){
		$sql=mysqli_query($con,"select * from custome_group where group_name='$ngroup' and group_id!='$id' ");

		$row=mysqli_num_rows($sql);

		if($row){
			$Responce['status']="error";
        $Responce['message']="This Group Is Already Exists ";

		}else{

			$query=mysqli_query($con,"update custome_group set group_name='$ngroup',modify_date=now() where group_id='$id'");	
         if($query){
				$Responce['status']="success";
            $Responce['message']="Group updated Successfully";
			}else{
					$Responce['status']="error";
               $Responce['message']="Something went wrong plesae try again";
			}
		}
	}
echo json_encode($Responce);
}

if(isset($_POST['assign_students_group'])){
// echo "<pre>";
// print_r($_POST);
$group=mysqli_real_escape_string($con,$_POST['group']);
$classid=mysqli_real_escape_string($con,$_POST['classid']);
$section=mysqli_real_escape_string($con,$_POST['section']);
// $from=$_POST['from'];
$stuid=$_POST['to'];

	foreach($stuid as $k){

		// $que1=mysqli_query($con,"select * from students where student_id='$k'");
		$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.student_id='$k' and  s.stu_status='0'   && sr.session='".$_SESSION['session']."'";
		$que1=mysqli_query($con,$asql);

		$r1 = mysqli_fetch_array($que1);

		$regno=$r1['register_no'];

		$stuname=$r1['student_name'];

		$classid = $r1['class_id'];

		$section = $r1['section_id'];

		$que2=$con->query("insert into assign_custome_group(group_id,student_id,register_no,class_id,section_id,date,modify_date,session)values('$group','$k','$regno','$classid','$section',now(),now(),'".$_SESSION['session']."')");
		// if(mysqli_error($con)){
		// 	echo ("Error description :" .mysqli_error($con));
		// }
	}
		if($que2){
				$Responce['status']="success";
            $Responce['message']="Assign students group Successfully";
			}else{
					$Responce['status']="error";
               $Responce['message']="Something went wrong plesae try again";
		}
echo json_encode($Responce);		
}	


if(isset($_POST['send_custome_notification'])){
// echo "<pre>";
// print_r($_POST);

// die;
$category=mysqli_real_escape_string($con,$_POST['category']);
$group=mysqli_real_escape_string($con,$_POST['group']);
$composetext1=mysqli_real_escape_string($con,$_POST['composetext1']);
$composetext2=mysqli_real_escape_string($con,$_POST['composetext2']);
$charcount=mysqli_real_escape_string($con,$_POST['charcount']);
$stucount=mysqli_real_escape_string($con,$_POST['stucount']);
$check=mysqli_real_escape_string($con,$_POST['check']);

$Wcount=get_whatsapp_sms_count()['count_sms'];
$Wstatus=get_whatsapp_sms_setting()['status'];
$x=1;
$email=$_SESSION['user_logged_in'];
$username=$_SESSION['user_roles'];
$flag=false;
	if($category==1){
		$compose = $composetext1;
		$messagetype = "custome_announcement";
	}
	elseif($category==3){
		$compose = $composetext2;
		$messagetype = "custome_message";
	}
	if($check=='on'){
		$flag=true;
	}else{
		$Responce['status']="error";
		$Responce['message']="Please tik on send SMS";
		echo json_encode($Responce); die;
	}

	if(($category=="1" || $category=="3") && $flag==true){

		$que=mysqli_query($con,"select * from assign_custome_group where group_id='$group'");
		$total_stu=mysqli_num_rows($que);

		if($total_stu<=0){
		   $Responce['status']="error";
		   $Responce['message']="No any students in this group";
		   echo json_encode($Responce); die;

		}elseif(!($Wcount>=$total_stu) ){
			$Responce['status']="error";
		   $Responce['message']="You have Insufficient SMS Limit<br>Whatsapp sms: ".$Wcount." ";
		   echo json_encode($Responce); die;
		}elseif($Wstatus=='0' ){
		   $Responce['status']="error";
		   $Responce['message']="Please turn on your Whatsapp SMS service";

		   echo json_encode($Responce);die;
		}else{

			while($resz=mysqli_fetch_array($que)){	

				$studid=$resz['student_id'];

				$classid=$resz['class_id'];

				$sectionid=$resz['section_id'];

				// $q1 = mysqli_query($con,"select * from students where student_id='$studid'  && session='".$_SESSION['session']."' ");
				$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`student_contact`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.student_id='$studid' and  s.stu_status='0'   && sr.session='".$_SESSION['session']."'";
		      $q1=mysqli_query($con,$asql);

				$r1 = mysqli_fetch_array($q1);

				$msgtype=$r1['msg_type_id'];

				$mobile=$r1['parent_no'];
				$student_contact=$r1['student_contact'];
				

				if($check=='on'){

					if($msgtype==1){

						$q1=$con->query("insert into student_notifications(category,group_id,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)	values('$category','$group','$studid','$classid','$sectionid','$mobile','$compose','1','$username',now(),now(),'".$_SESSION['session']."')");
						// if(mysqli_error($con)){
						// 	echo ("Error description :" .mysqli_error($con));
						// }
						$encod=urlencode($compose);
						sendwhatsappMessage($student_contact, $encod, $messagetype);

						$x+=1;
					}

				}
				
			}//while	
			if($x > 0){
				$Responce['status']="success";
            $Responce['message']="SMS sent Successfuly";

			}else{
				$Responce['status']="error";
            $Responce['message']="No any student at Mobile app ";
			}
				
       

		}	
   }
echo json_encode($Responce);
		

	// echo "<script>window.location='dashboard.php?option=send_custome_notification'</script>";

}





// ?>
