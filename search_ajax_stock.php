<?php 

extract($_REQUEST);

include('connection.php');



$sr =1;

$q=mysqli_query($con,"select * from purchase_order where pur_ord_id='$pur_id'");

while($res=mysqli_fetch_array($q))

{



		$id=$res['pur_ord_id'];

		$purdt=$res['purchase_date'];

		$npurdt=date("d-m-Y",strtotime($purdt));

		$stid=$res['stock_type_id'];

		$q1 = mysqli_query($con,"select * from stock_type where stock_type_id ='$stid'");

		$r1 = mysqli_fetch_array($q1);

		$stocktype = $r1['stock_type_name'];

		$venid=$res['stock_vendor_id'];

		$q2 = mysqli_query($con,"select * from stock_vendor where stock_vendor_id ='$venid'");

		$r2 = mysqli_fetch_array($q2);

		$venname = $r2['stock_vendor_name'];

		$tqty=$res['quantity'];

		

		$q3 = mysqli_query($con,"select * from issue_order where pur_ord_id='$id'");

		$tissue_qty = 0;

		while($r3 = mysqli_fetch_array($q3))

		{

			$tissue_qty += $r3['quantity'];

		}

		

		$tbal_qty = $tqty - $tissue_qty;

?>

	<tr>

		<td><?php echo $sr; ?></td>

		<td><?php echo $npurdt; ?></td>

		<td><?php echo $stocktype; ?></td>

		<td ><?php echo $tqty; ?></td>

		<td><?php echo $tissue_qty; ?></td>

		<td><?php echo $tbal_qty; ?></td>

		<td><?php echo $venname; ?></td>

		<input type="hidden" name="avilable_qty" id='avilable_qty' value="<?php echo "$tbal_qty" ?>"/>
		<input type="hidden" name="venid" value="<?php echo "$venid" ?>"/>
		<input type="hidden" name="amount_per_iem" value="<?php echo $res['amt_per_item'] ?>"/>

	</tr>

	

<?php $sr++; 

}

?>

	

	





