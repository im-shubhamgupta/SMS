<?php
include('connection.php');
extract($_REQUEST);

$query=mysqli_query($con,"select * from assign_clsteacher");
	
$columnHeader ='';
$columnHeader = "Class".","."Section".","."Teacher";

$data='';

while($res=mysqli_fetch_array($query))
{
$clid=$res['class_id'];
$quec=mysqli_query($con,"select * from class where class_id='$clid'");
$resc=mysqli_fetch_array($quec);
$clsname=$resc['class_name']; 

$seid=$res['section_id'];
$qse=mysqli_query($con,"select * from section where section_id='$seid'");
$rsec=mysqli_fetch_array($qse);
$secname=$rsec['section_name'];

$stid=$res['st_id'];
$qst=mysqli_query($con,"select * from staff where st_id='$stid'");
$rst=mysqli_fetch_array($qst);
$staffname=$rst['staff_name'];	
						
$data .= $clsname.",".$secname.",".$staffname."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Assignclassteacher_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
