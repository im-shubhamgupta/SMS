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

	$query="select a.student_id, a.trans_amount, a.previous_trans_amount, a.due_amount, 

			a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_trans_fee_id , a.status, b.student_id ,sr.roll_no

			from student_transport_due_fees as a join  students as b on a.student_id = b.student_id join student_records as sr  on a.student_id = sr.stu_id  

			where 1 and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.section_id='$section'";	

	

	// $search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select a.student_id, a.trans_amount, a.previous_trans_amount, a.due_amount, 

			a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_trans_fee_id , a.status, b.student_id ,sr.roll_no

			from student_transport_due_fees as a join  students as b on a.student_id = b.student_id join student_records as sr  on a.student_id = sr.stu_id  

			where 1 and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class'";					

	// $search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select a.student_id, a.trans_amount, a.previous_trans_amount, a.due_amount, 

			a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_trans_fee_id , a.status, b.student_id ,sr.roll_no

			from student_transport_due_fees as a join  students as b on a.student_id = b.student_id join student_records as sr  on a.student_id = sr.stu_id  

			where 1  and (a.status!='2' and a.status!='4') and b.stu_status='0'";					

	// $search_result = filterTable($query);

    }
if(!empty($frontdt) && !empty($todt)){
    	$query.=" and date between '$fromdt' AND '$todt'";

    }
    $query.=" and sr.session='".$_SESSION['session']."' ";
    $query.=" order by sr.roll_no asc ";
	$search_result = filterTable($query);


function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Student Name".","."Register No".","."Father Name".","."Parent Contact".","."Class".","."Section".","."Roll no.".","."Receipt No".","."Transport Fees".","."Previous Transport Fee".","."Total Fee".","."Total Discount".","."Total Paid".","."Total Due".","."Paid By".","."Challan No".","."Issued By".","."Issued Date";



$data='';



$sr=1;

$gtotal = 0;

$totaldiscount = 0;
if(mysqli_num_rows($search_result)>0){
while($res1=mysqli_fetch_array($search_result))

{									

	

$stuid=$res1['student_id'];

									

// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0'  and session='".$_SESSION['session']."'");
$que2=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'");
if(mysqli_num_rows($que2)>0){
while($res2=mysqli_fetch_array($que2))

{



$cid=$res2['class_id'];

$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

$rcls=mysqli_fetch_array($qcls);



$sectid=$res2['section_id'];

$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

$rsec=mysqli_fetch_array($qsec);



$transfeepaid=$res1['trans_amount'];

$prevfeepaid=$res1['previous_trans_amount'];



$ptid=$res1['payment_type_id'];

$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");

$rptid=mysqli_fetch_array($qptid);

$paidby=$rptid['payment_type_name'];



$pdetail=$res1['payment_detail'];

$issby=$res1['issued_by'];

$issdt=$res1['issue_date'];	

$chgedate = date('d-m-Y h:i:s',strtotime($issdt));	



$qt = mysqli_query($con,"select * from student_route where student_id ='$stuid' and session='".$_SESSION['session']."' ");

$rt= mysqli_fetch_array($qt);

$transid = $rt['trans_id'];

$totaldiscount = $rt['discount'];



$qtd = mysqli_query($con,"select * from transports where trans_id ='$transid'");

$rtd = mysqli_fetch_array($qtd);

$transamt = $rtd['price'];



$qp = mysqli_query($con,"select * from previous_transport_fees where student_id ='$stuid' and session='".$_SESSION['session']."' ");

$rp = mysqli_fetch_array($qp);

$prevamt = $rp['previous_transport_fees'];



$totalfee = $transamt + $prevamt;



$tfeepaid = $transfeepaid + $prevfeepaid;
$roll_no=($res1['roll_no']) ? $res1['roll_no'] : '0'; 


 $data .= $res2['student_name'].",".$res2['register_no'].",".$res2['father_name'].",".$res2['parent_no'].",".$rcls['class_name'].",".$rsec['section_name'].",".$roll_no.",".$res1['student_trans_fee_id'].",".$transfeepaid.",".$prevfeepaid.",".$totalfee.",".$totaldiscount.",".$tfeepaid.",".$res1['due_amount'].",".$paidby.",".$pdetail.",".$issby.",".$chgedate."\n";



$sr++;									

}}}

}

	



$filename =  "PaidTransportReport.csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

