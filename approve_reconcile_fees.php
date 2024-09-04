<?php

extract($_REQUEST);


$q2 = mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ");

$r2 = mysqli_fetch_array($q2);

$stuid = $r2['student_id'];



$q3 = mysqli_query($con,"select * from students where student_id='$stuid' and `session`='".$_SESSION['session']."' ");

$r3 = mysqli_fetch_array($q3);

$stuname = $r3['student_name'];

$q1 = "update student_due_fees set status='1', modify_date=now() where student_due_fee_id='$id' and `session`='".$_SESSION['session']."' ";



	if(mysqli_query($con,$q1))

	{

		$action = $stuname." Fees Approved"; 

		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

		machine_name,browser,date) 

		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

	}



echo "<script>window.location='dashboard.php?option=reconcile_fees'</script>";



?>