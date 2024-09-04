<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
	$q1 = mysqli_query($con,"select * from previous_fees where prev_fee_id='$id'");
	$r1 = mysqli_fetch_array($q1);
	$amt = $r1['previous_fees'];
	$stuid = $r1['student_id'];
		
	$q2 = mysqli_query($con,"select * from students where student_id='$stuid'");
	$r2 = mysqli_fetch_array($q2);
	$due = $r2['due'];
	$newdue = $due - $amt;	
	$stuname = $r2['student_name'];
		
	$que = "delete from previous_fees where prev_fee_id='$id'";
	if(mysqli_query($con,$que))
	{
		$action = "Previous Fees for ".$stuname." has been deleted."; 
		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
		machine_name,browser,date) 
		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
		
		mysqli_query($con,"update students set due='$newdue' where student_id='$stuid'");
		mysqli_query($con,"update student_due_fees set due_amount='$newdue' where student_id='$stuid'");
		mysqli_query($con,"update student_wise_fees set due_amount='$newdue' where student_id='$stuid'");
	}
	
	echo "<script>window.location='dashboard.php?option=view_previous_fees'</script>";
}




?>