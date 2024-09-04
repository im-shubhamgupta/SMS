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
		$cond.=" && stock_vendor_id='$vendorid'";
	}
	
	$query = mysqli_query($con,"SELECT * FROM `purchase_order` WHERE purchase_date between '$fromdt' AND '$todt' $cond");
	
$columnHeader ='';
$columnHeader = "Purchase ID".","."Purchased Date".","."Created Date".","."Stock Type".","."Quantity".","."Amount".","."Discription".","."Vendor Details".","."Identification Number";

$data='';

while($res=mysqli_fetch_array($query))
{
$id=$res['pur_ord_id'];
$poid=$res['poid'];
$purdt=$res['purchase_date'];
$newpurdt= date("d-m-Y",strtotime($purdt));	
$createddt=$res['pur_ord_created'];
$newcreateddt= date("d-m-Y",strtotime($createddt));
$stockid=$res['stock_type_id'];
$qst=mysqli_query($con,"select * from stock_type where stock_type_id ='$stockid'");
$rst=mysqli_fetch_array($qst);
$stockname=$rst['stock_type_name'];
$quantity = $res['quantity'];
$amount = $res['amount'];
$stvenid = $res['stock_vendor_id'];
$q4 = mysqli_query($con,"select * from stock_vendor where stock_vendor_id='$stvenid'");
$r4 = mysqli_fetch_array($q4);
						
$data .= $poid.",".$newpurdt.",".$newcreateddt.",".$stockname.",".$quantity.",".$amount.",".$res['description'].",".$r4['stock_vendor_name'].",".$res['identification_no']."\n";
}
	
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	
$dat = $date->format('d-m-Y H:i:s');


$filename =  "Purchaseorder_report_".$dat.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

//echo $data;
echo ucwords($columnHeader)."\n".$data."\n"; 
//echo ucwords($columnHeader)."\n".$setData."\n";
exit; 

?>
