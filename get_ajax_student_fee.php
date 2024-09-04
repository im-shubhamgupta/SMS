<?php 
extract($_REQUEST);

include('connection.php');



$q1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stu_id' && status='0' && session='".$_SESSION['session']."'");

$row1 = mysqli_num_rows($q1);



$q2 = mysqli_query($con,"select * from student_due_fees where student_id='$stu_id' and session='".$_SESSION['session']."'");

$row2 = mysqli_num_rows($q2);



// $q3 = mysqli_query($con,"select * from students where student_id='$stu_id'");
 $sqll="select `student_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' && student_id='$stu_id' and sr.session='".$_SESSION['session']."'  ";
$q3=mysqli_query($con,$sqll);


$row3 = mysqli_fetch_array($q3);

$clsid = $row3['class_id'];

$secid = $row3['section_id'];

$value = array( 

    "clsid"=>$clsid, 

    "secid"=>$secid); 

	

if($row1 || $row2)

{

	echo json_encode($value);

}



?>

