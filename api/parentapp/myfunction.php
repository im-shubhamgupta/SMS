<?php
include('../dbcontroller.php'); 
error_reporting(1);
extract($_REQUEST);	

/*function chkMobile($mobile)
{
	global $con;

	$que=mysqli_query($con,"select * from students where parent_no='$mobile'");	
	if(mysqli_num_rows($que)>0)
	{
	//generate OTP
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];
	
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
	
	
	//for otp
	
	$rand=rand(4321,1234);
	$otp=md5($rand);
	$otp1=substr($otp,0,4);
	//Send sms to sender and reciever
	    $senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => "Dear User ".$rand.",%0a is Your Otp To Verify Mobile Number ",
			'to' => array($mobile)
		);
		//Prepare you post parameters
		$postData = array(
			'sender' => $senderId,
			'campaign' => $campaign,
			'route' => $route,
			'sms' => array($sms)
		);
		$postDataJson = json_encode($postData);

		$url="$apiurl";

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
			CURLOPT_URL => "$url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $postDataJson,
			CURLOPT_HTTPHEADER => array(
		    "authkey:"."$apikey",
		    "content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		
		
		    //Send sms to sender and reciever
	       if(mysqli_query($con,"insert into otp values('','$mobile','$rand','')"))
	       {
	            //return 2;
	            
	            $temp = array();
		        $temp['otp'] = $rand; 
	            echo json_encode($temp);
	       }
		   else
		   {
			   return 3;
		   }
	
	//SEND ON $mobile		
	}
	else
	{
	echo "This users mobile number doesnt exists";
	}
}
*/
function get_session_byid($sesid){
	global $con;
	$Squery=mysqli_query($con,"select * from session where id='$sesid' ");
	
	if(mysqli_num_rows($Squery)>0)
	{
		$res = mysqli_fetch_assoc($Squery);
		$session = $res['year'];
		return $session;
	}else{
		return "";
	}

}

function verify($mobile,$password,$firebaseid,$session)
{
	global $con;
	$query_otp=mysqli_query($con,"select * from students where parent_no='$mobile' && password='$password' && msg_type_id='1' && session='$session' ");
	
	if(mysqli_num_rows($query_otp)>0)
	{
		
		$que = mysqli_query($con,"select * from students where parent_no='$mobile' and session='$session'");
		while($res = mysqli_fetch_array($que))
		{
			$stuid = $res['student_id'];
			
			mysqli_query($con,"update students set firebase_reg_id='$firebaseid' where student_id='$stuid' and session='$session' ");
				
		
		@$temp = array();
	    $temp['register_no'] = $res['register_no']; 
		$temp['student_name'] = $res['student_name']; 
		$temp['father_name'] = $res['father_name'];
		$temp['student_contact'] = $res['student_contact'];
		$temp['class_id'] = $res['class_id'];
		$temp['section_id'] = $res['section_id'];
		$temp['academic_year'] = $res['academic_year'];
		$temp['stu_image'] = $res['stu_image'];
		$temp['stu_status'] = $res['stu_status'];
		$temp['stu_id'] = $res['student_id'];
		
		return $temp;
		}
	}
	else
	{
		return "";
	}
}


function installedapp($mobile,$session)
{
	global $con;
	
	$qu = mysqli_query($con,"select * from installed_app where parent_no='$mobile' ");
	$row = mysqli_num_rows($qu);
	if(!$row){
		// $sql="select `student_id`,register_no,student_name,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  `parent_no`='$mobile'  ";// && sr.session='$session' 
	   $sql="select `student_id`, register_no, student_name  from students  where  `parent_no`='$mobile'  ";
	   $que1 = mysqli_query($con,$sql);
		while($res1 = mysqli_fetch_array($que1))
		{
			$stuid = trim($res1['student_id']);
			$regno = trim($res1['register_no']);
			$stuname = $res1['student_name'];
			$query = mysqli_query($con,"insert into installed_app(student_id,register_no,student_name,parent_no,date,session) 
			values('$stuid','$regno','$stuname','$mobile',now(),'$session')");
		}
		$temp['status'] = "inserted";
		return $temp;
	}
	else
	{
		return "";
	}
}


function profile($stu_id,$session)
{
	global $con;
	// $qprofile=mysqli_query($con,"select * from students where student_id='$stu_id' && session='$session' ");
	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,admission_date,sr.roll_no,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$stu_id' && s.stu_status='0' && sr.session='$session' ";
	$qprofile = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($qprofile)>0)
	{
		$res = mysqli_fetch_assoc($qprofile);
		$clsid = $res['class_id'];
		$qcls = mysqli_query($con,"select * from class where class_id='$clsid'");
		$res1 = mysqli_fetch_assoc($qcls);
		
		$secid = $res['section_id'];
		$qsec = mysqli_query($con,"select * from section where section_id='$secid'");
		$res2 = mysqli_fetch_assoc($qsec);
		
		@$temp = array();
	    $temp['register_no'] = $res['register_no']; 
		$temp['student_name'] = $res['student_name']; 
		$temp['father_name'] = $res['father_name'];
		$temp['student_contact'] = $res['student_contact'];
		$temp['class_name'] = $res1['class_name'];
		$temp['section_name'] = $res2['section_name'];
		$temp['academic_year'] = getSessionByid($res['session'])['year'];
		// $temp['stu_image'] = ($res['stu_image']) ? $res['stu_image'] : 'NA' ;
		$temp['stu_image'] = Call_Baseurl().'/'.getStudent_byStudent_id($res['student_id'])['stu_image_path'];
		$temp['stu_id'] = $res['student_id'];
		$temp['admission_date'] = date('d-m-Y', strtotime($res['admission_date']));
		$temp['roll_no'] = ($res['roll_no']) ? $res['roll_no'] : '0';
		// echo json_encode($temp);
		return $temp;
	}
	else
	{
		return "";
	}
}


