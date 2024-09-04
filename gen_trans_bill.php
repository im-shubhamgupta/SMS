<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;

	$query1=mysqli_query($con,"insert into student_transport_due_fees (student_id,class_id,section_id,trans_amount,previous_trans_amount,due_amount,payment_type_id,payment_detail,bank_name,remarks,
	issued_by,issue_date,date) 
	values ('$stuid','$clsid','$secid','$ntransfee','$nprevfee','$amtdue','$paidby','$paymentdetail','$bankname',
	'$remarks','$issby','$issdate','$issdate1')");
	
	$q1="insert into student_notifications (category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date) values(3,'$stuid','$clsid','$secid',0,'$mobile','$msgn','$issby','$issdate','$issdate1')";	
	
	if(mysqli_query($con,$q1))
	{
		$action = $stuname." Transport Fees of Rs ".$totalpaid." has been received."; 
		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
		machine_name,browser,date) 
		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
	
	mysqli_query($con,"update student_route set due_amount='$amtdue' where student_id='$stuid'");
	}
	
	echo "<script>window.location='dashboard.php?option=view_transport_fee_detail'</script>";

?>