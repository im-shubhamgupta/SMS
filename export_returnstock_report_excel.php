<?php
include('connection.php');
extract($_REQUEST);

$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];
$sttypeid = $_REQUEST['sttypeid'];
$vendorid = $_REQUEST['vendorid'];

	$cond = '';
	
	if($sttypeid!='') 
	{
		$cond.=" && stock_type_id='$sttypeid'";
	}
	if($vendorid!='') 
	{
		$cond.=" && vendor_id='$vendorid'";
	}
	 
	$query = mysqli_query($con,"SELECT * FROM `return_stock` WHERE returned_date between '$fromdt' AND '$todt' $cond");

$columnHeader ='';
$columnHeader = "Return ID".","."Returned Date".","."Stock Type".","."Issued No".","."Purchased ID".","."Quantity".","."Discription";

$data='';

while($res=mysqli_fetch_array($query))
{
$id=$res['ret_ord_id'];
$roid=$res['roid'];
$retdt=$res['returned_date'];
$newretdt= date("d-m-Y",strtotime($retdt));	
$stockid=$res['stock_type_id'];
$qst=mysqli_query($con,"select * from stock_type where stock_type_id ='$stockid'");
$rst=mysqli_fetch_array($qst);
$stockname=$rst['stock_type_name'];

$issid = $res['issue_ord_id'];
$q1=mysqli_query($con,"select * from issue_order where issue_ord_id ='$issid'");
$r1=mysqli_fetch_array($q1);
$issuedid=$r1['ioid'];

$purid = $res['pur_ord_id'];
$q2=mysqli_query($con,"select * from purchase_order where pur_ord_id ='$purid'");
$r2=mysqli_fetch_array($q2);
$purchaseid=$r2['poid'];

$quantity = $res['return_qty'];
$desc = $res['description'];
						
$data .= $roid.",".$newretdt.",".$stockname.",".$issuedid.",".$purchaseid.",".$quantity.",".$desc."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Returnstock_report_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
