<?php
include('connection.php');
extract($_REQUEST);
	
	$q1=mysqli_query($con,"select * from assign_subject where st_id='$stid'");	
	
$columnHeader ='';
$columnHeader = "Class".","."Section".","."Subject";


$data='';

while($res=mysqli_fetch_array($q1))
{
$id=$res['assign_sub_id'];

$clid=$res['class_id'];
$quec=mysqli_query($con,"select * from class where class_id='$clid'");
$resc=mysqli_fetch_array($quec);
$clsname=$resc['class_name']; 

$seid=$res['section_id'];
$qse=mysqli_query($con,"select * from section where section_id='$seid'");
$rsec=mysqli_fetch_array($qse);
$secname=$rsec['section_name'];
									
$subid=$res['subject_id'];
$qsub=mysqli_query($con,"select * from subject where subject_id='$subid'");
$rsub=mysqli_fetch_array($qsub);
$subname=$rsub['subject_name'];

 $data .= $clsname.",".$secname.",".$subname."\n";
}
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');

$filename =  "Allocated_Subject_Report_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo ucwords($columnHeader)."\n".$data."\n"; 
exit; 

?>