function fees($student_id,$session)
{
	global $con;
	$data = array();
	$arr=array();
	$grand_total=array();
	$total_paid=array();
	$GrandTotalbyMonth=array();
	$ress=array();
	$nmonth='';
	
	$sql="select `student_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$student_id'  && s.stu_status='0' && sr.session='$session' ";
	
	$query_fee = mysqli_query($con,$sql);
	
	$row = mysqli_num_rows($query_fee);
	if($row)
	{
		$res = mysqli_fetch_assoc($query_fee);
		$stuid = $res['student_id'];
		
		$qt1 = mysqli_query($con,"select * from student_route where student_id='$stuid' and session='$session'");	//
		$rt1 = mysqli_fetch_assoc($qt1);
		
		$transid = $rt1['trans_id'];
		$transprice = $rt1['price'];
		
		$qt2 = mysqli_query($con,"select * from transports where trans_id='$transid'");
		$rt2 = mysqli_fetch_assoc($qt2);
		
		// $routename = $rt2['route_name'];
		
		$sqf="select * from student_wise_fees where student_id='$stuid' and session='$session'";
		
		$qt3 = mysqli_query($con,$sqf);
		$rt3 = mysqli_fetch_assoc($qt3);
		
		$feehead = $rt3['fee_header_id'];
		$headarr = explode(',',$feehead);
		$feeamt = $rt3['fee_amount'];
		$amtarr = explode(',',$feeamt);
	    $sumFeecount=1;
		$TotalMonthlyFeeSum=array();
		$qt4 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and session='$session' order by student_due_fee_id desc ");
		//
		$No_of_Fee_paid= $qt4->num_rows;
	
		
		while($rt4 = mysqli_fetch_assoc($qt4)){
			
			$PaidFeeId = $rt4['fee_header_id'];
			$PaidFeeIdArray = explode(',',$PaidFeeId);  //fee header id 
			$RecievedAmount = $rt4['received_amount'];
			$RecievedAmountArray = explode(',',$RecievedAmount); //fee header receive amount
			$monthly_fee_due = $rt4['monthly_fee_due'];
			$Yearly_due = $rt4['yealy_due'];
			
			$Total_Monthly_due= $monthly_fee_due+$Yearly_due ;
			$Total_due[]=$Total_Monthly_due;
			$Total_Monthly_Paid=array_sum($RecievedAmountArray);
			
			$TransportAmount = $rt4['transport_amount'];
			
			$PreFeePaid = $rt4['previous_amount'];
            $LateFee = $rt4['latefee'];	
			if(empty($LateFee)){
				$LateFee='0.00';
			}
			
			$month_name = get_array_monthname($rt4['month']);
			$temp=array();
			$arr=array();
		    
			$feeheadcount = sizeof($headarr);
			$tbal = 0;
			$dueamount = 0;
			$totalfees = 0;
			$totalpaid = 0;
			$totaldue = 0;
			$paidfeeamount = 0;
			$rece = array();
			$Limit =$No_of_Fee_paid-$sumFeecount;
			$AllRecievedAmount=array();
			
			$recQuery = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and session='$session' order by student_due_fee_id desc  LIMIT $sumFeecount,$Limit");
		    while($recQueryRow = mysqli_fetch_assoc($recQuery)){
				$AllRecievedAmount[] = $recQueryRow['received_amount'];
				
			}
			
			
			$NO_Of_Times_Fee_Paid= count($AllRecievedAmount);
			
			$AllRecievedAmountArray=array();
			foreach($AllRecievedAmount as $paidFee){
				
				$AllRecievedAmountArray[] = explode(',',$paidFee);
			}
			
			
			$result = array();

           
        foreach($AllRecievedAmountArray[0] as $k => $v)
           $result[$k] = array_sum(array_column($AllRecievedAmountArray, $k));
			
				
		
			for($i=0;$i<$feeheadcount;$i++)
			{
			
				$feeid = $headarr[$i];  //header
				$feeamount = $amtarr[$i];  //header amount 
				$GrandTotalbyMonth[]=$feeamount;
				$PaidFeeId = $PaidFeeIdArray[$i];		
				$RecievedAmount = $RecievedAmountArray[$i];
				
				
				
				 
				if(!empty($feeid)){		
				
					$sql="select * from fee_header where fee_header_id='$feeid'";	
					$q2 = mysqli_query($con,$sql);
					$r2 = mysqli_fetch_array($q2);
					if($sumFeecount==1){
					
					if($r2['type']=='1'){//monthly				
					  $TotalMonthlyFeeSum[]=$feeamount*$No_of_Fee_paid;
					 
					}else{
						
						$TotalMonthlyFeeSum[]=$feeamount;
					}
					
					$Grand_Total= array_sum($TotalMonthlyFeeSum);
					}
					
					
				
				
					if($r2['type']=='0'){ //yearly
				        $YearlyRecievedAmount = $result[$i];
						 if($YearlyRecievedAmount>0){
					           $RemainingYearlyFee=$feeamount-$YearlyRecievedAmount;
							   if($RemainingYearlyFee==0){
								  $RemainingYearlyFee='0.00'; 
							   }
							 }else{
								
								$RemainingYearlyFee=$feeamount; 
							 }
						 
						 }						
					
					
					
					
					$fname = $r2['fee_header_name'];	
					
					if(empty($feeamount)){
					    
					 $feeamount='0.00';   
					}
					if(empty($RecievedAmount)){
					    
					 $RecievedAmount='0.00';   
					}
					if($nmonth==$month_name){
						$month_name='';
					}	
					$nmonth=$month_name;

					$temp=array();
					
					if(!empty($month_name)){
						$monn = $month_name;	
						}
					
					
						$temp['Fee_Header'] = $fname;
						
							if($r2['type']=='1'){  //monthly
								$temp['Fee'] = $feeamount;
							}elseif($r2['type']=='0'){
								$temp['Fee'] = $RemainingYearlyFee;
								
							}
						  
						   $temp['PaidFee'] = $RecievedAmount;
						


						//$grand_total[]=intval($TotalMonthlyFeeSum);    
						$total_paid[]=intval($RecievedAmount);


						$arr['month_name']=$monn;       //only month name
						$arr['data'][]=$temp;


							
						
			    }
			    
			}//for loop
			
			// $takeamount=$rece;//for calculation it's array

             
             if($LateFee!='0.00'){
				$temp2['Fee_Header'] = 'Latefee'; 
			    $temp2['Fee'] = $LateFee; 
				$GrandTotalbyMonth[]=$LateFee;
				$Total_Monthly_Paid=$Total_Monthly_Paid+$LateFee;
				$arr['data'][]=$temp2; 
			 }
			 if($PreFeePaid!='0.00'){
				$temp2['Fee_Header'] = 'PreviousFee';
			    $temp2['Fee'] = $PreFeePaid;
			   $GrandTotalbyMonth[]=$PreFeePaid; 
				$arr['data'][]=$temp2;  
			 }
			 
             // $temp['PreviousFee'] = $PreFeePaid;
		     // $temp['Latefee'] = $LateFee;
			
			
			$arr['monthly_total_paid']=$Total_Monthly_Paid;
			$arr['monthly_total_due']=$Total_Monthly_due;

			array_push($data,$arr);
			
		    $sumFeecount++;	
			
		}//while	
		
		
		$Grand_Total= array_sum($TotalMonthlyFeeSum);
		$Grand_Total=$Grand_Total+$LateFee+$PreFeePaid;
		$Pa_total=array_sum($total_paid);
		$Pa_total=$Pa_total+$LateFee+$PreFeePaid;
		$Due_Amount= $Grand_Total-$Pa_total;
		$response["status"] = 1;
		$response["message"] = "Success";
		$response["grand_total"] =$Grand_Total;
		$response["total_paid"] = $Pa_total;
		
		$response["total_due"] = $Due_Amount;
		$response["result"] = $data;
		
		return json_encode($response);
	}
	else
	{
		$response["status"] = 0;
		$response["message"] = "Register No. not Exists.";
		$response["grand_total"] ='0';
		$response["total_paid"] = '0';
		$response["total_due"] = '0';
		$response["result"] = array();
		
		return json_encode($response);
	}
}


function announcement($stuid,$session,$current_page,$per_page)
{
	global $con;
	$data = array();
	$total_records=0;
   $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	
    $sql="select * from student_notifications where category='1' && student_id='$stuid' && session='$session' order by notice_datetime desc";

	$query_ann1 = mysqli_query($con,$sql);
	$total_records=mysqli_num_rows($query_ann1);
	$sql.= " Limit $c_page, $per_page ";

	$query_ann = mysqli_query($con,$sql);
	$total_page=mysqli_num_rows($query_ann);
	if($total_page>0)
	{
		
		while($res = mysqli_fetch_assoc($query_ann))
		{
			@$temp = array();
			$temp['st_notification_id'] = $res['st_notification_id'];
			$temp['heading'] = !empty($res['heading']) ? $res['heading'] : '' ;
			$temp['message'] = $res['message'];
			$temp['date'] = date('d-m-Y (h:i A)', strtotime($res['date']));
			$temp['status'] = $res['status'];
			array_push($data, $temp);
		}
		 	$response["status"] = 1;
			$response["message"] = "Success"; 
            
			$response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=$data;
			return json_encode($response);
	}
	else
	{
		$response["status"] = 0;
			$response["message"] = "No Announcement"; 
            $response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=[];
			return json_encode($response);
	}

}


function announcementcount($stuid,$session)
{
	global $con;
	
	$data = array();
	
	$query_ann1 = mysqli_query($con,"select * from student_notifications where category='1' && student_id='$stuid' and session='$session' GROUP BY `message` order by date desc");
		
	if(mysqli_num_rows($query_ann1))
	{	
		$unread = 0;
		$read = 0;
		while($res = mysqli_fetch_assoc($query_ann1))
		{
			
			$sta = $res['status'];
			if($sta == 0)
			{
				$unread = $unread + 1;
			}
			else
			{
				$read = $read + 1;
			}
	
		}
		
		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		// echo json_encode($data);
		return $data;
	}
	else
	{
		return "";
	}
}


