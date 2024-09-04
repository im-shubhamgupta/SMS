<?php

include('connection.php');
include('myfunction.php');

extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

// $username=$res['username']; 

$username=$_SESSION['user_roles'];



$class=$_REQUEST['class'];

$section = $_REQUEST['section'];

$range = $_REQUEST['range'];

$r1 = $_REQUEST['r1'];

$r2 = $_REQUEST['r2'];

	if($class!="" and $section!="")

		{

		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.status

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where and sr.class_id='$class' and sr.section_id='$section' and sr.session='".$_SESSION['session']."' ";			


		}		

		else if($class!="" and $section==""){

		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.status

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where sr.class_id='$class'  and sr.session='".$_SESSION['session']."' ";					

	

		}	

		else if($class=="" and $section==""){
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where 1   and sr.session='".$_SESSION['session']."' ";

	

		}

	if($range==1){
		$query.=" and a.due > 0 and a.due < '$r1' ";
	}elseif($range==2){
		$query.=" and a.due > '$r1' "; 
	}elseif($range==3){
		$query.=" and a.due between '$r1' and '$r2' "; 
	}
	$search_result = filterTable($query);

	$count_row=mysqli_num_rows($search_result);



	function filterTable($query)

	{

		include('connection.php');

		$filter_Result = mysqli_query($con,$query);

		return $filter_Result;

	}


if($count_row>0){


while($res=mysqli_fetch_array($search_result))

{

	// $set=mysqli_query($con,"select * from sms_setting");

	// $rset=mysqli_fetch_array($set);

	// $senderid=$rset['sender_id'];

	// $apiurl=$rset['api_url'];

	// $apikey=$rset['api_key'];

					

	$sset=mysqli_query($con,"select * from setting");

	$rsset=mysqli_fetch_array($sset);

	$sclname=$rsset['company_name'];

	

	$stuname=$res['student_name'];

	$regno=$res['register_no'];

	$qs = mysqli_query($con,"select * from students where register_no='$regno' and session='".$_SESSION['session']."'");

	$rs = mysqli_fetch_array($qs);

	$stuid = $rs['student_id'];

	$cid = $rs['class_id'];

	$sid = $rs['section_id'];

	$fname=$res['father_name'];

	$mobile=$res['parent_no'];

	$due=$res['due'];

	$gender=$res['gender'];

	$msgtype=$res['msg_type_id'];

	

	if($gender=="FEMALE")

	{

	 $gen="Daughter";

	}

	else

	{

	 $gen="Son";	

	}	

	

	$message = "Dear Mr. ".$fname.",%0aGentle Reminder%0aYour ".$gen." ".$stuname." fees amount Rs ".$due." is due as of today, Please pay the fees amount.%0a From,%0a".$sclname.",";

	$nmessage = "Dear Mr. ".$fname.",<br>Gentle Reminder<br>Your ".$gen." ".$stuname." fees amount Rs ".$due." is due as of today, Please pay the fees amount.<br> From,<br>".$sclname.",";

	$messagetype="due_fees_remainder";

	if($msgtype==1)

	{

		$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date)

		values(3,'$stuid','$cid ','$sid','$mobile','$nmessage','1','$username',now(),now())");

		sendwhatsappMessage($mobile,$message,$messagetype);

	}

	// else if($msgtype==2)

	// {

	// 	sendtextMessage($mobile,$nmessage,$messagetype);
	

	//Send sms to sender and reciever

		// $senderId = "$senderid";

		// $route = 4;

		// $campaign = "OTP";

		// $sms = array(

		// 	'message' => "$message",

		// 	'to' => array($mobile)

		// );

		//Prepare you post parameters

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

	// }

}}



echo "<script>window.location='dashboard.php?option=duestudents_report'</script>";

?>



	