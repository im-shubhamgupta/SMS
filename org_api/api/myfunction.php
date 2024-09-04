<?php
include('../connection.php');
error_reporting(1);
extract($_REQUEST);	
function chkMobile($mobile)
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


function verify($mobile,$password)
{
	global $con;
	$query_otp=mysqli_query($con,"select * from students where parent_no='$mobile' && password='$password'");
	
	if(mysqli_num_rows($query_otp)>0)
	{
		$que = mysqli_query($con,"select * from students where parent_no='$mobile'");
		$res = mysqli_fetch_assoc($que);
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
		echo json_encode($temp);
	}
	else
	{
		return "Wrong password";
	}
}


function installedapp($mobile)
{
	global $con;
	
	$qu = mysqli_query($con,"select * from installed_app where parent_no='$mobile'");
	$row = mysqli_num_rows($qu);
	if(!$row)
	{
		$que1 = mysqli_query($con,"select * from students where parent_no='$mobile'");
		while($res1 = mysqli_fetch_array($que1))
		{
			$stuid = $res1['student_id'];
			$regno = $res1['register_no'];
			$stuname = $res1['student_name'];
			
			$query = mysqli_query($con,"insert into installed_app(student_id,register_no,student_name,parent_no) 
			values('$stuid','$regno','$stuname','$mobile')");
		}
		$temp['status'] = "inserted";
		echo json_encode($temp);
	}
	else
	{
		return "Not Inserted";
	}
}


function profile($mobile,$regno)
{
	global $con;
	$qprofile=mysqli_query($con,"select * from students where parent_no='$mobile' && register_no='$regno'");
	
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
		$temp['academic_year'] = $res['academic_year'];
		$temp['stu_image'] = $res['stu_image'];
		$temp['stu_id'] = $res['student_id'];
		echo json_encode($temp);
	}
	else
	{
		return "Invalid Details";
	}
}


function fees($regno)
{
	global $con;
	$data = array();
	$query_fee = mysqli_query($con,"select * from students where register_no='$regno'");
	$row = mysqli_num_rows($query_fee);
	if($row)
	{
		
		$res = mysqli_fetch_assoc($query_fee);
		$stuid = $res['student_id'];
		
		$qt1 = mysqli_query($con,"select * from student_route where student_id='$stuid'");
		$rt1 = mysqli_fetch_assoc($qt1);
		$transid = $rt1['trans_id'];
		$transprice = $rt1['price'];
		
		$qt2 = mysqli_query($con,"select * from transports where trans_id='$transid'");
		$rt2 = mysqli_fetch_assoc($qt2);
		$routename = $rt2['route_name'];
		
		$qt3 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
		$rt3 = mysqli_fetch_assoc($qt3);
		
		$feehead = $rt3['fee_header_id'];
		$headarr = explode(',',$feehead);
		$feeamt = $rt3['fee_amount'];
		$amtarr = explode(',',$feeamt);
				
		$qt4 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid'");
		$rt4 = mysqli_fetch_assoc($qt4);
		$duefeehead = $rt4['fee_header_id'];
		$dueheadarr = explode(',',$duefeehead);
		$duefeeamt = $rt4['received_amount'];
		$dueamtarr = explode(',',$duefeeamt);
		
		$transpaid = $rt4['transport_amount'];	
				
		$feeheadcount = sizeof($headarr);
		$tbal = 0;
		$dueamount = 0;
		$totalfees = 0;
		$totalpaid = 0;
		$totaldue = 0;
		$paidfeeamount = 0;
		for($i=0;$i<$feeheadcount;$i++)
		{
		
		$feeid = $headarr[$i];
		$feeamount = $amtarr[$i];
		
		$duefeeid = $dueheadarr[$i];		
		$paidfeeamount = $dueamtarr[$i];
		
		if($feeid == $duefeeid)
		{
			$dueamount = $feeamount - $paidfeeamount;
		}
			$totalfees = $totalfees + $feeamount; 
			$totalpaid = $totalpaid + $paidfeeamount; 
						
			//$gtotalfees = $totalfees + $transprice;
			//$gtotalpaid = $totalpaid + $transpaid;
			//$totaldue = $gtotalfees - $gtotalpaid; 
			
		$q2 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
		$r2 = mysqli_fetch_array($q2);
		$fname = $r2['fee_header_name'];	
		
		
		$temp['Fee Header'] = $fname;
		$temp['Fee'] = $feeamount;
		$temp['Paid Fee'] = $paidfeeamount;
		array_push($data,$temp);
		}
		echo json_encode($data);
		
		$temp['Routename'] = $routename;
		$temp['Transport Fee'] = $transprice;
		$temp['Transport Fee Paid'] = $transpaid; 
		echo json_encode($temp);
		
		
		// $temp['Total Fees'] = $gtotalfees;
		// $temp['Total Paid'] = $gtotalpaid;
		// $temp['Total Due'] = $totaldue;
		
		//echo json_encode($temp);
		
	}
	else
	{
		return "Register No. not Exists.";
	}
}


