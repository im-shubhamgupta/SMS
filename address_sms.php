<?php 
include('connection.php');
extract($_REQUEST);
	
	$api_key = '26016A9F9C924D';
$contacts = '9871980749,9868538503';
$from = 'TXTSMS';
$sms_text = urlencode('Hello People, have a great day');

//Submit to server

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, "http://msg.pwasms.com/app/smsapi/index.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=0&routeid=14&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text&template_id=1234567890);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
		

?>

<html>
<head>
<title></title>
<META NAME="DESCRIPTION" CONTENT="">
<META NAME="KEYWORDS" CONTENT="">



</head>

<body>

	 <form method=post>

<input type="submit" name="save" value="submit"/>

</form>
</body>
</html>


<!-- https://stackoverflow.com/questions/39785117/jquery-validation-for-select-at-least-one-check-box -->