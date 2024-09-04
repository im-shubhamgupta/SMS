<?php include('../myfunction.php')?>
<?php 

date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['Update_declined_fee_status'])){

	// echo "<pre>";
	// print_r($_POST);
	$id=mysqli_real_escape_string($con,$_POST['id']);
	$name=mysqli_real_escape_string($con,$_POST['name']);
	$regno=mysqli_real_escape_string($con,$_POST['regno']);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	$payment_detail=mysqli_real_escape_string($con,$_POST['payment_detail']);
	$date=mysqli_real_escape_string($con,$_POST['date']);
	$amtpaid=mysqli_real_escape_string($con,$_POST['amtpaid']);
	$status=mysqli_real_escape_string($con,$_POST['status']);
	$comment=mysqli_real_escape_string($con,$_POST['comment']);
	
	$modify_date=date('Y-m-d H:i:s');

	$query = "update student_due_fees set payment_detail='$payment_detail', issue_date='$date', date='$date', 	comment='$comment', status=3,modify_date='$modify_date' where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ";

	if(mysqli_query($con,$query)){
		

		$que1 = mysqli_query($con,"update students set due='$dueamt' ,modify_date='$modify_date'  where student_id='$stuid'  ");//and `session`='".$_SESSION['session']."'

		$que2 = mysqli_query($con,"update student_wise_fees set due_amount='$dueamt' ,modify_date='$modify_date'  where student_id='$stuid' and `session`='".$_SESSION['session']."'");
		if($que1 && $que2 ){

			$responce['status']="success";
		   $responce['msg']="Update declined fees Sucessfully";
		}else{
			$responce['status']="error";
		   $responce['msg']="Something Went happend, Please try again";
		}


	}else{
		$responce['status']="error";
		$responce['msg']="Something Went wrong, Please try again";
	}
echo json_encode($responce);

}

if(isset($_POST['Create_Previous_Fees'])){
	// 	echo "<pre>";
	// print_r($_POST);
	$classid=mysqli_real_escape_string($con,$_POST['classid']);
	$sectionid=mysqli_real_escape_string($con,$_POST['sectionid']);
	$student=mysqli_real_escape_string($con,$_POST['student']);
	$prevfee=mysqli_real_escape_string($con,$_POST['prevfee']);
	$remark=mysqli_real_escape_string($con,$_POST['remark']);


	// $que = mysqli_query($con,"select * from students where student_id='$student' and session='".$_SESSION['session']."' ");
	$que=mysqli_query($con,"select `student_name`,`register_no`,`due`,`father_name`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$student' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");

	$res = mysqli_fetch_array($que);

	$stuname = $res['student_name'];

	$olddue = $res['due'];

	$newdue = $olddue + $prevfee;

	

	$que1 = mysqli_query($con,"select * from student_wise_fees where student_id='$student'  and session='".$_SESSION['session']."' ");

	$res1 = mysqli_fetch_array($que1);

	$oldfee1 = $res1['due_amount'];

	$newdue1 = $oldfee1 + $prevfee;

	

	$q1 = mysqli_query($con,"select * from previous_fees where student_id='$student' and session='".$_SESSION['session']."'");

	$row = mysqli_num_rows($q1);

	if($row){

		$responce['status']="error";
		$responce['msg']="Previous Fees for ".$stuname." Already Entered.";

	}else{
		$create_date=date('Y-m-d H:i:s');
		$modify_date=$create_date;

		$q2 = "insert into previous_fees (student_id,class_id,section_id,previous_fees,remarks,session,create_date,modify_date) values('$student','$classid','$sectionid','$prevfee','$remark','".$_SESSION['session']."','$create_date','$modify_date')";

		if(mysqli_query($con,$q2)){
			// $action = "Previous Fees for ".$stuname." is Created"; 
			// $q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,	machine_name,browser,date) 	values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			// $que1=....$con,"update students set due='$newdue',`modify_date`='$modify_date' where student_id='$student' and session='".$_SESSION['session']."' ");

			// $que2=...$con,"update student_due_fees set due_amount='$newdue' ,`modify_date`='$modify_date' where student_id='$student' and session='".$_SESSION['session']."'");

			// $que3=...$con,"update student_wise_fees set due_amount='$newdue1' ,`modify_date`='$modify_date' where student_id='$student' and session='".$_SESSION['session']."'");
			// if($que1 && $que2 && $que3 ){

			//    $responce['status']="success";
			//    $responce['msg']="Previous Fees Entered Sucessfully";
			// }else{
			// 	$responce['status']="error";
			//    $responce['msg']="Something Went happend, Please try again";
			// }

			$responce['status']="success";
			$responce['msg']="Previous Fees Entered Sucessfully";

		}else{
			$responce['status']="error";
		    $responce['msg']="Something Went wrong, Please try again";

		}
	}
	echo json_encode($responce);

}
if(isset($_POST['Edit_Previous_Fees'])){
	// echo "<pre>";
	// print_r($_POST);   
	$id=mysqli_real_escape_string($con,$_POST['id']);
	$nprevfee=mysqli_real_escape_string($con,$_POST['nprevfee']);
	$nremark=mysqli_real_escape_string($con,$_POST['nremark']);

	// $newdue = $olddue - $oldprev_fee + $nprevfee;

	$q = "update previous_fees set previous_fees='$nprevfee', remarks='$nremark',modify_date=now() where prev_fee_id='$id' and `session` ='".$_SESSION['session']."'";

		if(mysqli_query($con,$q)){

			// $action = "Previous Fees for ".$stuname." is Updated"; 

			// $q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			// machine_name,browser,date) 

			// values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
			// ($con,"update students set due='$newdue' where student_id='$stuid'");

			// ($con,"update student_due_fees set due_amount='$newdue' where student_id='$stuid'");

			// ($con,"update student_wise_fees set due_amount='$newdue' where student_id='$stuid'");
			$responce['status']="success";
			$responce['msg']="Previous Fees Updated  Sucessfully";

		}else{
			$responce['status']="error";
		    $responce['msg']="Something Went wrong, Please try again";

		}
echo json_encode($responce);
	// echo "<script>window.location='dashboard.php?option=view_previous_fees'</script>";
}