function announcement($stuid)
{
	
	global $con;
	$data = array();
	
	$query_ann = mysqli_query($con,"select * from student_notifications where category='1' && student_id='$stuid' order by date desc");
		
	if(mysqli_num_rows($query_ann))
	{
		
		while($res = mysqli_fetch_assoc($query_ann))
		{
			
			@$temp = array();
			$temp['st_notification_id'] = $res['st_notification_id'];
			$temp['message'] = $res['message'];
			$temp['date'] = $res['date'];
			$temp['status'] = $res['status'];
			array_push($data, $temp);
		}
		echo json_encode($data);
	}
	else
	{
		return "No Announcement";
	}

}


function announcementcount($stuid)
{
	global $con;
	
	$data = array();
	
	$query_ann1 = mysqli_query($con,"select * from student_notifications where category='1' && student_id='$stuid' GROUP BY `message` order by date desc");
		
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
		echo json_encode($data);
		
	}
	else
	{
		return "No Announcement";
	}
}


function homework($classid,$sectionid,$subject,$stuid)
{
	global $con;
	
	$query_home = mysqli_query($con,"select * from student_notifications where class_id='$classid' && section_id='$sectionid' && subject='$subject' && student_id='$stuid' && category='2' order by date desc");
		
	if(mysqli_num_rows($query_home))
	{
			$data = array();
			
			while($res = mysqli_fetch_assoc($query_home))
			{
				
			@$temp = array();
			$temp['st_notification_id'] = $res['st_notification_id'];
			$temp['message'] = $res['message'];
			$temp['date'] = $res['date'];
			$temp['status'] = $res['status'];
			array_push($data, $temp);
			}
			echo json_encode($data);
	}
	else
	{
		return "No Homework";
	}

}


function homeworkcount($stuid)
{
	global $con;
	
	$data = array();
	
	$query_ann1 = mysqli_query($con,"select * from student_notifications where category='2' && student_id='$stuid' order by date desc");
		
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
		echo json_encode($data);
		
	}
	else
	{
		return "No Homework";
	}
}


