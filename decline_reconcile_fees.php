<?php

extract($_REQUEST);



$q2 = mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id' and `session`='".$_SESSION['session']."'");

$r2 = mysqli_fetch_array($q2);

$stuid = $r2['student_id'];

$olddue = $r2['due_amount'];

$payment_detail = $r2['payment_detail'];

$amtstr = $r2['received_amount'];

$date = $r2['date'];

$amtarr = explode(',',$amtstr);

foreach($amtarr as $k)

{

	$recamt = $recamt + $k;  

}



$newdue = $olddue + $recamt;



$q3 = mysqli_query($con,"select * from students where student_id='$stuid' and `session`='".$_SESSION['session']."'");

$r3 = mysqli_fetch_array($q3);

$stuname = $r3['student_name'];

$fname=$r3['father_name'];

$mobile=$r3['parent_no'];

$modify_date=date('Y-m-d H:i:s');

$q1 = "update student_due_fees set status='2', modify_date='$modify_date' where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ";



	if(mysqli_query($con,$q1))

	{

		$q2 = mysqli_query($con,"update student_wise_fees set due_amount='$newdue'  ,modify_date='$modify_date' where student_id='$stuid' and `session`='".$_SESSION['session']."' ");

		

		$q3 = mysqli_query($con,"update students set due='$newdue',modify_date='$modify_date'   where student_id='$stuid' and `session`='".$_SESSION['session']."' ");

			

		$action = $stuname." Fees Declined"; 

		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

		machine_name,browser,date) 

		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

		

		

		$sset=mysqli_query($con,"select * from setting");

		$rsset=mysqli_fetch_array($sset);

		$sclname=$rsset['company_name'];

	

		$s1=mysqli_query($con,"select * from sms_setting");

		$r1=mysqli_fetch_array($s1);

		$status=$r1['status'];

			

		$msg = "Dear Mr. ".$fname.",%0aThe Paid Fees of ".$recamt." through Cheque No".$payment_detail." on ".$date." for your son ".$stuname." is Declined due to Cheque Bounce. Please contact Administration for more details.%0aFrom,%0aAccount Department%0a".$sclname;

		

		if($status==0)

		{

		

		$senderid=$r1['sender_id'];

		$apiurl=$r1['api_url'];

		$apikey=$r1['api_key'];

		

		//Send sms to sender and reciever

			$senderId = "$senderid";

			$route = 14;

			$campaign = 0;

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

echo "<script>window.location='dashboard.php?option=reconcile_fees'</script>";



?>