if(isset($_POST['Edit_Assign_Fees_Students'])){
	// echo "<pre>";
	// print_r($_POST);
	$cl1=mysqli_real_escape_string($con,$_POST['cl1']);
	$se1=mysqli_real_escape_string($con,$_POST['se1']);
	$sid=mysqli_real_escape_string($con,$_POST['sid']);
	$classid=mysqli_real_escape_string($con,$_POST['classid']);
	$se1=mysqli_real_escape_string($con,$_POST['se1']);
	$headid=$_POST['headid'];
	$fmode=$_POST['fmode'];
	$headamt=$_POST['headamt'];
	$updatedfee=$_POST['updatedfee'];
	$reason=$_POST['reason'];

	
		// $qs = mysqli_query($con,"select * from students where student_id='$sid' and session='".$_SESSION['session']."'");
	$qs=mysqli_query($con,"select `student_name`,`register_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$sid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
		$rs = mysqli_fetch_array($qs);
		$sname = $rs['student_name'];
		
		$q = mysqli_query($con,"select * from student_wise_fees where student_id='$sid' and session='".$_SESSION['session']."'");
		$r = mysqli_fetch_array($q);	

		$olddue = $r['due_amount'];
		$olddisc = $r['discount_amount'];
		$oldextra = $r['extra_amount'];
		$current_due = $r['current_due'];
		
		$strhid = implode(',',$headid);
		$strmode = implode(',',$fmode);
		$strorgamt = implode(',',$headamt);
		$strhamt = implode(',',$updatedfee);
		$strreason = implode(',',$reason);
		
		$newarr = array_combine($headamt,$updatedfee);
		
			
			
		foreach($newarr as $k1=> $v1)
		{
			$disc = 0;
			$extra = 0;
			
			if($v1==$k1)
			{
				$disc = $disc;
				$extra = $extra;
			}
			else if($k1 > $v1)
			{
				$disc = $k1 - $v1;
			}
			else if($k1 < $v1)
			{
				$extra = $v1 - $k1;
			}	
			
			$tdisc = $tdisc + $disc;
			$textra = $textra + $extra;
		}	
		
		
		$due = $olddue + $olddisc - $oldextra - $tdisc + $textra;
		
		$current_due = $current_due + $olddisc - $oldextra - $tdisc + $textra;

		$modify_date=date('Y-m-d H:i:s');

		//currently comment
		
		//  $que1 = "update student_wise_fees set fee_header_id='$strhid', fee_mode='$strmode', 
		// fee_amount='$strhamt', due_amount='$due', discount_amount='$tdisc', extra_amount='$textra', reason='$strreason',modify_date='$modify_date',status='1' where student_id='$sid' and session='".$_SESSION['session']."'";

		// $que2 ="update students set due='$current_due' , modify_date='$modify_date' where student_id='$sid' and session='".$_SESSION['session']."'";
		
				
		if(mysqli_query($con,$que1) && mysqli_query($con,$que2))
		{
			// $action = $sname." Fees Updated "; 
			// $q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
			// machine_name,browser,date) 
			// values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
			  $responce['status']="success";
			   $responce['msg']="Assign fess Updated Sucessfully";
		}else{

				$responce['status']="error";
			   $responce['msg']="Something went wrong, Please try again";
			
		// $que2 = mysqli_query($con,"update students set due='$current_due' where student_id='$sid'");
		// echo "<script>window.location='dashboard.php?option=view_assign_fees_students&class=$cl1&section=$se1&search=search'</script>";
		}
		
echo json_encode($responce);
}
// ----------------------------------------Approve_Reconcile_Fees-----------------------------------------------

if(isset($_POST['Approve_Reconcile_Fees'])){
	// echo "<pre>";
	// print_r($_POST);
	$id=mysqli_real_escape_string($con,$_POST['id']);



$q2 = mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ");

$r2 = mysqli_fetch_array($q2);

$stuid = $r2['student_id'];



// $q3 = mysqli_query($con,"select * from students where student_id='$stuid' and `session`='".$_SESSION['session']."' ");
$q3=mysqli_query($con,"select `student_name`,`register_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");

$r3 = mysqli_fetch_array($q3);

$stuname = $r3['student_name'];

$q1 = "update student_due_fees set status='1', modify_date=now() where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ";



	if(mysqli_query($con,$q1)){

		
		$responce['status']="success";
			$responce['msg']="Approved Sucessfully";

	}else{
		$responce['status']="error";
			$responce['msg']="Something went wrong, Please try again";
	}
echo json_encode($responce);
}


if(isset($_POST['Decline_Reconcile_fees'])){
// echo "<pre>";
// 	print_r($_POST);
	$id=mysqli_real_escape_string($con,$_POST['id']);
	$reason=mysqli_real_escape_string($con,$_POST['reason']);

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



// $q3 = mysqli_query($con,"select * from students where student_id='$stuid' and `session`='".$_SESSION['session']."'");
$q3=mysqli_query($con,"select `student_name`,`father_name`,`parent_no`,`register_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");

$r3 = mysqli_fetch_array($q3);

$stuname = $r3['student_name'];

$fname=$r3['father_name'];

$mobile=$r3['parent_no'];

$modify_date=date('Y-m-d H:i:s');

 $q1 = "update student_due_fees set status='2',reason='$reason', modify_date='$modify_date' where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ";



	if(mysqli_query($con,$q1))

	{

		// $q2 = .....($con,"update student_wise_fees set due_amount='$newdue'  ,modify_date='$modify_date' where student_id='$stuid' and `session`='".$_SESSION['session']."' ");

		

		// $q3 = ...($con,"update students set due='$newdue',modify_date='$modify_date'   where student_id='$stuid' and `session`='".$_SESSION['session']."' ");



			$responce['status']="success";
			$responce['msg']="Declined Sucessfully";

		// $action = $stuname." Fees Declined"; 
		// $q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details, machine_name,browser,date) values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

		

		

		$sset=mysqli_query($con,"select * from setting");

		$rsset=mysqli_fetch_array($sset);

		$sclname=$rsset['company_name'];

	

		$s1=mysqli_query($con,"select * from sms_setting");

		$r1=mysqli_fetch_array($s1);

		$status=$r1['status'];

			

		$msg = "Dear Mr. ".$fname.",%0aThe Paid Fees of ".$recamt." through Cheque No".$payment_detail." on ".$date." for your son ".$stuname." is Declined due to Cheque Bounce. Please contact Administration for more details.%0aFrom,%0aAccount Department%0a".$sclname;

	}else{
		$responce['status']="error";
			$responce['msg']="Something went wrong, Please try again";
	}	
echo json_encode($responce);

// echo "<script>window.location='dashboard.php?option=reconcile_fees'</script>";
}

