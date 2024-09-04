<?php
extract($_REQUEST);
$email=$_SESSION['user_logged_in'];
$user=$res['username'];

$stuid = $_REQUEST['stuid'];
$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
$r1=mysqli_fetch_array($q1);
$newreg = $r1['register_no'];
$class = $r1['class_id'];
$section = $r1['section_id'];
$mobile = $r1['parent_no'];
$newattendance = 3;
$newreason = $reason;

$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];

	$que = mysqli_query($con,"update student_leave set status='1' where stu_leave_id='$id'");	
	
	if($que)
	{
		$q3 = mysqli_query($con,"select * from student_leave where stu_leave_id='$id'");
		$r3 = mysqli_fetch_array($q3);
		$subdate = $r3['submission_date'];
		$submitdate = date("d-m-Y",strtotime($subdate));
		$fdate = $r3['from_date'];
		$nfdate = date("d-m-Y",strtotime($fdate));
		$tdate = $r3['to_date'];
		$ntdate = date("d-m-Y",strtotime($tdate));
		$totaldays = $r3['total_days'];
		$lvtypeid = $r3['leave_id'];
		$ql = mysqli_query($con,"select * from leave_type where leave_id='$lvtypeid'");
		$rql = mysqli_fetch_array($ql);
		$lvname = $rql['leave_name'];
		$reason = $r3['reason'];
		$note = $r3['note'];
				
		$msg = "Hi,<br>Please find the Leave Request Response.<br>Submitted Date: ".$submitdate.
		"<br>From Date: ".$nfdate."<br>To Date: ".$ntdate."<br>No of Days: ".$totaldays."<br>Leave Type : "
		.$lvname."<br>Reason: ".$reason."<br>Note:".$note."<br>Status: Approved";
	
		$q4=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)
		values(3,'$stuid','$class','$section',0,'$mobile','$msg','$user',now(),now())");
		
		//Leave Attendance
		for($i=$fromdate; $i<=$todate; $i++)
		{
		$q2=mysqli_query($con,"insert into student_daily_attendance  (register_no,student_id,class_id,section_id,type_of_attend,reason,date) 
		values('$newreg','$stuid','$class','$section','$newattendance','$newreason','$i')");
		}
		
		
		echo "<script>window.location='dashboard.php?option=approve_leaves'</script>";
		
	}
	
?>

