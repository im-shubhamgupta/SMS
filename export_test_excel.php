<?php
include('connection.php');
extract($_REQUEST);

$class = $_REQUEST['class'];
$section = $_REQUEST['section'];
$test = $_REQUEST['test'];

	
$columnHeader ='';
$columnHeader.= "Subject Name".","."Min Marks".","."Max Marks".","."Start Date".","."Start Time".","."End Time".","."Room No";


$data='';

$query=mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test'");

while($res=mysqli_fetch_array($query))
{									
$tid = $res['test_id'];
$subid = $res['subject_id'];
$qsub = mysqli_query($con,"select * from subject where subject_id='$subid'");
$rsub = mysqli_fetch_array($qsub);
$subname = $rsub['subject_name'];	

$stdt = $res['test_date'];
$chgstdt = date("d-M-Y",strtotime($stdt));

$sttime = $res['starttime'];
$chgsttime = date("h:i A",strtotime($sttime));

$endtime = $res['endtime'];
$chgendtime = date("h:i A",strtotime($endtime));

$data.= $subname.",".$res['min_marks'].",".$res['max_marks'].",".$chgstdt.",".$chgsttime.",".$chgendtime.
",".$res['room_no']."\n";	
			
}


$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');

$filename =  "Test_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo ucwords($columnHeader)."\n".$data."\n"; 
exit; 

?>
