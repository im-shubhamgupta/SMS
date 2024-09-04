<?php

include('connection.php');

extract($_REQUEST);

$fromdt = $_REQUEST['fromdt'];

$chg_fdate = date("d-m-Y", strtotime($fromdt));

	

$todt = $_REQUEST['todt'];

$chg_tdate = date("d-m-Y", strtotime($todt));



$expense = $_REQUEST['expense'];


	if($expense!="" ){

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense'  and status='0' and session='".$_SESSION['session']."' ";

	

    }else if($expense=="" ){

	$query = "SELECT * FROM `expense` where status='0' and session='".$_SESSION['session']."' ";

	}	

if(!empty($fdt) && !empty($tdt)){

    $query.=" and date between '$fromdt' AND '$todt' ";

}

// echo $query;
$search_result = filterTable($query);	


function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader = "Expense Receipt No".","."Expense Type".","."Expense Details".","."Amount".","."Point of Contact".","."Expense Datetime";


$data='';



$tpaidamt=0;

while($res=mysqli_fetch_array($search_result))

					{

					$id=$res['expense_id'];				

					$exp_typeid=$res['expense_type_id'];

					$re=mysqli_query($con,"select * from expense_type where expense_type_id='$exp_typeid'");

					$res2=mysqli_fetch_array($re);

					$expdt = $res['expensed_datetime'];

					$nexpdt = date('d-m-Y h:i A', strtotime($expdt));		



 $data .= $id.",".$res2['expense_type_name'].",".$res['expense_details'].",".$res['amount'].",".$res['point_of_contact'].",".$nexpdt."\n";

}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');	



$filename =  "ExpenseReport_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

