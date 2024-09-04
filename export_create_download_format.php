<?php

include('connection.php');

extract($_REQUEST);



$qu = mysqli_query($con,"select * from subject where subject_id='$subject'");

$ru = mysqli_fetch_array($qu);

$subname = $ru['subject_name'];



$columnHeader ='';

$columnHeader = "Class".","."Section".","."Register No".","."Student Name".","."$subname";



 $data='';



	// $que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' and stu_status='0' and session='".$_SESSION['session']."' ");	
	$que2 = mysqli_query($con,"select `student_id`,`student_name`,`register_no`,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");
										
    if(mysqli_num_rows($que2)>0){
	while($res2=mysqli_fetch_array($que2))

	{									

	$stuname = $res2['student_name'];

	$regno = $res2['register_no'];

	

	$q1 = mysqli_query($con,"select class_name from class where class_id='$class'");

	$r1 = mysqli_fetch_array($q1);

	$classname = $r1['class_name'];

	

	$q2 = mysqli_query($con,"select section_name from section where section_id='$section'");

	$r2 = mysqli_fetch_array($q2);

	$secname = $r2['section_name'];

	

	$data.= $classname.",".$secname.",".$regno.",".$stuname."\n";

	}							

	}	



$fname = $classname.'_'.$secname.'_'.$test.'_'.$subname;



$filename =  $fname.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

