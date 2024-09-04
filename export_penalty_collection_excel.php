<?php

include('connection.php');

extract($_REQUEST);



	$class = $_REQUEST['class'];

    $section = $_REQUEST['section'];

    $student = $_REQUEST['student'];

		

	if($class=="All" and $section=="All" and $student=="All")

	{

    // search in all table columns

		$query = "SELECT * FROM `issue_bookto_students` WHERE `return_status`='0'";

		$search_result = filterTable($query);

    }

	else if($class!="All" and $section=="All" and $student=="All")

	{

		$query = "SELECT * FROM `issue_bookto_students` WHERE `class_id`='$class' and return_status='0'";

		$search_result = filterTable($query);

	}	

	else if($class!="All" and $section!="All" and $student=="All")

	{

		$query = "SELECT * FROM `issue_bookto_students` WHERE `class_id`='$class' and `section_id`='$section' and return_status='0'";

		$search_result = filterTable($query);

	}	

	else if($class!="All" and $section!="All" and $student!="All")

	{

		$query = "SELECT * FROM `issue_bookto_students` WHERE `class_id`='$class' and `section_id`='$section' and `student_id`='$student' and return_status='0'";

		$search_result = filterTable($query);

	}

	



function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Name".","."Class".","."Section".","."Total Penalty".","."Total Paid".","."Total Due";



$data='';



while($res=mysqli_fetch_array($search_result))

{

$id=$res['issue_id'];

$stuid=$res['student_id'];

// $q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
$sql1="select `student_id`,student_name,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$stuid' ";//and sr.session='".$_SESSION['session']."'
$q1=mysqli_query($con,$sql1);

$r1 = mysqli_fetch_array($q1);

$stuname=$r1['student_name'];



$clsid=$res['class_id'];

$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

$r2 = mysqli_fetch_array($q2);

$classname = $r2['class_name'];



$secid=$res['section_id'];

$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

$r3 = mysqli_fetch_array($q3);

$secname = $r3['section_name'];									



$retdt = $res['return_date'];

$curdate = date("Y-m-d");

$date1=date_create($curdate);

$date2=date_create($retdt);

$diff=date_diff($date2,$date1);

$tdays = $diff->format("%R%a days");

										

$rettypeid=$res['return_type_id'];

$q3=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$rettypeid'");

$r3=mysqli_fetch_array($q3);

$amt=$r3['book_fine_per_day'];



if($tdays > 0)

{

	$tpenalty = $tdays * $amt;

}

else

{

	$tpenalty = 0;

}



$q4 = mysqli_query($con,"select * from library_payment where issue_id='$id'");

$tpaid = 0;

while($r4 = mysqli_fetch_array($q4))

{

	$tpaid += $r4['paid_amount']; 

}

$tdue = $tpenalty - $tpaid;

						

$data .= $stuname.",".$classname.",".$secname.",".$tpenalty.",".$tpaid.",".$tdue."\n";

}

	

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');





$filename =  "Penaltycollection_report_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