function message($classid,$sectionid,$stuid)
{
	global $con;
	
	$data = array();
		
	$query_msg = mysqli_query($con,"select `st_notification_id`,`message`,`date`,`status` from student_notifications where class_id='$classid' && section_id='$sectionid' && student_id='$stuid' && category='3' order by date desc");	
	
	if(mysqli_num_rows($query_msg))
	{	
		while($res = mysqli_fetch_assoc($query_msg))
		{
			
		@$temp = array();
		$temp['st_notification_id'] = $res['st_notification_id'];
		$temp['message'] = $res['message'];
		$temp['date'] = $res['date'];
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		echo json_encode($data);
		
	}
	else
	{
		return "No Message";
	}
}


function messagestatusupdate($id)
{
	global $con;
	
	$data = array();
	
	$query_msg = mysqli_query($con,"update student_notifications set status='1' where st_notification_id='$id'");
			
	if($query_msg)
	{	
		return "Updated Successfully.";
	}
	else
	{
		return "Not Updated.";
	}
}


function messagecount($classid,$sectionid,$stuid)
{
	global $con;
	
	$data = array();
	
	$query_msg = mysqli_query($con,"select `message`,`date`,`status` from student_notifications where class_id='$classid' && section_id='$sectionid' && student_id='$stuid' && category='3' order by date desc");
		
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
		echo json_encode($data);
		
	}
	else
	{
		return "No Message";
	}
}


function gallery($classid,$sectionid,$stuid)
{
	global $con;		
	$query_gal = mysqli_query($con,"SELECT * from student_notifications where class_id='$classid' && section_id='$sectionid' && student_id='$stuid' && category='4' order by date desc");
	
	if(mysqli_num_rows($query_gal))
	{
		$data = array();
		while($res = mysqli_fetch_assoc($query_gal))
		{
		
		@$temp = array();
		$temp['st_notification_id'] = $res['st_notification_id'];
		$temp['message'] = $res['message'];
		$temp['photos'] = $res['photos'];
		$temp['date'] = $res['date'];
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		
		echo json_encode($data);
	}
	else
	{
		return "No Pictures";
	}
}


function gallerycount($stuid)
{
	global $con;
	
	$data = array();
	
	$query_gal = mysqli_query($con,"select * from student_notifications where student_id='$stuid' && category='4' order by date desc");
		
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
		echo json_encode($data);
		
	}
	else
	{
		return "No gallery";
	}
}


function allcount($stuid)
{
	global $con;
	
	$data = array();
	$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
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
		if(mysqli_num_rows($qannounce))
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
			
			echo json_encode($data);			
	}		
	else
	{
		return "Invalid Id";
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
		
		echo json_encode($data);
	}
	else
	{
		return "No Subjects";
	}
}


function userdetail($mobile)
{
	global $con;		
	$query_uesr = mysqli_query($con,"SELECT * from students where parent_no='$mobile'");
	
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
		$temp['academic_year'] = $res['academic_year'];
		$temp['stu_image'] = $res['stu_image'];
		$temp['stu_id'] = $res['student_id'];
		array_push($data, $temp);
		}
		
		echo json_encode($data);
	}
	else
	{
		return "Invalid Mobile";
	}
}


function stuyearlyattendance($stuid,$years)
{
	global $con;
	
	$data = array();
	$yr = "april".$years;
	$start = strtotime($yr);
	
	$monthlypercent=0;
		$totalpresentyearly = 0;
		$totalabsentyearly = 0;
		$totalleaveyearly = 0;
		$totalpercentageyearly = 0;
		$totalattendanceyearly = 0;
		
	for ($i = 0; $i <= 11; $i++) 
	{
	$time = strtotime(sprintf('+%d months', $i), $start);
	$label = date('F Y', $time);
	$month = date('m', $time);
	$year = date('Y', $time);
	
	$qatt = mysqli_query($con,"select * from student_daily_attendance where register_no='$stuid' && month(date)='$month' && year(date)='$year'");	
		
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
		
		}
		$totalmonthlypresent = $present+$leave;
		$monthlypercent = round($totalmonthlypresent/$totalrow*100,2)." %";
		
		$totalpresentyearly = $totalpresentyearly+$present;
		$totalabsentyearly = $totalabsentyearly+$absent;
		$totalleaveyearly = $totalleaveyearly+$leave;				
		$totalattendanceyearly = $totalattendanceyearly+$totalrow;				
		$totalpercentageyearly = round(($totalpresentyearly+$totalleaveyearly)/$totalattendanceyearly*100,2)."%";			
		
		@$temp = array();		
		$temp['monthname'] = $label; 	
		$temp['totalmonthlypresent'] = $totalmonthlypresent; 	
		$temp['totalattendance'] = $totalrow; 	
		$temp['totalmonthlypercentage'] = $monthlypercent; 	
		array_push($data, $temp);	
	}
	if($qatt)
	{
		
		$temp['totalpresentyearly'] = $totalpresentyearly; 
		$temp['totalabsentyearly'] = $totalabsentyearly; 
		$temp['totalleaveyearly'] = $totalleaveyearly; 
		$temp['totalattendanceyearly'] = $totalattendanceyearly; 
		$temp['totalpercentageyearly'] = $totalpercentageyearly; 
		
		array_push($data, $temp);
		
		echo json_encode($data);
	}
	else
	{
		return "Invalid Details";
	}
			
}


