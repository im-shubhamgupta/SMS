<?php

include('connection.php');

extract($_REQUEST);



$header = $_REQUEST['header'];

$fromdt = $_REQUEST['fromdt'];

$todt = $_REQUEST['todt'];



$cond = " and session='".$_SESSION['session']."'";

	

	if($_REQUEST['header']!='') 

	{

		$cond.=" && budget_header_id='$header'";

	}

	

	$query = mysqli_query($con,"SELECT * FROM `allocate_budget_expense` WHERE expense_date between '$fromdt' AND '$todt' $cond");

		

$columnHeader ='';

$columnHeader = "Budget Expense ID".","."Budget Expense Date".","."Budget Expense Type".","."Description".","."Expensed Amount";





$data='';



$totalamt = 0;

while($res=mysqli_fetch_array($query))

{

$id=$res['id'];

$expense_id=$res['expense_id'];

$expense_date=$res['expense_date'];

$nwdate = date("d-m-Y",strtotime($expense_date));



$header_id=$res['budget_header_id'];

$qh=mysqli_query($con,"select * from budget_header where budget_header_id ='$header_id'");

$rh=mysqli_fetch_array($qh);

$headername=$rh['budget_header_name'];

$description=$res['description'];

$expensed_amount=$res['expensed_amount'];



$totalamt = $totalamt + $expensed_amount;



 $data .= $expense_id.",".$nwdate.",".$headername.",".$description.",".$expensed_amount."\n";

}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "Budgetexpense_Report_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



//echo $data;

echo ucwords($columnHeader)."\n".$data."\n"; 

//echo ucwords($columnHeader)."\n".$setData."\n";

exit; 



?>