function homework($subject,$stuid,$session,$classid,$sectionid,$current_page,$per_page)
{
	global $con;
	$total_records=0;
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	

	$sub_sql=($subject) ? " && subject='$subject' "  : '';
	$sql="select * from student_notifications where  1 && student_id='$stuid' $sub_sql  && class_id='$classid' && section_id='$sectionid'  && category='2' and session='$session' order by notice_datetime desc";
	$query_home1 = mysqli_query($con,$sql);
	$total_records=mysqli_num_rows($query_home1);
	$sql.= " Limit $c_page, $per_page ";
	$query_home = mysqli_query($con,$sql);
	$total_page=mysqli_num_rows($query_home);
	if($total_page>0)	
	{
			$data = array();
			
			while($res = mysqli_fetch_assoc($query_home))
			{
			@$temp = array();
			$temp['st_notification_id'] = $res['st_notification_id'];
			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			$temp['message'] = $res['message'];
			// $temp['attachment'] = comma_separated_to_array($res['attachment']) ?? "NA"; 
			
			//send multiple path with array
			if(!empty($res['attachment'])){
				$attachs=explode(',',$res['attachment']);

				foreach($attachs as $att){
					$tes=array();
					$filetype=pathinfo($att, PATHINFO_EXTENSION );
					$tes['filetype']=($filetype=='pdf') ? 'pdf' : 'image' ;

					$tes['att_path']=Call_Baseurl().'/images/assignment/'.trim($att); 
					$temp['attachment'][]=$tes;
				}
			}else{
				$temp['attachment']=array();
			}



			// if(!empty($res['attachment'])){
			// 	$filetype=pathinfo( $res['attachment'], PATHINFO_EXTENSION );

			// 	if($filetype=='pdf'){
			// 		$temp['attachment']['type']='pdf';
			// 	}else{
			// 		$temp['attachment']['type']='image';
			// 	}
			// }else{
			// 	$temp['attachment']['type']='';
			// }
			// if(!empty($res['attachment'])){
			// 	$temp['attachment']['file'] = comma_separated_to_array_path(Call_Baseurl().'/images/assignment/',$res['attachment']) ?? "NA"; 
			// }else{
			// 	$temp['attachment']['file'] =array();
			// }
					
			
			$temp['date'] = date('d-m-Y (h:i A)', strtotime($res['date']));
			$temp['subject_name'] = get_subject_byid($res['subject'])['subject_name']?? "All Subject";
			$temp['status'] = $res['status'];
			array_push($data, $temp);
			}
			$response["status"] = 1;
			$response["message"] = "Success";
            
			$response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=$data;
			return json_encode($response);
	}
	else
	{
		$response["status"] = 0;
			$response["message"] = "No Homework";
            
			$response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=[];
			return json_encode($response);
	}

}


function homeworkcount($stuid,$session)
{
	global $con;
	
	$data = array();
	
	$query_ann1 = mysqli_query($con,"select * from student_notifications where category='2' && student_id='$stuid' and session='$session' order by date desc");
		
	if(mysqli_num_rows($query_ann1))
	{	
		$unread = 0;
		$read = 0;
		while($res = mysqli_fetch_assoc($query_ann1))
		{
			
			$sta = $res['status'];
			if($sta == 0)
			{
				$unread = $unread + 1;
			}
			else
			{
				$read = $read + 1;
			}
	
		}
		
		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		return $data;
	}
	else
	{
		return "";
	}
}


