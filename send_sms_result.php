<?php

include('connection.php');
include('myfunction.php');

extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

$username=$res['username']; 

$class=$_REQUEST['class'];

$section = $_REQUEST['section'];

$test = $_REQUEST['test'];

$x=1;
$que = mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test'   && session='".$_SESSION['session']."' ");
if(mysqli_num_rows($que)>0){
while($rque = mysqli_fetch_array($que))

{

	$subidarr[] = $rque['subject_id'];

}

}
$que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'  && session='".$_SESSION['session']."' ");
if(mysqli_num_rows($que2)>0){	
while($res2=mysqli_fetch_array($que2))

{

	$stuid = $res2['student_id'];

	$total = 0;

	$totalmarks = 0;

	$testmarks = "";

	foreach($subidarr as $v)

	{

	$snm = mysqli_query($con,"select * from subject where subject_id='$v'");

	$rnm = mysqli_fetch_array($snm);

	$subname = $rnm['subject_name'];

	$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$v' && student_id='$stuid'");

	$res3 = mysqli_fetch_array($que3);
		// echo "<pre>";
		// print_r($res3);
		// echo "</pre>";

	$stumarks = $res3['marks'];

	$tmarks = $res3['max_mark'];

	if($stumarks)

	{

		$marks = $stumarks;

	}

	else

	{

		$marks = 0;

	}

	$total = $total+$marks;

	$totalmarks = $totalmarks+$tmarks;
	if($totalmarks==0 || $totalmarks=='' ){  //make due to create error can't devide by zero
		$totalmarks=1;
	}
	if($tmarks=='' ){  //make due to create error
		$tmarks=0;
	}


	$testmarks = $testmarks.$subname." ".$marks."(".$tmarks.")".", ";

	}

	

	$percent = round($total/$totalmarks*100,2);						

	$que4 = mysqli_query($con,"select * from grade where (condition1 <='$percent' && condition2 >='$percent')");

	$row = mysqli_num_rows($que4);

	if($row)

	{

		$res4 = mysqli_fetch_array($que4);

		$gr = $res4['grade_name'];

	}
				

	$sset=mysqli_query($con,"select * from setting");

	$rsset=mysqli_fetch_array($sset);

	$sclname=$rsset['company_name'];

	$que3 = mysqli_query($con,"select * from students where student_id='$stuid'");

	$res3 = mysqli_fetch_array($que3);

	$stuname=$res3['student_name'];

	$fname=$res3['father_name'];

	$mobile=$res3['parent_no'];

	$gender=$res3['gender'];

	$msgtype=$res3['msg_type_id'];

	$messagetype = "send_result";
					

	if($gender=="FEMALE")

	{

	 $gen="Daughter";

	}

	else

	{

	 $gen="Son";	

	}	
	if($totalmarks==1 || $totalmarks=='' ){  // show zero marks
		$totalmarks=0;
	}
	
	$message = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." Test marks for the ".$test." as follows:%0a".$testmarks."%0aTotal: ".$total."(".$totalmarks.") with Grade ".$gr."%0aFrom,%0a".$sclname;
	$nmessage = "Dear Mr. ".$fname.",<br>Your ".$gen." ".$stuname." Test marks for the ".$test." as follws:<br>".$testmarks."<br>Total: ".$total."(".$totalmarks.") with Grade ".$gr."<br>From,<br>".$sclname;
	

	if($msgtype==1)

	{

		//Send message via whatsapp

		$msg = $message;

		sendwhatsappMessage($mobile, $msg, $messagetype);
		



		//Send message via whatsapp

	}

	else if($msgtype==2)

	{

		//Send text message

		$msg = $nmessage; 

		sendtextMessage($mobile, $msg, $messagetype);

		//Send text message

		

	}

}
}



echo "<script>window.location='dashboard.php?option=send_result'</script>";

?>



	