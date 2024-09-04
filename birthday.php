<?php
include('connection.php');
if(isset($save))
{
	$q = mysqli_query($con,"select * from automatic_messages where id='1'");
	$r = mysqli_fetch_array($q);
	$status = $r['status'];
	if($status==0)
	{
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];

	//date_default_timezone_set("Asia/Kolkata");
	
	$m = date("m");//Month

	$d = date("d");//Day

	$que = mysqli_query($con,"SELECT * FROM students WHERE stu_status='0' && MONTH(dob) = '$m' && DAY(dob) = '$d'");
	while($res = mysqli_fetch_array($que))
	{
		$stuname = $res['student_name'];
		$stumobile = $res['student_contact'];
		
		$msg = $sclname." wishes you a Very Happy Birthday. Have a GREAT DAY!!!";
		
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
	
	$totalpayble=$_REQUEST['totalpayble'];
	$amtdue=$_REQUEST['amtdue'];
		
	//Send sms to sender and reciever
		$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => $msg,
			'to' => array($stumobile)
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
}
?>


<form method="post">
<input type="submit" name="save" value="send msg">
</form>