function message($stuid,$session,$current_page,$per_page)
{
	global $con;
	$data = array();
	$total_records=0;
	//$current_page=!empty($current_page) ? $current_page : '0';
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	

	$sql="select `st_notification_id`,`heading`,`message`,`date`,`notice_datetime`,`status` from student_notifications where student_id='$stuid' && session='$session' && category='3' order by notice_datetime desc";
	$query_msg1 = mysqli_query($con,$sql);	
	$total_records=mysqli_num_rows($query_msg1);
    $sql.= " Limit $c_page, $per_page ";	
    // echo $sql;
	$query_msg = mysqli_query($con,$sql);	
	
	$total_page=mysqli_num_rows($query_msg);
	if($total_page>0)
	{	
		while($res = mysqli_fetch_assoc($query_msg))
		{
		@$temp = array();
		$temp['st_notification_id'] = $res['st_notification_id'];
		$temp['heading'] = ($res['heading']) ? $res['heading'] : '';
		$temp['message'] = $res['message'];
		$temp['date'] = date('d-m-Y (h:i A)', strtotime($res['notice_datetime']));
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		// return $data;
		    $response["status"] = 1;
			$response["message"] = "Success"; 
			$response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=$data;
			return json_encode($response);
	
	}
	else
	{
		    $response["status"] = 0;
			$response["message"] = "No Message"; 
		    $response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=[];
			return json_encode($response);
	}
}


function messagestatusupdate($id,$session)
{
	global $con;
	
	$data = array();
	 $sql="update student_notifications set status='1' where st_notification_id='$id' ";
	$query_msg=mysqli_query($con,$sql);
			
	if($query_msg)
	{	
		return "Updated Successfully.";
	}
	else
	{
		return "";
	}
}


function messagecount($stuid,$session)
{
	global $con;
	
	$data = array();  
	
	$query_msg = mysqli_query($con,"select `message`,`date`,`status` from student_notifications where student_id='$stuid' && session='$session' && category='3' order by date desc");
		
	if(mysqli_num_rows($query_msg))
	{	
		$unread = 0;
		$read = 0;
		while($res = mysqli_fetch_assoc($query_msg))
		{
			
			$sta = $res['status'];
			if($sta == 0)
			{
				$unread = $unread + 1;
			}
			else
			{
				$read = $read + 1;
			}
		}
		
		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		return $data;
	}
	else
	{
		return "";
	}
}


function gallery($stuid,$session,$current_page,$per_page)
{
	global $con;	
	$total_records=0;
	//$current_page=!empty($current_page) ? $current_page : '0';
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	

	$sql.="SELECT * from student_notifications where  student_id='$stuid' && category='4' && session='$session' order by notice_datetime desc";	
	$query_gal1 = mysqli_query($con,$sql);
	$total_records=mysqli_num_rows($query_gal1);
	$sql.= " Limit $c_page, $per_page ";	

	$query_gal = mysqli_query($con,$sql);
	
	$total_page=mysqli_num_rows($query_gal);
	if($total_page>0){
		$data = array();
		while($res = mysqli_fetch_assoc($query_gal)){
		
		@$temp = array();
		$temp['st_notification_id'] = $res['st_notification_id'];
		$temp['heading'] = ($res['heading']) ? $res['heading'] : '' ;
		$temp['message'] = $res['message'];
		// $temp['photos'] = $res['photos'];
		$temp['photos'] = comma_separated_to_array_path(Call_Baseurl().'/'.'gallery/',$res['photos'], $separator = ',');

		$temp['date'] = date('d-m-Y (h:i A)', strtotime($res['date']));
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		$response["status"] = 1;
		$response["message"] = "Success"; 
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['result']=$data;
		return json_encode($response);
		
	}
	else
	{
		$response["status"] = 0;
		$response["message"] = "No Pictures"; 
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['result']=[];
		return json_encode($response);
		
	}
}


function gallerycount($stuid,$session)
{
	global $con;
	
	$data = array();
	
	$query_gal = mysqli_query($con,"select * from student_notifications where student_id='$stuid' && category='4' and session='$session' order by date desc");
		
	if(mysqli_num_rows($query_gal))
	{	
		$unread = 0;
		$read = 0;
		while($res = mysqli_fetch_assoc($query_gal))
		{
			$sta = $res['status'];
			if($sta == 0)
			{
				$unread = $unread + 1;
			}
			else
			{
				$read = $read + 1;
			}
		}
		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		
		return $data;
	}
	else
	{
		return "";
	}
}


function allcount($stuid,$session)
{
	global $con;
	
	$data = array();
	// $q1 = mysqli_query($con,"select * from students where `student_id`='$stuid' and `session`='$session' ");
	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.stu_status='0' && sr.session='$session' ";
	$q1 = mysqli_query($con,$sql);
	$row1 = mysqli_num_rows($q1);
	if($row1)
	{
			
		$qannounce = mysqli_query($con,"select * from student_notifications where category='1' && student_id='$stuid' GROUP BY `message` order by date desc");
			$unread = 0;
			$read = 0;
		if(mysqli_num_rows($qannounce))
		{	
			while($res1 = mysqli_fetch_assoc($qannounce))
			{	
				$sta = $res1['status'];
				if($sta == 0)
				{
					$unread = $unread + 1;
				}
				else
				{
					$read = $read + 1;
				}
		
			}
		}	
			$temp['head name'] = "Announcement";
			$temp['unread'] = $unread;
			$temp['read'] = $read;
			array_push($data, $temp);
			
		$qhomework = mysqli_query($con,"select * from student_notifications where category='2' && student_id='$stuid' GROUP BY `message` order by date desc");
			$unread = 0;
			$read = 0;
		if(mysqli_num_rows($qhomework))
		{	
			while($res1 = mysqli_fetch_assoc($qhomework))
			{	
				$sta = $res1['status'];
				if($sta == 0)
				{
					$unread = $unread + 1;
				}
				else
				{
					$read = $read + 1;
				}
		
			}
		}	
			$temp['head name'] = "Homework";
			$temp['unread'] = $unread;
			$temp['read'] = $read;
			array_push($data, $temp);	
			
		
		$qmessage = mysqli_query($con,"select * from student_notifications where category='3' && student_id='$stuid' GROUP BY `message` order by date desc");
			$unread = 0;
			$read = 0;
		if(mysqli_num_rows($qmessage))
		{	
			while($res1 = mysqli_fetch_assoc($qmessage))
			{	
				$sta = $res1['status'];
				if($sta == 0)
				{
					$unread = $unread + 1;
				}
				else
				{
					$read = $read + 1;
				}
		
			}
		}	
			$temp['head name'] = "Message";
			$temp['unread'] = $unread;
			$temp['read'] = $read;
			array_push($data, $temp);	
			
		
		$qgallery = mysqli_query($con,"select * from student_notifications where category='4' && student_id='$stuid' GROUP BY `message` order by date desc");
			$unread = 0;
			$read = 0;
		if(mysqli_num_rows($qgallery))
		{	
			while($res1 = mysqli_fetch_assoc($qgallery))
			{	
				$sta = $res1['status'];
				if($sta == 0)
				{
					$unread = $unread + 1;
				}
				else
				{
					$read = $read + 1;
				}
		
			}
		}	
			$temp['head name'] = "Gallery";
			$temp['unread'] = $unread;
			$temp['read'] = $read;
			array_push($data, $temp);	
			
		
		$qimpinfo = mysqli_query($con,"select * from student_notifications where category='5' && student_id='$stuid' GROUP BY `message` order by date desc");
			$unread = 0;
			$read = 0;
		if(mysqli_num_rows($qimpinfo))
		{	
			while($res1 = mysqli_fetch_assoc($qimpinfo))
			{	
				$sta = $res1['status'];
				if($sta == 0)
				{
					$unread = $unread + 1;
				}
				else
				{
					$read = $read + 1;
				}
		
			}
		}	
			$temp['head name'] = "Important Info";
			$temp['unread'] = $unread;
			$temp['read'] = $read;
			array_push($data, $temp);	
			
			return $data;			
	}		
	else
	{
		return "";
	}
}


function subject($classid)
{
	global $con;		
	$query_sub = mysqli_query($con,"SELECT * from subject where class_id='$classid'");
	
	if(mysqli_num_rows($query_sub))
	{
		$data = array();
		$temp['subject_id'] = 0;
		$temp['subject_name'] = "All Subject";
		array_push($data, $temp);

		while($res = mysqli_fetch_assoc($query_sub))
		{
			@$temp = array();
			$temp['subject_id'] = $res['subject_id'];
			$temp['subject_name'] = $res['subject_name'];
			array_push($data, $temp);
		}
		return $data;
	}
	else
	{
		return "";
	}
}


function userdetail($mobile,$session)
{
	global $con;		
	// $query_uesr = mysqli_query($con,"SELECT * from `students` where `parent_no`='$mobile' and `session`='$session' ");
	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,`admission_date`,sr.roll_no,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  `parent_no`='$mobile'  && s.stu_status='0' && sr.session='$session' ";
	$query_uesr = mysqli_query($con,$sql);
	
	if(mysqli_num_rows($query_uesr))
	{
		$data = array();
		while($res = mysqli_fetch_assoc($query_uesr))
		{
			$clsid = $res['class_id'];
			$qcls = mysqli_query($con,"select * from class where class_id='$clsid'");
			$res1 = mysqli_fetch_assoc($qcls);
			
			$secid = $res['section_id'];
			$qsec = mysqli_query($con,"select * from section where section_id='$secid'");
			$res2 = mysqli_fetch_assoc($qsec);
			
			@$temp = array();
			$temp['register_no'] = $res['register_no']; 
			$temp['student_name'] = $res['student_name']; 
			$temp['father_name'] = $res['father_name'];
			$temp['student_contact'] = $res['student_contact'];
			$temp['class_id'] = $res1['class_id'];
			$temp['class_name'] = $res1['class_name'];
			$temp['section_id'] = $res2['section_id'];
			$temp['section_name'] = $res2['section_name'];
			// $temp['academic_year'] = $res['academic_year'];
			$temp['academic_year'] = getSessionByid($res['session'])['year'];
			// $temp['stu_image'] =($res['stu_image']) ? $res['stu_image'] : "NA" ;
			// if(!empty($res['stu_image'])){
			// 	$temp['stu_image'] ='images/student/'.str_replace('/','-',$res['register_no']).'/'.$res['stu_image'] ;
			// }else{
			// 	$temp['stu_image'] ="NA";
			// }
			$temp['stu_image'] =Call_Baseurl().'/'.getStudent_byStudent_id($res['student_id'])['stu_image_path'];
			$temp['stu_id'] = $res['student_id'];
			$temp['admission_date'] = date('d-m-Y', strtotime($res['admission_date']));
			$temp['roll_no'] = ($res['roll_no']) ? $res['roll_no'] : '0';
			array_push($data, $temp);
		}
		// echo json_encode($data);
		return $data;
	}
	else
	{
		// return "Invalid Mobile";
		return "";
	}
}


function stuyearlyattendance($stuid,$years,$session)
{
	global $con;
	
	$data = array();
	$detail = array();
	$yr = "01-april-".intval($years);

    // $yy=intval($years);
	// $time="$yy-04-01";
	
		$monthlypercent=0;
		$totalpresentyearly = 0;
		$totalabsentyearly = 0;
		$totalleaveyearly = 0;
		$totalpercentageyearly = 0;
		$totalattendanceyearly = 0;


		for ($i = 0; $i <= 11; $i++) 
		{
		// echo "time".$time = strtotime(sprintf('+%d months', $i), $start);
		
		// $label = date('F Y', $time);
		// $month = date('m', $time);
		// $year = date('Y', $time);
		$time=date('d-m-Y',strtotime("+$i months",strtotime($yr)));	
		$label = date('F Y',strtotime($time));
		$month = date('m',strtotime($time));
		$year = date('Y',strtotime($time));

	    $sql="select * from student_daily_attendance where student_id='$stuid' && month(date)='$month' && year(date)='$year' && session='$session'";
	    $qatt = mysqli_query($con,$sql);	
		
	    $totalrow = mysqli_num_rows($qatt);
	

		 
			$present=0;
			$absent=0;
			$leave=0;
			
			while($res = mysqli_fetch_array($qatt))
			{
			 $attendance = $res['type_of_attend'];
				if($attendance==1)
				{
					$present = $present+1;
				}
				else if($attendance==2)
				{
					$absent = $absent+1;
				}
				else if($attendance==3)
				{
					$leave = $leave+1;
				}
			
			} //while loop close
			$totalmonthlypresent = $present+$leave;
			// $totalmonthlyabsent = $leave;
			$totalmonthlyabsent = $absent;

			if(!empty($totalrow)){
				$monthlypercent = round($totalmonthlypresent/$totalrow*100,2)." %";
			}else{
				$monthlypercent='0';
			}
			
			$totalpresentyearly = $totalpresentyearly+$present;
			$totalabsentyearly = $totalabsentyearly+$absent;
			$totalleaveyearly = $totalleaveyearly+$leave;				
			$totalattendanceyearly = $totalattendanceyearly+$totalrow;	
			if(!empty($totalattendanceyearly)){			
			    $totalpercentageyearly = round(($totalpresentyearly+$totalleaveyearly)/$totalattendanceyearly*100,2)."%";
			}else{
				$totalpercentageyearly="0";
			}				
			
			@$temp = array();	
			// if($totalrow > 0){	
				$temp['monthname'] = $label; 	
				$temp['totalmonthlypresent'] = $totalmonthlypresent;
				$temp['totalmonthlyabsent'] = $totalmonthlyabsent; 	
				$temp['totalattendance'] = $totalrow; 	
				$temp['totalmonthlypercentage'] = $monthlypercent; 	
				array_push($data, $temp);
			// }		
		}//for loop

		if($qatt)
		{
			@$temp = array(); //
			
				$temp['totalpresentyearly'] = $totalpresentyearly; 
				$temp['totalabsentyearly'] = $totalabsentyearly; 
				$temp['totalleaveyearly'] = $totalleaveyearly; 
				$temp['totalattendanceyearly'] = $totalattendanceyearly; 
				$temp['totalpercentageyearly'] = $totalpercentageyearly; 
				
				$detail=$temp;
			
			// echo json_encode($data);
			// print_r($temp);
			return array($data,$detail);
		}else{
			return "";
		}
  
			
}


function stumonthlyattdetail($student_id,$month,$session)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");
	$data = array();

	$year=date('Y');
	$month=$month;

      
    $month_id= ltrim($month,'0'); 
  
  
	   $MonthQury=  $con->query("SELECT month_name from months where month_id='$month_id'");
	   if($MonthQury->num_rows>0){
	      $MonthRow= $MonthQury->fetch_assoc(); 
	      $month_name= $MonthRow['month_name'];
	       
	   }else{
	      $month_name=''; 
	       
	   }
	 $attsql="select * from student_daily_attendance where student_id='$student_id' && month(date)='$month' && year(date)='$year' and session='$session' ";
	$qatt = mysqli_query($con,$attsql);	
		
		$totalrow = mysqli_num_rows($qatt);
		$present=0;
		$absent=0;
		$leave=0;
		$monthlypercent=0;
		$presentday='';
		$absentday='';
		$leaveday='';
		while($res = mysqli_fetch_array($qatt))
		{
			$attendance = $res['type_of_attend'];
			$attdate = $res['date'];
			if($attendance==1)
			{
				$present = $present+1;
				$presentday.= date('d',strtotime($attdate)).',';
			}
			else if($attendance==2)
			{
				$absent = $absent+1;
				$absentday.= date('d',strtotime($attdate)).',';
			}
			else if($attendance==3)
			{
				$leave = $leave+1;
				$leaveday.= date('d',strtotime($attdate)).',';
			}
		
		}
		$totalpresent = $present;
		$totalabsent = $absent;
		$totalleave = $leave;
		$att_per= round($totalpresent/$totalrow*100,2);
		$percent =($att_per>0)? $att_per." %" : '0 %' ;
		
		
	if($qatt)
	{
		// . ' Days '
		@$temp = array();		
		// $temp['presentdays'] = $presentday; 	
		// $temp['absentdays'] = $absentday; 	
		// $temp['leavedays'] = $leaveday; 	
		$temp['monthname'] = $month_name; 	
		$temp['totalpresent'] = $totalpresent; 	
		$temp['totalabsent'] = $totalabsent; 	
		$temp['totalleave'] = $totalleave; 	
		$temp['totalattendance'] = $totalrow; 	
		$temp['totalmonthlypercentage'] = $percent; 	
		array_push($data, $temp);
	
		return $data;
	}
	else
	{
		return "";
	}
			
}


function studymaterial($student_id,$session,$current_page,$per_page)
{
	global $con;
	$total_records=0;
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	
	// $q1 = mysqli_query($con,"select * from students where student_id='$student_id' and session='$session' ");
	$sql="select `student_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$student_id' && sr.session='$session' ";
	$q1 = mysqli_query($con,$sql);
	$r1 = mysqli_fetch_array($q1);
	$classid = $r1['class_id'];
	$sectionid = $r1['section_id'];
	$studentid = $r1['student_id'];
	
	$sql1="SELECT * from student_notifications where class_id='$classid' && section_id='$sectionid' && student_id='$student_id' && session='$session' && category='6' order by notice_datetime desc";
	$query_stu_mat1 = mysqli_query($con,$sql1);
	$total_records=mysqli_num_rows($query_stu_mat1);

    $sql1.= " Limit $c_page, $per_page ";	
    $query_stu_mat = mysqli_query($con,$sql1);
	$total_page=mysqli_num_rows($query_stu_mat);

	if($total_page>0){
		$data = array();
		while($res = mysqli_fetch_assoc($query_stu_mat))
		{
		
		@$temp = array();
		$temp['heading'] = ($res['heading']) ? $res['heading'] : '' ;
		$temp['message'] = $res['message'];
		// $temp['photos'] = ($res['photos']) ? $res['photos'] : "NA" ;
		if(!empty($res['photos'])){
			// $temp['stu_image'] = Call_Baseurl().'/'.getStudent_byStudent_id($res['photos'])['stu_image_path'];
			$temp['stu_image'] =  comma_separated_to_array_path(Call_Baseurl().'/gallery/',$res['photos']) ?? ''; 
		}else{
			$temp['stu_image'] =array();
		}
		$temp['date'] = $res['date'];
		array_push($data, $temp);
		}
		$response["status"] = 1;
			$response["message"] = "Success"; 
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['result']=$data;
		return json_encode($response);
	
	}
	else
	{
		$response["status"] = 0;
			$response["message"] = "No Message"; 
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['result']=[];
		return json_encode($response);
	
	}
}


function importantinfo($stuid,$session,$current_page,$per_page)
{
	global $con;
	$total_records=0;
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	
    $sql="SELECT * from student_notifications where student_id='$stuid' && session='$session' && category='5' order by notice_datetime desc";

	$query_stu_mat1 = mysqli_query($con,$sql);
	$total_records=mysqli_num_rows($query_stu_mat1);

	$sql.= " Limit $c_page, $per_page ";	
	// echo $sql;
	$query_stu_mat = mysqli_query($con,$sql);
	
	$total_page=mysqli_num_rows($query_stu_mat);
	if($total_page>0)
	{
		$data = array();
		while($res = mysqli_fetch_assoc($query_stu_mat))
		{
		@$temp = array();
		$temp['st_notification_id'] = $res['st_notification_id'];
		$temp['message'] = $res['message'];
		$temp['date'] =  date('d-m-Y (h:i A)', strtotime($res['date']));
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		$response["status"] = 1;
		$response["message"] = "Success"; 
		
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['result']=$data;
		return json_encode($response);
	}
	else
	{
		$response["status"] = 0;
		$response["message"] = "No Important Information";
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['result']=[];
		return json_encode($response);
	}
}


function importantinfocount($stuid,$session)
{
	global $con;
	
	$data = array();
	
	$query_imp = mysqli_query($con,"select * from student_notifications where category='5' && student_id='$stuid' and session='$session'  order by date desc");
		
	if(mysqli_num_rows($query_imp))
	{	
		$unread = 0;
		$read = 0;
		while($res = mysqli_fetch_assoc($query_imp))
		{
			
			$sta = $res['status'];
			if($sta == 0)
			{
				$unread = $unread + 1;
			}
			else
			{
				$read = $read + 1;
			}
		}
		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		return $data;
	}
	else
	{
		return "";
	}
}


function exam($stuid,$session,$current_page,$per_page)
{
	global $con;	
	$data=array();	
	//$current_page=!empty($current_page) ? $current_page : '0';
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	

	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && s.stu_status='0' && sr.session='$session' ";
	$query_uesr = mysqli_query($con,$sql);
	if(mysqli_num_rows($query_uesr))
	{
			$data = array();
			$res = mysqli_fetch_assoc($query_uesr);
			$clsid = $res['class_id'];
			$secid = $res['section_id'];
		
		$sql="select * from test where class_id='$clsid' && section_id='$secid' && session='$session' order by test_date desc";	
		$q1 = mysqli_query($con,$sql);
		$total_records=mysqli_num_rows($q1);

		$sql.= " Limit $c_page, $per_page ";	
		// echo $sql;
		$q2 = mysqli_query($con,$sql);
		$total_page=mysqli_num_rows($q2);
		if($total_page)
		{
			while($r2 = mysqli_fetch_array($q2))
			{	
				$subjectid = $r2['subject_id'];
				$s1 = mysqli_query($con,"select * from subject where subject_id='$subjectid'");
				$sr1 = mysqli_fetch_array($s1);
				$subjectname = $sr1['subject_name'];
			
			@$temp = array();
			$temp['test_date'] = date('d-m-Y', strtotime($r2['test_date'])); 
			// $temp['starttime'] = $r2['starttime']; 
			// $temp['endtime'] = $r2['endtime'];
			$temp['starttime'] = date("h:i a",strtotime($r2['starttime'])); 
			$temp['endtime'] =  date("h:i a",strtotime($r2['endtime']));
			$temp['subjectname'] = $subjectname;
			$temp['room_no'] = $r2['room_no'];
			$temp['test_name'] = $r2['test_name'];
			
			array_push($data, $temp);
			}
			
			$response["status"] = 1;
			$response["message"] = "Success";
			$response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=$data;
			return json_encode($response);
		}
		else
		{
			$response["status"] = 0;
			$response["message"] = "No Exam Scheduled";
			$response['current_page']=$current_page;
			$response['per_page']=$per_page;
			$response['total_page']=ceil($total_records/$per_page);
			$response['total_records']=$total_records;
			$response['result']=array();
			return json_encode($response);
		}
	}else{
		$response["status"] = 0;
		$response["message"] = "No Exam Scheduled check given data";
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=0;
		$response['result']=array();
		return json_encode($response);
	}
}


function subjectyearlyattendance($regno,$years)
{
	global $con;
	
	$data = array();
	$yr = "april".$years;
	$start = strtotime($yr);
	for ($i = 0; $i <= 11; $i++){

		$time = strtotime(sprintf('+%d months', $i), $start);
		$label = date('F Y', $time);
		$month = date('m', $time);
		$year = date('Y', $time);
		
		$q1 = mysqli_query($con,"select * from students where register_no='$regno'");
		$r1 = mysqli_fetch_array($q1);
		$clsid = $r1['class_id'];
		$secid = $r1['section_id'];
		
		$q2 = mysqli_query($con,"select * from assign_subject where class_id='$clsid' && section_id='$secid'");
		$subname ='';
		while($r2 = mysqli_fetch_array($q2))
		{
			$subid = $r2['subject_id'];
			$q3 = mysqli_query($con,"select * from subject where subject_id='$subid'");
			$r3 = mysqli_fetch_array($q3);
			$subname.= $r3['subject_name'].',';
		
			$qatt = mysqli_query($con,"select * from subjectwise_attendance where register_no='$regno' && subject_id='$subid' && month(date)='$month' && year(date)='$year'");	
			
			$row=mysqli_num_rows($qatt);
			
		}
		
		@$temp = array();		
		$temp['monthname'] = ($label) ? ($label) : "N/A"; 
		$temp['subjectname'] = ($subname) ? ($subname) : "NA"; 
		$temp['count'] = ($row) ? ($row) : "NA" ;
		array_push($data, $temp);	
	}
	
	if($q2){

	// echo json_encode($data);
		return $data;
	}
	else
	{
		return "";
	}
			
}


function reportcard($stuid,$session,$test_name)
{
	global $con;		
	$data = array();
	$query_mark = mysqli_query($con,"select * from marks where student_id='$stuid'  and session='$session' and test_name='$test_name' ");
	
	// $q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='$session' ");
	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$stuid' && sr.session='$session' ";
	$q1 = mysqli_query($con,$sql);
	$r1 = mysqli_fetch_array($q1);
	$clsid = $r1['class_id'];
	$secid = $r1['section_id'];
	
			
		$totalmarksobtained = 0;
		$totalmarks = 0;
		while($res = mysqli_fetch_assoc($query_mark))
		{		
			$testname = $res['test_name'];
			$subid = $res['subject_id'];
			$q2 = mysqli_query($con,"select * from subject where subject_id='$subid'");
			$r2 = mysqli_fetch_array($q2);
			$subname = $r2['subject_name'];
			
			 $sqql="select * from test where test_name='$testname' && class_id='$clsid' && 
			section_id='$secid' && subject_id='$subid'  and session='$session'";
			$q3 = mysqli_query($con,$sqql);
			$r3 = mysqli_fetch_array($q3);
			$passingmarks = $r3['min_marks'];	
			
			$marks = $res['marks'];
			$totalmarksobtained = $totalmarksobtained + $marks;
			if($marks >= $passingmarks)
			{
				$rest = "Pass"; 
			}
			else
			{
				$rest = "Fail";
			}
			
			$maxmarks = $res['max_mark'];
			$marksobtained = $marks."/".$maxmarks;
			$totalmarks = $totalmarks + $maxmarks;
			$percentage = round($totalmarksobtained/$totalmarks*100,2);
			
			$q4 = mysqli_query($con,"select * from grade where condition1 <='$percentage' && condition2 >='$percentage'");
			$r4 = mysqli_fetch_array($q4);
			$grade = $r4['grade_name'];
			
		@$temp = array();
		
		if(empty($passingmarks)){
		    
		   $passingmarks=''; 
		}
		if(empty($marksobtained)){
		    
		   $marksobtained=''; 
		}
		if(empty($subname)){
		    
		   $subname=''; 
		}
		
		$temp['testname'] = $testname;
		$temp['date'] = $res['date'];
		$temp['subject'] = $subname;
		$temp['passingmarks'] = $passingmarks;
		$temp['marksobtained'] = $marksobtained;
		$temp['Result'] = $rest;
		array_push($data, $temp);
		}
	
	if($query_mark)
	{
		// echo json_encode($data);
		return $data;
	}
	else
	{
		return "";
	}
}


function reportcardsummary($stuid,$session)
{
	global $con;		
	
	
	
		$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$stuid' && sr.session='$session' ";
		$q1 = mysqli_query($con,$sql);
		$r1 = mysqli_fetch_array($q1);
		$clsid = $r1['class_id'];
		$secid = $r1['section_id'];
	
		$data = array();
		
		$TestnameSql="select * from marks where student_id='$stuid' and session='$session' group by test_name ";
		$query_testname = mysqli_query($con,$TestnameSql);
		if(mysqli_num_rows($query_testname)>0){
			while($row = mysqli_fetch_assoc($query_testname)){	  //for multiple testname make while loop
				
				$totalmarksobtained = 0;
				$totalmarks = 0;
			   $MarkSql="select * from marks where student_id='$stuid' and session='$session' and class_id='$clsid' and section_id='$secid'  and test_name='".$row['test_name']."'  ";
				$query_mark = mysqli_query($con,$MarkSql);
			
				while($res = mysqli_fetch_assoc($query_mark))
				{		
					
					$testname = $res['test_name'];
					$subid = $res['subject_id'];
					// $q2 = mysqli_query($con,"select * from subject where subject_id='$subid'");
					// $r2 = mysqli_fetch_array($q2);
					// $subname = $r2['subject_name'];
					
					// $q3 = mysqli_query($con,"select * from test where test_name='$testname' && class_id='$clsid' && 
					// section_id='$secid' && subject_id='$subid' and session='$session' ");
					// $r3 = mysqli_fetch_array($q3);
					// $passingmarks = $r3['min_marks'];	
					
					$marks = $res['marks'];
					$totalmarksobtained = $totalmarksobtained + $marks;
					
					
					$maxmarks = $res['max_mark'];
					$marksobtained = $marks."/".$maxmarks;
					$totalmarks = $totalmarks + $maxmarks;
					$percentage = round($totalmarksobtained/$totalmarks*100,2);

				}	
					@$temp = array();
					$temp['testname'] = $testname;
								
					$gsql="select * from grade where condition1 <='$percentage' && condition2 >='$percentage'";
					$q4 = mysqli_query($con,$gsql);
					if(mysqli_num_rows($q4)>0){
					$r4 = mysqli_fetch_assoc($q4);
					$grade=$r4['grade_name'];
					}else{
						$grade='';
					}
			
					$temp['Grandtotal'] = $totalmarksobtained."/".$totalmarks;
					$temp['Percentage'] = $percentage."%";
					$temp['Grade'] = $grade;
				// }	
					array_push($data, $temp);

	        }
		}		
	if($query_mark)
	{
		
		return $data;
	}
	else
	{
		return [];
	}
}

function eventcalendar($fromdate,$todate,$studentid,$session,$current_page,$per_page){
	date_default_timezone_set("Asia/Kolkata");
	global $con;
	$data = array();
	//$current_page=!empty($current_page) ? $current_page : '0';
     $per_page='15';
    if(!empty($current_page)){ //pagination
    	$c_page=$per_page*($current_page-1);  
    }else{
    	$c_page=0;
    }	
    //set default one month
    $fromdate=!empty($fromdate) ? $fromdate : date('Y-m-d', strtotime('-1 month'));
    $todate=!empty($todate) ? $todate : date('Y-m-d');

	$nfromdate = date("Y-m-d", strtotime($fromdate));
    $ntotdate = date("Y-m-d", strtotime($todate));

    $sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$studentid' && sr.session='$session' ";
    $Student_Query= $con->query($sql);
	  if($Student_Query->num_rows>0){
	      
	      $StudentRow=$Student_Query->fetch_assoc();
	      $classid= $StudentRow['class_id'];
	      $sectionid= $StudentRow['section_id'];
	        
	  }  
     $Esql="select * from events where ((class_id IN (0,'$classid') AND 
	section_id IN (0,'$sectionid'))||(class_id ='All' AND 
	section_id='All')) AND from_date>='$nfromdate' AND to_date<='$ntotdate' AND event_for='1' and session='$session' ";   

	$q11=mysqli_query($con,$Esql);
	$total_records = mysqli_num_rows($q11);

	$Esql.= " Limit $c_page, $per_page ";	
	$q1=mysqli_query($con,$Esql);
	// echo $Esql;
	$total_page = mysqli_num_rows($q1);
	if($total_page>0)
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$efor = $r1['event_for'];
			$qevent=mysqli_query($con,"select * from event_type where event_id='$efor'");
			$revent=mysqli_fetch_array($qevent);
			$eventfor=$revent['event_name'];

			$fdate = $r1['from_date'];
			$frmdate = date("d-m-Y", strtotime($fdate));
			$tdate = $r1['to_date'];
			$tdate = date("d-m-Y", strtotime($tdate));
			
			@$temp = array();
			$temp['Event_Name'] = $r1['event_heading'];
			$temp['Event_For'] = $eventfor;
			$temp['Event_Description'] = $r1['description'];
			$temp['From_Date'] = $frmdate;
			$temp['To_Date'] = $tdate;
			array_push($data, $temp);
		}
		 $response["status"] = 1;
		$response["message"] = "Success"; 
		
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		// $response['fromdate']=$fromdate;
		// $response['todate']=$todate;
		$response['result']=$data;
		return json_encode($response);
	}
	else
	{
		$response["status"] = 0;
		$response["message"] = "No Events"; 
		$response['current_page']=$current_page;
		$response['per_page']=$per_page;
		$response['total_page']=ceil($total_records/$per_page);
		$response['total_records']=$total_records;
		$response['fromdate']='';
		$response['todate']='';
		$response['result']=[];
		return json_encode($response);
	}
	
}


