<?php

include('connection.php');

extract($_REQUEST);



$columnHeader ='';

$columnHeader = "Student Name".","."Roll no.".",";



 $que = mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test' and session='".$_SESSION['session']."' ");

 while($rque = mysqli_fetch_array($que))

 {

	 $subid = $rque['subject_id'];

	 $subidarr[] = $rque['subject_id'];

	 $sque = mysqli_query($con,"select * from subject where subject_id='$subid'");

	 $rque = mysqli_fetch_array($sque);

	 $subjectname = $rque['subject_name'];

 

 $columnHeader.="$subjectname".",";

 }

 

 $columnHeader.="Total".","."Percent".","."Grade";

 $data='';



	// $que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."'");	
	$que2 = mysqli_query($con,"select `student_id`,`register_no`,`student_name`,`father_name`,`parent_no`,`msg_type_id`,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");						
	if(mysqli_num_rows($que2)>0){
	while($res2=mysqli_fetch_array($que2))

	{									

	$stuid = $res2['student_id'];

	$stuname = $res2['student_name'];
	$roll_no = ($res2['roll_no']) ? $res2['roll_no'] : '0' ;

 $data.= $stuname.",";
 $data.= $roll_no.",";

 

	$total = 0;

	$totalmarks = 0;

	$percent = 1;

	foreach($subidarr as $v)

	{

	$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$v' && student_id='$stuid' && session='".$_SESSION['session']."'");

	$res3 = mysqli_fetch_array($que3);

	$stumarks = $res3['marks'];

	if($stumarks)

	{

		$marks = $stumarks;

	}

	else

	{

		$marks = 0;

	}

	$tmarks = $res3['max_mark'];

 

 $data.= $marks.",";

	

	$total = $total+$marks;

	$totalmarks = $totalmarks+$tmarks;
	if($totalmarks==0 || $totalmarks==""){
	$totalmarks=1;
	}

	$percent = round($total/$totalmarks*100,2);

	

	$que4 = mysqli_query($con,"select * from grade where condition1 <='$percent' && condition2 >='$percent'");

	

	$row = mysqli_num_rows($que4);

	if($row)

	{

		$res4 = mysqli_fetch_array($que4);

		$gr = $res4['grade_name'];

	}

	

	}

	

 $data.= $total." / ".$totalmarks.",".$percent." %".",".$gr."\n";

								
    }
	}//while	



$filename =  "View_Report.csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

