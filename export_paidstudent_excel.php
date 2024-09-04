<?php

include('connection.php');

extract($_REQUEST);

$fromdt = $_REQUEST['fromdt'];

$chg_fdate = date("d-m-Y", strtotime($fromdt));

	

$todt = $_REQUEST['todt'];

$chg_tdate = date("d-m-Y", strtotime($todt));



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];





	if($class!="" and $section!="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1  and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.section_id='$section'  and sr.session='".$_SESSION['session']."' ";	

	

	// $search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1 and

			 (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class'  and sr.session='".$_SESSION['session']."' ";					

	// $search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1 and (a.status!='2' and a.status!='4') and b.stu_status='0'  and sr.session='".$_SESSION['session']."' ";					

	// $search_result = filterTable($query);

    }

	if(!empty($fromdt) && !empty($todt)){

 		$query.=" and date between '$fromdt' AND '$todt' ";
 	}
 	$query.=" order by sr.roll_no asc ";
	$search_result = filterTable($query);	

function filterTable($query){

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Student Name".","."Register No".","."Father Name".","."Parent Contact".","."Class".","."Section".","."Roll no.".","."Receipt No".",";



$q1 = mysqli_query($con,"select * from fee_header");

while($r1 = mysqli_fetch_array($q1))

{

$headid = $r1['fee_header_id'];

$headidarr[] = $headid;



$columnHeader.= $r1['fee_header_name'].",";



}



$columnHeader.="Previous Fees Due".","."Total Fee".","."Total Discount".","."Total Paid".","."Total Due".","."Paid By".","."Challan No".","."Issued By".","."Issued Date";



$data='';



$sr=1;

$gtotal = 0;

$totaldiscount = 0;

while($res1=mysqli_fetch_array($search_result))

{									

	

$stuid=$res1['student_id'];



// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0' and session='".$_SESSION['session']."'");
$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and student_id='$stuid' and sr.session='".$_SESSION['session']."'";
$que2=mysqli_query($con,$sql1);
if(mysqli_num_rows($que2)>0){

while($res2=mysqli_fetch_array($que2))

{



$cid=$res2['class_id'];

$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

$rcls=mysqli_fetch_array($qcls);



$sectid=$res2['section_id'];

$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

$rsec=mysqli_fetch_array($qsec);



$sfh=$res1['fee_header_id'];

$sfharr = explode(',',$sfh);	



$sfee=$res1['received_amount'];

$sfeearr = explode(',',$sfee);	



$prevfeepaid=$res1['previous_amount'];

$ptid=$res1['payment_type_id'];

$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");

$rptid=mysqli_fetch_array($qptid);

$paidby=$rptid['payment_type_name'];



$pdetail=$res1['payment_detail'];

$issby=$res1['issued_by'];

$issdt=$res1['issue_date'];	

$chgedate = date('d-m-Y h:i:s',strtotime($issdt));



$qtf = mysqli_query($con,"select * from assign_fee_class where class_id='$cid' and session='".$_SESSION['session']."'");

$rtf = mysqli_fetch_array($qtf);

$totalfee = $rtf['total_amount'];



$qtd = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid' and session='".$_SESSION['session']."'");

$rtd = mysqli_fetch_array($qtd);

$totaldiscount = $rtd['discount_amount'];
$roll_no=($res1['roll_no']) ? $res1['roll_no'] : '0' ;


 $data .= $res2['student_name'].",".$res2['register_no'].",".$res2['father_name'].",".$res2['parent_no'].",".$rcls['class_name'].",".$rsec['section_name'].",".$roll_no.",".$res1['student_due_fee_id'].",";

 

	$tfee1 = 0;

	$tfee2 = 0;

	

	foreach($headidarr as $v)

	{

		$val = 0;

		if(in_array($v,$sfharr))

		{

			$pos = array_search($v,$sfharr);

			$val = $sfeearr[$pos];

			$tfee1 = $tfee1 + $val;

			if($val=="")

			{

				$val = 0;

			}

		}

		$data .=  $val.","; 

	}

	$tfee2 = $tfee1 + $prevfeepaid;



 $data .=$prevfeepaid.",".$totalfee.",".$totaldiscount.",".$tfee2.",".$res2['due'].",".$paidby.",".$pdetail.",".$issby.",".$chgedate."\n";



$sr++;									

}}

}

	



$filename =  "PaidStudentReport.csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