function stumonthlyattdetail($stuid,$month)
{
	global $con;
	
	$data = array();
	$start = strtotime($month);
	
	$time = strtotime(sprintf('+%d months', $i), $start);
	$label = date('F Y', $time);
	$month = date('m', $time);
	$year = date('Y', $time);
	
	$qatt = mysqli_query($con,"select * from student_daily_attendance where register_no='$stuid' && month(date)='$month' && year(date)='$year'");	
		
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
		$percent = round($totalpresent/$totalrow*100,2)." %";
		
		
	if($qatt)
	{
		
		@$temp = array();		
		$temp['presentdays'] = $presentday; 	
		$temp['absentdays'] = $absentday; 	
		$temp['leavedays'] = $leaveday; 	
		$temp['monthname'] = $label; 	
		$temp['totalpresent'] = $totalpresent; 	
		$temp['totalabsent'] = $totalabsent; 	
		$temp['totalleave'] = $totalleave; 	
		$temp['totalattendance'] = $totalrow; 	
		$temp['totalmonthlypercentage'] = $percent; 	
		array_push($data, $temp);
		echo json_encode($data);
		
	}
	
	else
	{
		return "Invalid Details";
	}
			
}


function studymaterial($stuid)
{
	global $con;

	$q1 = mysqli_query($con,"select * from students where register_no='$stuid'");
	$r1 = mysqli_fetch_array($q1);
	$classid = $r1['class_id'];
	$sectionid = $r1['section_id'];
	$studentid = $r1['student_id'];
	
	$query_stu_mat = mysqli_query($con,"SELECT * from student_notifications where class_id='$classid' && section_id='$sectionid' && student_id='$studentid' && category='6' order by date desc");
	
	if(mysqli_num_rows($query_stu_mat))
	{
		$data = array();
		while($res = mysqli_fetch_assoc($query_stu_mat))
		{
		
		@$temp = array();
		$temp['message'] = $res['message'];
		$temp['photos'] = $res['photos'];
		$temp['date'] = $res['date'];
		array_push($data, $temp);
		}
		
		echo json_encode($data);
	}
	else
	{
		return "No Pictures";
	}
}


function importantinfo($stuid)
{
	global $con;

	$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
	$r1 = mysqli_fetch_array($q1);
	$classid = $r1['class_id'];
	$sectionid = $r1['section_id'];
	$pnumber = $r1['parent_no'];
	
	$query_stu_mat = mysqli_query($con,"SELECT * from student_notifications where student_id='$stuid' && category='5' order by date desc");
	
	if(mysqli_num_rows($query_stu_mat))
	{
		$data = array();
		while($res = mysqli_fetch_assoc($query_stu_mat))
		{
		
		@$temp = array();
		$temp['st_notification_id'] = $res['st_notification_id'];
		$temp['message'] = $res['message'];
		$temp['date'] = $res['date'];
		$temp['status'] = $res['status'];
		array_push($data, $temp);
		}
		
		echo json_encode($data);
	}
	else
	{
		return "No Important Information";
	}
}


