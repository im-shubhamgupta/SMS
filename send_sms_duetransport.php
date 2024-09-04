<?php

include('connection.php');
include('myfunction.php');

extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

$username=$res['username']; 



$class=$_REQUEST['class'];

$section = $_REQUEST['section'];

$range = $_REQUEST['range'];

$r1 = $_REQUEST['r1'];

$r2 = $_REQUEST['r2'];



	if($range==1)

	{

		if($class!="" and $section!="")

		{		

		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > 0 and due_amount < '$r1'";

		$search_result = filterTable($query);

		}

				

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount < '$r1'";					

		$search_result = filterTable($query);

		}

			

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where due_amount > 0 and due_amount < '$r1'";

		$search_result = filterTable($query);

		}

		

	}

	

	else if($range==2)

	{

		

		if($class!="" and $section!="")

		{

		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > '$r1'";			

		$search_result = filterTable($query);

		}

				

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount > '$r1'";					

		$search_result = filterTable($query);

		}

			

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where due_amount > '$r1'";

		$search_result = filterTable($query);

		}

		

	}

	

	else if($range==3)

	{

		

		if($class!="" and $section!="")

		{

		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount between '$r1' and '$r2'";			

		$search_result = filterTable($query);

		}

				

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' and due_amount between '$r1' and '$r2'";					

		$search_result = filterTable($query);

		}

			

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where due_amount between '$r1' and '$r2'";

		$search_result = filterTable($query);

		}

		

	}

	

	

	function filterTable($query)

	{

		include('connection.php');

		$filter_Result = mysqli_query($con,$query);

		return $filter_Result;

	}





while($res=mysqli_fetch_array($search_result))

{

	$set=mysqli_query($con,"select * from sms_setting");

	$rset=mysqli_fetch_array($set);

	$senderid=$rset['sender_id'];

	$apiurl=$rset['api_url'];

	$apikey=$rset['api_key'];

					

	$sset=mysqli_query($con,"select * from setting");

	$rsset=mysqli_fetch_array($sset);

	$sclname=$rsset['company_name'];

	

	$stuid=$res['student_id'];

	$qst1 = mysqli_query($con,"select * from students where student_id='$stuid'");

	$rst1 = mysqli_fetch_array($qst1);

	$stuname=$rst1['student_name'];

	$regno=$rst1['register_no'];

	$fname=$rst1['father_name'];

	$mobile=$rst1['parent_no'];

	$gender=$rst1['gender'];

	$msgtype=$rst1['msg_type_id'];

	

	$cid=$res['class_id'];

	$sid=$res['section_id'];

	$due=$res['due_amount'];

	

	

	if($gender=="FEMALE")

	{

	 $gen="Daughter";

	}

	else

	{

	 $gen="Son";	

	}	

	$messagetype="due_transport_fees_remainder";

	$message = "Dear Mr. ".$fname.",%0aGentle Reminder%0aYour ".$gen." ".$stuname." Transport fees amount Rs ".$due." is due as of today, Please pay the amount.%0a From,%0a".$sclname.",";

	$nmessage = "Dear Mr. ".$fname.",<br>Gentle Reminder<br>Your ".$gen." ".$stuname." Transport fees amount Rs ".$due." is due as of today, Please pay the amount.<br> From,<br>".$sclname.",";

	

	if($msgtype==1)

	{

		$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,loginuser,notice_datetime,date)

		values(3,'$stuid','$cid ','$sid','$mobile','$nmessage','$username',now(),now())");

		sendwhatsappMessage($mobile,$message,$messagetype);

	}

	else if($msgtype==2)

	{

	sendtextMessage($mobile,$nmessage,$messagetype);

	//Send sms to sender and reciever

		// $senderId = "$senderid";

		// $route = 4;

		// $campaign = "OTP";

		// $sms = array(

		// 	'message' => "$message",

		// 	'to' => array($mobile)

		// );

		// //Prepare you post parameters

		// $postData = array(

		// 	'sender' => $senderId,

		// 	'campaign' => $campaign,

		// 	'route' => $route,

		// 	'sms' => array($sms)

		// );

		// $postDataJson = json_encode($postData);



		// $url="$apiurl";



		// $curl = curl_init();

		// curl_setopt_array($curl, array(

		// 	CURLOPT_URL => "$url",

		// 	CURLOPT_RETURNTRANSFER => true,

		// 	CURLOPT_CUSTOMREQUEST => "POST",

		// 	CURLOPT_POSTFIELDS => $postDataJson,

		// 	CURLOPT_HTTPHEADER => array(

		// 		"authkey:"."$apikey",

		// 		"content-type: application/json"

		// 	),

		// ));

		// $response = curl_exec($curl);

		// $err = curl_error($curl);

		// curl_close($curl);

		

	//Send sms to sender and reciever

	}

}



echo "<script>window.location='dashboard.php?option=due_transport_report'</script>";

?>



	