function leavetype()
{
	global $con;
	$data = array();
	$qlv = mysqli_query($con,"SELECT * from leave_type");
	
	if(mysqli_num_rows($qlv))
	{
		$data = array();
		while($res = mysqli_fetch_assoc($qlv))
		{
		@$temp = array();
		$temp['leave_id'] = $res['leave_id'];
		$temp['leave_name'] = $res['leave_name'];
		array_push($data, $temp);
		}
		
		return $data;
	}
	else
	{
		return "";
	}
}


function leaverequest($dateofsubmission,$studentid,$fromdate,$todate,$leavetypeid,$noofdays,$reason,$note,$session)
{
	global $con;
	$data = array();
	date_default_timezone_set("Asia/Kolkata");
	
	$submitdate = $dateofsubmission;
	$nsubmitdate = date("Y-m-d", strtotime($submitdate));
	$fdate = $fromdate;
	$nfdate = date("Y-m-d", strtotime($fdate));
	$tdate = $todate;
	$ntdate = date("Y-m-d", strtotime($tdate));

	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$studentid'  && s.stu_status='0'  && sr.session='$session' ";
	
     $Student_Query= $con->query($sql);

	  if($Student_Query->num_rows>0){
	      
	      $StudentRow=$Student_Query->fetch_assoc();
	      $class_id= $StudentRow['class_id'];
	      $section_id= $StudentRow['section_id'];
	      
	  }
	 $chksql="select * from student_leave where student_id='$studentid' && 
	class_id='$class_id' && section_id='$section_id' && from_date='$nfdate' && to_date='$ntdate' and session='$session' ";  
	$q1 = mysqli_query($con,$chksql);
	
	$row = mysqli_num_rows($q1);
	if(!$row)
	{
		$sql="insert into student_leave (student_id,class_id,section_id,
		submission_date,from_date,to_date,leave_id,total_days,reason,note,status,create_date,modify_date,session) 
		values ('$studentid','$class_id','$section_id','$nsubmitdate','$nfdate','$ntdate',
		'$leavetypeid','$noofdays','$reason','$note','0',now(),now(),'$session')";
		$q2 = mysqli_query($con,$sql);
		
		if($q2){
		    return "Inserted";
	    }else{
	    	return "Error";
	    }
	}	
	else
	{
		return "Already";
	}
	
}