function importantinfocount($stuid)
{
	global $con;
	
	$data = array();
	
	$query_imp = mysqli_query($con,"select * from student_notifications where category='5' && student_id='$stuid' order by date desc");
		
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
		echo json_encode($data);
		
	}
	else
	{
		return "No Important Message";
	}
}


function exam($stuid)
{
	global $con;		
	$query_uesr = mysqli_query($con,"SELECT * from students where register_no='$stuid'");

		$data = array();
		$res = mysqli_fetch_assoc($query_uesr);
		$clsid = $res['class_id'];
		
		$secid = $res['section_id'];
		
	$q2 = mysqli_query($con,"select * from test where class_id='$clsid' && section_id='$secid'");
	if(mysqli_num_rows($q2))
	{
		while($r2 = mysqli_fetch_array($q2))
		{	
			$subjectid = $r2['subject_id'];
			$s1 = mysqli_query($con,"select * from subject where subject_id='$subjectid'");
			$sr1 = mysqli_fetch_array($s1);
			$subjectname = $sr1['subject_name'];
			
		
		@$temp = array();
		$temp['test_date'] = $r2['test_date']; 
		$temp['starttime'] = $r2['starttime']; 
		$temp['endtime'] = $r2['endtime'];
		$temp['$subjectname'] = $subjectname;
		$temp['room_no'] = $r2['room_no'];
		$temp['test_name'] = $r2['test_name'];
		
		array_push($data, $temp);
		}
		
		echo json_encode($data);
	}
	else
	{
		return "No Exam Scheduled";
	}
}


function subjectyearlyattendance($regno,$years)
{
	global $con;
	
	$data = array();
	$yr = "april".$years;
	$start = strtotime($yr);
	for ($i = 0; $i <= 11; $i++) 
	{
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
	$temp['monthname'] = $label; 
	$temp['subjectname'] = $subname; 
	$temp['count'] = $row;
	array_push($data, $temp);	
	}
	
	if($q2)
	{
	echo json_encode($data);
	}
	else
	{
		return "Invalid Details";
	}
			
}


function reportcard($stuid)
{
	global $con;		
	$data = array();
	$query_mark = mysqli_query($con,"select * from marks where student_id='$stuid'");
	
	$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
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
			
			$q3 = mysqli_query($con,"select * from test where test_name='$testname' && class_id='$clsid' && 
			section_id='$secid' && subject_id='$subid'");
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
		echo json_encode($data);
	}
	else
	{
		return "Marks Not Entered";
	}
}


