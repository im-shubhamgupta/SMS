<?php  
include('connection.php');
extract($_REQUEST);

if(!empty($feedid && $message))
{	
	
	$feedid = mysqli_real_escape_string($con, $feedid);
	$q1 = mysqli_query($con,"select * from feedback where feedback_id='$feedid'");
	$r1 = mysqli_fetch_array($q1);
	$stuid = $r1['student_id'];
	$class = $r1['class_id'];
	$section = $r1['section_id'];
	$sdate = $r1['submission_date'];
	$chgsdate = date("d-m-Y", strtotime($sdate));
	
	$reqid = $r1['request_id'];
	$q2 = mysqli_query($con,"select * from request_type where request_id='$reqid'");
	$r2 = mysqli_fetch_array($q2);
	$reqname = $r2['request_name'];
	
	$raisedfor = $r1['raised_for'];
	$title = $r1['title'];
	$desc = $r1['description'];
	
		
	$q3 = mysqli_query($con,"select * from students where student_id='$stuid'");
	$r3 = mysqli_fetch_array($q3);
	$name=$r3['student_name'];
	$mobile = $r3['parent_no'];
	$fathername=$r3['father_name'];
		
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];
		
	$response = mysqli_real_escape_string($con, $message);
   
	$que = mysqli_query($con,"update feedback set response='$response', status=1 where feedback_id='$feedid'");
	
	$msg = "Hi,<br>Please find the Response for the Feedback as below:<br>Submission Date: ".$chgsdate.
	"<br>Request Type: ".$reqname."<br>Raised For : ".$raisedfor."<br>Title: ".$title."<br>Description : "
    .$desc."<br>Response : ".$message;
	
	$q4=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)
	values(3,'$stuid','$class','$section',0,'$mobile','$msg','$user',now(),now())");
		
	/*
		//Send sms to sender and reciever
		$set=mysqli_query($con,"select * from sms_setting");
		$rset=mysqli_fetch_array($set);
		$senderid=$rset['sender_id'];
		$apiurl=$rset['api_url'];
		$apikey=$rset['api_key'];
		
		$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => "$msg",
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
	*/
	
	if($que)
	{
		echo "Saved";
	}
	else
	{
		echo "Response not Saved";
	}
}

?>