function requesttype()
{
	global $con;
	$data = array();
	$query_sub = mysqli_query($con,"SELECT * from request_type");
	
	if(mysqli_num_rows($query_sub))
	{
		$data = array();
		while($res = mysqli_fetch_assoc($query_sub))
		{
		@$temp = array();
		$temp['request_id'] = $res['request_id'];
		$temp['request_name'] = $res['request_name'];
		array_push($data, $temp);
		}
		
		return $data;
	}
	else
	{
		return "";
	}
}


function feedback($studentid,$requestid,$raisedfor,$title,$description,$session)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");
	$submitdate = date("Y-m-d") ;
	$nsubmitdate = date("Y-m-d", strtotime($submitdate));
	$fsql=$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$studentid'  && sr.session='$session' ";
	
     $Student_Query= $con->query($fsql);

	  if($Student_Query->num_rows>0){
	      
	      $StudentRow=$Student_Query->fetch_assoc();
	      $class_id= $StudentRow['class_id'];
	      $section_id= $StudentRow['section_id'];
	      
	  }
	   
	   
	$sql="insert into feedback (class_id,section_id,submission_date,student_id,request_id,raised_for,title,description,status,session,create_date,modify_date) 
	values('$class_id','$section_id','$nsubmitdate','$studentid','$requestid','$raisedfor','$title','$description',0,'$session',now(),now())";
	$que = mysqli_query($con,$sql);
	
	if($que)
	{
		return "Inserted";
	}
	else
	{
		return "";
	}
	
}


