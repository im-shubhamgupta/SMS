<?php
include('connection.php');
extract($_REQUEST);

$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$subject = $_REQUEST['subject'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];

	$query="select distinct(a.student_id),a.register_no,b.student_name from subjectwise_attendance a inner join students b on a.student_id=b.student_id where a.class_id='$class' && a.section_id='$section' && a.subject_id='$subject' && 
	month(date)='$month' && year(date)='$year'";
	$search_result = filterTable($query);
	
	
function filterTable($query)
{
    include('connection.php');
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
}

$columnHeader ='';
$columnHeader.= "Register No".","."Student Name".",";

if($month)
{
$start_date = "01-".$month."-".$year;
$start_time = strtotime($start_date);

$end_time = strtotime("+1 month", $start_time);

for($i=$start_time; $i<$end_time; $i+=86400)
{
   $list[] = date('d-m-Y', $i);
}


//print_r($list);
foreach($list as $k)
{

$columnHeader.="$k".",";

}

}
$columnHeader.="Percentage"."\n";
$data='';

			while($res=mysqli_fetch_array($search_result))
					{
						$student=$res['student_id'];
						$regno=$res['register_no'];
						$stuname=$res['student_name'];
						
			$data.= $regno.",".$stuname.",";	
					
					$rowcount=0;
					$trow=0;
					foreach($list as $k)
					{
					$trow=$trow+1;
					$ndate=date("Y-m-d",strtotime($k));
					$query4=mysqli_query($con,"select * from subjectwise_attendance where student_id='$student' && subject_id='$subject' && date='$ndate'");
					
					if(mysqli_num_rows($query4))
					{
					$rowcount=$rowcount+1;
					}
					$trow=cal_days_in_month(CAL_GREGORIAN,$month,$year);
					
					$res4=mysqli_fetch_array($query4);									
					$attend=$res4['type_of_attend'];
					$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");
					$ratt=mysqli_fetch_array($queatt);
					$attname=$ratt['short_name'];
																									
			$data.= $attname.",";
			
					}
					$percent = round($rowcount/$trow*100,2);
					
			$data.= $percent."%"."\n";	
			
					}
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');

$filename =  "Subject_wise_attendance_report_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo ucwords($columnHeader)."\n".$data."\n"; 
exit; 

?>
