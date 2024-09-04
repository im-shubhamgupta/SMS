<?php
include('connection.php');
extract($_REQUEST);

$columnHeader ='';
$columnHeader = "Student Name".","."Register No".","."Class".","."Section".","."Tution Fees Discount".","."Tution Fees Discount Reason".","."Transport Fees Discount".","."Transport Fees Discount Reason".","."Total Discount"."\n";

$data='';
$query=mysqli_query($con,"select * from students where stu_status='0' and tutionfee_disc!='' or transfee_disc!=''");
	
while($res=mysqli_fetch_array($query))
{
$id=$res['student_id'];
$clid=$res['class_id'];
$quec=mysqli_query($con,"select * from class where class_id='$clid'");
$resc=mysqli_fetch_array($quec);

$seid=$res['section_id'];
$qse=mysqli_query($con,"select * from section where section_id='$seid'");
$rsec=mysqli_fetch_array($qse);

$tution_disc=$res['tutionfee_disc'];
$trans_disc=$res['transfee_disc'];
$total_amount=$tution_disc+$trans_disc;						

 $data .= $res['student_name'].",".$res['register_no'].",".$resc['class_name'].",".$rsec['section_name'].",".$res['tutionfee_disc'].",".$res['tutionfeedisc_reason'].",".$res['transfee_disc'].",".$res['transfeedisc_reason'].","."$total_amount"."\n";
}
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');

$filename =  "discounted_students_details".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
echo ucwords($columnHeader)."\n".$data."\n"; 
exit; 
?>
