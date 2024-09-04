<?php 
include('connection.php');
extract($_REQUEST);
//echo $id;
if(isset($id))
{
$q1 = mysqli_query($con,"select * from student_route where sturoute_id='$id'");
$r1 = mysqli_fetch_array($q1);
$stuid =$r1['student_id'];
	
$query_trans=mysqli_query($con,"select * from student_due_fees where student_id='$stuid'");

if(mysqli_num_rows($query_trans))
{
	echo "true";
}
}


if(isset($del_id))
{
	$q2 = mysqli_query($con,"select * from student_route where sturoute_id='$del_id'");
	$r2 = mysqli_fetch_array($q2);
	$price = $r2['price'];
	$stuid = $r2['student_id'];
	
	$q3 = mysqli_query($con,"select * from students where student_id='$stuid'");
	$r3 = mysqli_fetch_array($q3);
	$olddue1 = $r3['due'];
	$newdue1 = $olddue1 - $price;
	
	$q4 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
	$r4 = mysqli_fetch_array($q4);
	$olddue2 = $r4['due_amount'];
	$newdue2 = $olddue2 - $price;
	
	if(mysqli_query($con,"delete from student_route where sturoute_id='$del_id'"))	
	{
		mysqli_query($con,"update students set due='$newdue1' where student_id='$stuid'");
		
		mysqli_query($con,"update student_wise_fees set due_amount='$newdue2' where student_id='$stuid'");
		echo "1";
	}
	
}

?>