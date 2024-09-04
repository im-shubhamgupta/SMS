<?php
include('connection.php');
extract($_REQUEST);

$email=$_REQUEST["email"];
$query=mysqli_query($con,"select * from users where email='$email'");
$result = mysqli_num_rows($query);
if($result)
{
	
$row=mysqli_fetch_array($query);
$mobile=$row['phone'];
$pass=$row['pass'];

$query1=mysqli_query($con,"select * from setting");
$res=mysqli_fetch_array($query1);
$cname=$res['company_name'];
$cemail=$res['company_email'];

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
			'message' => "Your Login Password is: ".$row["pass"],
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
	
	echo "<script>window.location='index.php'</script>";
}
else
{
	echo "<script>alert('Invalid Email Id, Please Enter Correct Email.')</script>";
	echo "<script>window.location='forget_password.php'</script>";
}

  
  
  ?>