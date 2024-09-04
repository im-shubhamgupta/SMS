<?php
include('connection.php');
extract($_REQUEST);

$columnHeader ='';
$columnHeader = "Name".","."Staff Id".","."Gender".","."Mobile No".","."Alt. Mobile No".","."Address".","."Qualification".","."Teaching Type".","."Teaching Type Other".","."Skills".","."Date of Joining".","."Designation".","."Message Type".","."Aadhar No".","."Caste";

$data='';

$query=mysqli_query($con,"select * from staff where status='1'");
while($res=mysqli_fetch_array($query))
{
$id=$res['st_id'];
$name=$res['staff_name'];
$staffid=$res['staff_id'];
$gender=$res['gender'];
$mobno=$res['mobno'];
$altmobno=$res['alt_mobno'];
$add=$res['address'];
$quali=$res['qualification'];
$teachtype=$res['teaching_type'];
$teachtypeother=$res['teaching_type_other'];
$skills=$res['skills'];
$date=$res['joining_date'];
$joindate=date("d-M-Y", strtotime($date));
$designation=$res['designation'];
$msgid=$res['msg_type_id'];
$qmsg=mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");
$rmsg=mysqli_fetch_array($qmsg);
$msgname = $rmsg['msg_name'];
$aadhar=$res['aadharno'];
$caste=$res['caste'];
			
$data .= $name.",".$staffid.",".$gender.",".$mobno.",".$altmobno.",".$add.",".$quali.",".$teachtype.",".$teachtypeother.",".$skills.",".$joindate.
",".$designation.",".$msgname.",".$aadhar.",".$caste."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Staffdetail_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
