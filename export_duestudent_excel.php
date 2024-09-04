<?php

include('connection.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];

$range = $_REQUEST['range'];

$r1 = $_REQUEST['r1'];

$r2 = $_REQUEST['r2'];

	


			if($class!="" and $section!="")

		{

		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.status,sr.roll_no

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where and sr.class_id='$class' and sr.section_id='$section' and sr.session='".$_SESSION['session']."' ";			


		}		

		else if($class!="" and $section==""){

		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.status,sr.roll_no

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where sr.class_id='$class'  and sr.session='".$_SESSION['session']."' ";					

	

		}	

		else if($class=="" and $section==""){
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date,sr.roll_no

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where 1   and sr.session='".$_SESSION['session']."' ";

	

		}


	if($range==1){
		$query.=" and a.due > 0 and a.due < '$r1' ";
	}elseif($range==2){
		$query.=" and a.due > '$r1' "; 
	}elseif($range==3){
		$query.=" and a.due between '$r1' and '$r2' "; 
	}
	$query.=" order by sr.roll_no asc ";
	$search_result = filterTable($query);
	



function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Student Name".","."Register No".","."Father Name".","."Parent Contact".","."Class".","."Section".","."Roll no.".",";



$q1 = mysqli_query($con,"select * from fee_header");

while($re1 = mysqli_fetch_array($q1))

{

$headid = $re1['fee_header_id'];

$headidarr[] = $headid;



$columnHeader.= $re1['fee_header_name'].",";

}



$columnHeader.= "Previous Fees Due".","."Total Fee".","."Total Discount".","."Total Paid".","."Total Due".","."Last Paid Date";





$data='';



$sr=1;

while($res=mysqli_fetch_array($search_result))

{

$stuid=$res['student_id'];

$stuname=$res['student_name'];

$regno=$res['register_no'];

$fname=$res['father_name'];

$parentno=$res['parent_no'];

$due=$res['due'];

																																		

$cid=$res['class_id'];

$que1=mysqli_query($con,"select * from class where class_id='$cid'");

$res1=mysqli_fetch_array($que1);



$sectid=$res['section_id'];

$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

$rsec=mysqli_fetch_array($qsec);

									

$qbill=mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and status='0' || status='1'");

$rowbill=mysqli_num_rows($qbill);



if($rowbill)

{	

	$tpaidamt1 = 0;

	$prev = 0;

	while($b=mysqli_fetch_array($qbill))	

	{	

	$recdamt=$b['received_amount'];

	$arr = explode(',',$recdamt);



	$prevamt=$b['previous_amount'];

	

	foreach($arr as $k)

	{

	 $tpaidamt1 = $tpaidamt1 + $k;

	}

	

	

	$prev = $prev + $prevamt;

	$tpaidamt = $tpaidamt1 + $prev;

	$issdt=$res['issue_date'];

	$chgdate = date('d-m-y h:i:s',strtotime($issdt));

	}

										

}

else

{

	$tpaidamt = 0;

	$chgdate="";

}
$roll_no=($res1['roll_no']) ? $res1['roll_no'] : '0' ;
											

 $data .= $stuname.",".$regno.",".$fname.",".$parentno.",".$res1['class_name'].",".$rsec['section_name'].",".$roll_no.",";

 

$qtf = mysqli_query($con,"select * from assign_fee_class where class_id='$cid'");

$rtf = mysqli_fetch_array($qtf);

$totalfee = $rtf['total_amount'];

$feestr1 = $rtf['fee_header_id'];

$feearr1 = explode(',',$feestr1);



$feeamt = $rtf['fee_header_amount'];

$feeamtarr = explode(',',$feeamt);



$qtd = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");

$rtd = mysqli_fetch_array($qtd);

$totaldiscount = $rtd['discount_amount'];



foreach($headidarr as $k)

{

										

$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and status='0' || status='1'");

$val = 0;

$prevamt = 0;

while($rfee2 = mysqli_fetch_array($qfee2))

{

	$fhid=$rfee2['fee_header_id'];

	$fhidarr = explode(',',$fhid);

	

	$recdamt=$rfee2['received_amount'];

	$recdarr = explode(',',$recdamt);



	if(in_array($k,$fhidarr))

	{

		$pos = array_search($k,$fhidarr);

		$val += $recdarr[$pos];	

		

		$apos = array_search($k,$feearr1);

		$famt = $feeamtarr[$apos];	

		

		$balfee = $famt - $val;

	}

	else

	{

		$balfee = 0;

	}

		

	$prevamt = $prevamt+$rfee2['previous_amount'];

}



	$data .= $balfee.",";



}



	$data .= $prevamt.",".$totalfee.",".$totaldiscount.",".$tpaidamt.",".$due.",".$chgdate."\n";

}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "DueStudentsReport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