function reportcardsummary($stuid)
{
	global $con;		
	
	$query_mark = mysqli_query($con,"select * from marks where student_id='$stuid'");
	
	$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
	$r1 = mysqli_fetch_array($q1);
	$clsid = $r1['class_id'];
	$secid = $r1['section_id'];
	
		$data = array();
		$totalmarksobtained = 0;
		$totalmarks = 0;
		while($res = mysqli_fetch_assoc($query_mark))
		{		
			$testname = $res['test_name'];
			$subid = $res['subject_id'];
			$q2 = mysqli_query($con,"select * from subject where subject_id='$subid'");
			$r2 = mysqli_fetch_array($q2);
			$subname = $r2['subject_name'];
			
			$q3 = mysqli_query($con,"select * from test where test_name='$testname' && class_id='$clsid' && 
			section_id='$secid' && subject_id='$subid'");
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
			$temp['testname'] = $testname;
		}
	
		$temp['Grandtotal'] = $totalmarksobtained."/".$totalmarks;
		$temp['Percentage'] = $percentage."%";
		$temp['Grade'] = $grade;
	if($query_mark)
	{
		
		array_push($data, $temp);
		echo json_encode($data);
	}
	else
	{
		return "Marks Not Entered";
	}
}


function eventcalendar($fromdate,$todate,$classid,$sectionid)
{
	global $con;
	$data = array();
	$nfromdate = date("Y-m-d", strtotime($fromdate));
	
    $ntotdate = date("Y-m-d", strtotime($todate));
	               
	$q1=mysqli_query($con,"select * from events where class_id IN (0,'$classid') AND 
	section_id IN (0,'$sectionid') AND from_date>='$nfromdate' AND to_date<='$ntotdate'");
	
	$row = mysqli_num_rows($q1);
	if($row)
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$efor = $r1['event_for'];
			$qevent=mysqli_query($con,"select * from event_type where event_id='$efor'");
			$revent=mysqli_fetch_array($qevent);
			$eventfor=$revent['event_name'];

			$fdate = $r1['from_date'];
			$fromdate = date("d-m-Y", strtotime($fdate));
			$tdate = $r1['to_date'];
			$todate = date("d-m-Y", strtotime($tdate));
			
			@$temp = array();
			$temp['Event Name'] = $r1['event_heading'];
			$temp['Event For'] = $eventfor;
			$temp['Event Description'] = $r1['description'];
			$temp['From Date'] = $fromdate;
			$temp['To Date'] = $todate;
			array_push($data, $temp);
		}
		
		echo json_encode($data);
	}
	else
	{
		echo "No Events";
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
		
		echo json_encode($data);
	}
	else
	{
		return "No Details";
	}
}


function leaverequest($dateofsubmission,$classid,$sectionid,$studentid,$fromdate,$todate,$leavetypeid,$noofdays,$reason,$note)
{
	global $con;
	$data = array();
	
	$submitdate = $dateofsubmission;
	$nsubmitdate = date("Y-m-d", strtotime($submitdate));
	$fdate = $fromdate;
	$nfdate = date("Y-m-d", strtotime($fdate));
	$tdate = $todate;
	$ntdate = date("Y-m-d", strtotime($tdate));

	$q1 = mysqli_query($con,"select * from student_leave where student_id='$studentid' && 
	class_id='$classid' && section_id='$sectionid' && from_date='$nfdate' && to_date='$ntdate'");
	
	$row = mysqli_num_rows($q1);
	if(!$row)
	{
		$q2 = mysqli_query($con,"insert into student_leave (student_id,class_id,section_id,
		submission_date,from_date,to_date,leave_id,total_days,reason,note) 
		values ('$studentid','$classid','$sectionid','$nsubmitdate','$nfdate','$ntdate',
		'$leavetypeid','$noofdays','$reason','$note')");
		
		echo "Inserted";
	}
	else
	{
		echo "Already Exists";
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
		
		echo json_encode($data);
	}
	else
	{
		return "No Details";
	}
}


function feedback($dateofsubmission,$classid,$sectionid,$studentid,$requestid,$raisedfor,$title,$description)
{
	global $con;
	
	$submitdate = $dateofsubmission;
	$nsubmitdate = date("Y-m-d", strtotime($submitdate));
	
	$que = mysqli_query($con,"insert into feedback (class_id,section_id,submission_date,student_id,request_id,raised_for,title,description,status) 
	values('$classid','$sectionid','$nsubmitdate','$studentid','$requestid','$raisedfor','$title','$description',0)");
	
	if($que)
	{
		echo "Inserted";
	}
	else
	{
		echo "Not Inserted";
	}
	
}


function timetable($classid,$sectionid)
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
			$q5 = mysqli_query($con,"select * from staff where st_id='$staffid'");
			$r5 = mysqli_fetch_array($q5);
			$stname = $r5['staff_name'];
			}
			
			$temp['period']= "Period ".$period;
			$temp['time']= $nsttime." - ".$nendtime;
			$temp['subjectname']= $subname;
			$temp['staffname']= $stname;
			array_push($data, $temp);
			}
					
		}

			echo json_encode($data);
	}
	else
	{
		echo "Time Table Not Created Yet";
	}
}


?>