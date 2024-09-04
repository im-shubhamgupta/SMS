<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;

	$query1=mysqli_query($con,"insert into student_due_fees (student_id,class_id,fee_header_id,
	received_amount,previous_amount,transport_amount,due_amount,payment_type_id,payment_detail,bank_name,remarks,
	issued_by,issue_date,date) 
	values ('$stuid','$clsid','$feeidstr','$feestr','$nprevfee','$ntransfee','$amtdue','$paidby','$paymentdetail','$bankname',
	'$remarks','$issby','$issdate','$issdate1')");
	
        
    if( mysqli_error($con)){
        echo("Error description: " . mysqli_error($con));
    }
	
	if($query1){
        
        $q1 = $con->query("insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)
        values(3,'$stuid','$clsid','$secid',0,'$mobile','$msgn','$issby','$issdate','$issdate1')");	
        
        
		$action = $stuname." School Fees of Rs ".$totalpaid." has been received."; 
		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
		machine_name,browser,date) 
		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
	
        mysqli_query($con,"update students set due='$amtdue' where student_id='$stuid'");
        mysqli_query($con,"update student_wise_fees set due_amount='$amtdue' where student_id='$stuid'");
	}
	
	echo "<script>window.location='dashboard.php?option=view_student_fees_detail'</script>";

?>