function timetable($classid,$sectionid,$session)
{
	global $con;
	$data = array();
	
	$q1 = mysqli_query($con,"select * from time_table where class_id='$classid' && section_id='$sectionid'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		$q2 = mysqli_query($con,"select * from days where day_id !=7");
		while($r2 = mysqli_fetch_array($q2))
		{
			$dayid = $r2['day_id'];
			$dayname = $r2['day_name'];
			
			@$temp = array();
			$temp['dayname']= $dayname;
						
			$q3 = mysqli_query($con,"select * from time_table where class_id='$classid' && 
			section_id='$sectionid' && day='$dayid'");
			while($r3 = mysqli_fetch_array($q3))
			{
			
			$period = $r3['period'];
			$sttime = $r3['start_period'];
			$nsttime = date("h:i a",strtotime($sttime));
			
			$endtime = $r3['end_period'];
			$nendtime = date("h:i a",strtotime($endtime));
			
			$subid = $r3['subject_id'];
			if($subid == "Lunch")
			{
				$subname = "Lunch";
			}
			else if($subid == "Break")
			{
				$subname = "Break";
			}
			else
			{			
			$q4 = mysqli_query($con,"select * from subject where subject_id='$subid'");
			$r4 = mysqli_fetch_array($q4);
			$subname = $r4['subject_name'];
			}
			
			$staffid = $r3['staff_id'];
			if($staffid == "Lunch")
			{
				$stname = "Lunch";
			}
			else if($staffid == "Break")
			{
				$stname = "Break";
			}
			else
			{
			$q5 = mysqli_query($con,"select * from staff where st_id='$staffid' "); //and session='$session' 
			$r5 = mysqli_fetch_array($q5);
			$stname = $r5['staff_name'];
			}
			
			$temp['period']= "Period ".$period;
			$temp['time']= $nsttime." - ".$nendtime;
			$temp['subjectname']= $subname;
			$temp['staffname']= ($stname) ? $stname : 'NA' ;
			array_push($data, $temp);
			}
					
		}
			return $data;
	}
	else
	{
		return "";
	}
}


function voicemessage($stuid)
{
	global $con;
	
	$data = array();
		
	$query_vo = mysqli_query($con,"select * from voice_message where msgfor='student' && stu_staff_id='$stuid' order by date desc");	
	
	if(mysqli_num_rows($query_vo))
	{	
		while($res = mysqli_fetch_assoc($query_vo))
		{
			
			$chgdt = date("d-m-Y",strtotime($res['date']));
			$user = $res['loginuser'];
			if($user=="users")
			{
				$loginuser = "admin";
			}
			else if($user=="staff")
			{
				$loginuser = "teacher";
			}
			
		@$temp = array();
		$temp['voice_msg_id'] = $res['voice_msg_id'];
		$temp['messagename'] = $res['message_name'];
		$temp['message'] = $res['message'];
		$temp['date'] = $chgdt;
		$temp['loginuser'] = $loginuser;
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		
		return $data;
	}
	else
	{
		return "";
	}
}


function voicestatusupdate($id)
{
	global $con;
	
	$data = array();
	
	$query_vo = mysqli_query($con,"update voice_message set status='1' where voice_msg_id='$id'");
			
	if($query_vo)
	{	
		return "Updated Successfully.";
	}
	else
	{
		return "";
	}
}


function voicemessagecount($stuid)
{
	global $con;
	
	$data = array();
	
	$query_vo = mysqli_query($con,"select * from voice_message where msgfor='student' && stu_staff_id='$stuid' order by date desc");
		
	if(mysqli_num_rows($query_vo))
	{	
		$unread = 0;
		$read = 0;
		while($res = mysqli_fetch_assoc($query_vo))
		{
			
			$sta = $res['status'];
			if($sta == 0)
			{
				$unread = $unread + 1;
			}
			else
			{
				$read = $read + 1;
			}
	
		}
		
		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		return $data;
		
	}
	else
	{
		return "";
	}
}


function changepassword($mobile,$currentpassword,$newpassword,$session)
{
	global $con;
	// $que = mysqli_query($con,"select * from students where parent_no='$mobile' && password='$currentpassword' && session='$session' ");
	$sql="select `student_id`,register_no,student_name,stu_image,father_name,student_contact,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id,sr.session  from students as s join student_records as sr ON s.student_id=sr.stu_id  where  `parent_no`='$mobile'  && s.stu_status='0'  && password='$currentpassword' && sr.session='$session' ";
	$que = mysqli_query($con,$sql);
	$row = mysqli_num_rows($que);		
	if($row)
	{	
		while($res = mysqli_fetch_array($que))
		{
			$id = $res['student_id'];
			$que1 = mysqli_query($con,"update students set password='$newpassword' where student_id='$id' ");
		}
		// $temp['Response'] = "Updated";
		// echo json_encode($temp);
		return "Updated";
	}
	else
	{
		// $temp['Response'] = "Invalid Details";
		return "";
	}
}

function student_year($stuid,$sessionid){
    $data=array();
	global $con;
	$last_years=getSessionByid($sessionid)['year'];
	$last_year_arr=explode('-',$last_years);
	$last_year=$last_year_arr[0];
	$sql="select `student_id`,`create_date` from students where student_id='$stuid' ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
	    $first_year=date('Y', strtotime($resc['create_date']));
	   
	    $diff_year=$last_year-$first_year;
	    if($diff_year>0){
	    	for($i=0; $i<=$diff_year;$i++ ){
	    		$temp=array();
	    		$temp['year']=$first_year+$i;
	    		array_push($data, $temp);	
	    	}
	    }else{
	    	$temp['year']=$first_year;
	    	array_push($data, $temp);	
	    }
	    return $data;
	}else{
		return '';
	}
}
function student_month($stuid,$sessionid){
    $data=array();
	global $con;
	// $last_years=getSessionByid($sessionid)['year'];
	// $last_year_arr=explode('-',$last_years);
	// $last_year=$last_year_arr[0];
	$sql="select `student_id`,`admission_date`,`create_date` from students where student_id='$stuid' ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
	    $first_month=date('m', strtotime($resc['admission_date']));
	    $first_month_name=date('M', strtotime($resc['admission_date']));
	    
	    	for($i=$first_month; $i<=15;$i++ ){
	    		// $month_id=$first_month+$i;
	    		if($i=='13'){
	    			$i='1';
	    		}elseif($i=='14'){
	    			$i='2';
	    		}elseif($i=='15'){
	    			$i='3';
	    		}
	    		$monthname=get_monthname_byid($i)['month_name'];
	    		$monthno=$i;
	    		// $monthname = date('F',strtotime('+'.$i.' month'));
	    		
	    		$temp=array();
	    		$temp['monthname']=$monthname;
	    		$temp['monthno']=ltrim($monthno,'0');

	    		array_push($data, $temp);
	    		if($monthname=='March'){
	    			break;
	    		 }	
	    		
	    	}
	    
	    return $data;
	}else{
		return '';
	}
}

