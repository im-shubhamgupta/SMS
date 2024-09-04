<?php
include('connection.php');
if(isset($save))
{
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];

	date_default_timezone_set("Asia/Kolkata");
	
	$currdate = date("Y-m-d");//Month
	//die();

	$que = mysqli_query($con,"SELECT * FROM student_due_fees WHERE month='$currdate'");
	while($res = mysqli_fetch_array($que))
	{
		
		$stuid = $res['student_id'];
		$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
		$r1 = mysqli_fetch_array($q1);
		$fname = $r1['father_name'];
		$gender=$r1['gender'];
		if($gender=="FEMALE")
		{
		 $gen="Daughter";
		}
		else
		{
		 $gen="Son";	
		}	
		
		$stuname = $r1['student_name'];
		$mobile = $r1['parent_no'];
		$due=$r1['due'];
		
		$msg = "Dear Mr. ".$fname.",%0aGentle Reminder%0aYour ".$gen." ".$stuname." fees amount Rs ".$due." is due for Today, Please pay the fees amount.%0aFrom,%0a".$sclname.",";
		
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];

		
	//Send sms to sender and reciever
		$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => $msg,
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
	}

}
?>


<form method="post">
<input type="submit" name="save" value="send msg">
</form>