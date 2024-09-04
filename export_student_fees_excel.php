<?php
include('connection.php');
extract($_REQUEST);

	$class = $_REQUEST['class'];
    $section = $_REQUEST['section'];
   	
	$query = mysqli_query($con,"SELECT * FROM `student_wise_fees` WHERE `class_id`='$class' and section_id='$section'");

$columnHeader ='';
$columnHeader = "Register No".","."Name".",";

$qf = mysqli_query($con,"select * from assign_fee_class where class_id='$class'");
$rf = mysqli_fetch_array($qf);
$fid = $rf['fee_header_id'];
$arr = explode(',',$fid);
foreach($arr as $k)
{

$qf1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
$rf1 = mysqli_fetch_array($qf1);
$header = $rf1['fee_header_name'];

$columnHeader.="$header".",";
}

$data='';

while($res=mysqli_fetch_array($query))
{
$stuid=$res['student_id'];
$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
$r1 = mysqli_fetch_array($q1);
$stuname=$r1['student_name'];
$regno=$r1['register_no'];

$data .= $regno.",".$stuname.",";

$fhid = $res['fee_header_id'];
$fheadarr = explode(',',$fhid);
$fhamt = $res['fee_amount'];
$famtarr = explode(',',$fhamt);
foreach($arr as $k)
{
if(in_array($k,$fheadarr))
	{
$pos = array_search($k,$fheadarr);
$val = $famtarr[$pos];

$data .= $val.",";

	}
}	

$data .= "\n";	

}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Student_fees_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