function view_feedback($stuid,$class_id,$section_id,$sessionid){
	$data=array();
	global $con;
    $sql="select * from feedback where student_id='$stuid' and class_id='$class_id' and section_id='$section_id' and session='$sessionid' order by create_date desc ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		while($res=$quec->fetch_assoc()){
			$temp = array();
		   
			$temp['request_for'] = get_request_type_byid($res['request_id'])['request_name']; 
			$temp['raised_for'] = $res['raised_for'];
			
			$temp['title'] = $res['title'];
			$temp['description'] = $res['description'];
			
			$temp['response'] = ($res['response']) ? $res['response'] : '' ;
			$temp['response_status'] = $res['status'];
			
			$temp['submission_date'] = date('d-m-Y (h:i A) ', strtotime($res['create_date']));
			array_push($data,$temp);
		}
	    return $data;
	}else{
		return '';
	}
}
function view_leave_request($stuid,$class_id,$section_id,$sessionid){
	$data=array();
	global $con;
	$sql="select * from student_leave where student_id='$stuid' and class_id='$class_id' and section_id='$section_id' and session='$sessionid' order by `stu_leave_id` desc ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		while($res=$quec->fetch_assoc()){
			$temp = array();
		   
			$temp['from_date'] = $res['from_date']; 
			$temp['to_date'] = $res['to_date'];
			$temp['leave_type'] = get_leave_type_byid($res['leave_id'])['leave_name'];
			$temp['total_days'] = $res['total_days'];
			
			$temp['reason'] = $res['reason'];
			$temp['note'] = $res['note'];
			// $temp['status'] = ($res['status']=='0') ? 'Not Respond' : ($res['status']=='1') ? 'Approved' : 'Disapprove' ;
			if($res['status']=='0'){
				$temp['status'] ='Not Respond';
			}elseif($res['status']=='1'){
				$temp['status'] ='Approved';
			}else{
				$temp['status'] ='Disapprove';
			}
			
			$temp['submission_date'] = date('d-m-Y (h:i A)', strtotime($res['create_date']));
			array_push($data,$temp);
		}
	    return $data;
	}else{
		return '';
	}
}
function EmergencyContact(){
	$data=array();
	global $con;
    $sql="select * from emergency_contact where 1 ";
	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		while($res=$quec->fetch_assoc()){
			$temp = array();
		   
			
			$temp['mobile'] = $res['mobile'];
			array_push($data,$temp);
		}
	    return $data;
	}else{
		return [];
	}
}


?>