<?php
include('connection.php');
extract($_REQUEST);
	
	$cond = '';
	
	if($_REQUEST['faculty']!='') 
	{
		$cond.="&& staff_id='$faculty'";
	}
	if($_REQUEST['class']!='') 
	{
		$cond.="&& class_id='$class'";
	}
	if($_REQUEST['section']!='') 
	{
		$cond.="&& section_id='$section'";
	}
	if($_REQUEST['subject']!='') 
	{
		$cond.="&& subject_id='$subject'";
	}
	if($_REQUEST['status']!='') 
	{
		$cond.="&& status='$status'";
	}			
	
	$fromdt = $_REQUEST['fromdt']; 
	$todt = $_REQUEST['todt']; 
	
	$query = mysqli_query($con,"SELECT * FROM `assign_syllabus_staff` WHERE from_dt>='$fromdt' && to_dt<='$todt' $cond");
	
	
$columnHeader ='';
$columnHeader = "Staff".","."Class".","."Section".","."Subject".","."Chapter".","."From".","."To".","."Days".","."Description".","."Status".","."Completion Date".","."Updated Date".","."Updated By".","."Comments";

$data='';

while($res=mysqli_fetch_array($query))
{									

$staffid=$res['staff_id'];
$qst=mysqli_query($con,"select * from staff where st_id='$staffid'");
$rst=mysqli_fetch_array($qst);
$stname=$rst['staff_name'];

$clid=$res['class_id'];
$qcls=mysqli_query($con,"select * from class where class_id='$clid'");
$rcls=mysqli_fetch_array($qcls);
$clsname=$rcls['class_name'];

$secid=$res['section_id'];
$qsec=mysqli_query($con,"select * from section where section_id='$secid'");
$rsec=mysqli_fetch_array($qsec);
$secname=$rsec['section_name'];

$subid=$res['subject_id'];
$qsub=mysqli_query($con,"select * from subject where subject_id='$subid'");
$rsub=mysqli_fetch_array($qsub);
$subname=$rsub['subject_name'];

$frmdt = $res['from_dt'];
$nfrmdt = date("d-m-Y",strtotime($frmdt));

$todt = $res['to_dt'];
$ntodt = date("d-m-Y",strtotime($todt));

$sta = $res['status'];
if($sta==1)
{
	$status = "Done";
}
else if($sta==2)
{
	$status = "In Progress";
}
else if($sta==3)
{
	$status = "Not Started";
}

$comp_dt = $res['completion_date'];
$ncomp_dt = date("d-m-Y",strtotime($comp_dt));

$updt_dt = $res['updated_dt'];
$nupdt_dt = date("d-m-Y",strtotime($updt_dt));

$data .= $stname.",".$clsname.",".$secname.",".$subname.",".$res['chapter'].",".$nfrmdt.",".$ntodt.",".$res['days'].",".$res['description'].",".$status.",".$ncomp_dt.",".$nupdt_dt.",".$res['updated_by'].",".$res['comments']."\n";

}
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');

$filename =  "Syllabus_Allocated_Report_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo ucwords($columnHeader)."\n".$data."\n"; 
exit; 

?>
