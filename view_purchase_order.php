<?php
//extract($_REQUEST);
if(isset($update))
{
	$q1 = mysqli_query($con,"select * from issue_order where pur_ord_id='$update'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		echo "<script>alert('The Purchase order already Issued. Cannot able to Edit.')</script>";
	}
	else
	{
		echo "<script>window.location='dashboard.php?option=update_purchase_order&id=$update'</script>";
	}
}

if(isset($delete))
{
	$q1 = mysqli_query($con,"select * from issue_order where pur_ord_id='$delete'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		echo "<script>alert('The Purchase order already Issued. Cannot able to Delete.')</script>";
	}
	else
	{
		mysqli_query($con,"delete from purchase_order where pur_ord_id ='$delete'");
	}
}
	

?>


<form method="post">
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Stock Management</a>
  <span class="breadcrumb-item active"> Purchase Order</span>
  <span class="breadcrumb-item active"> View Purchase Order</span>
</nav>
<!-- breadcrumb -->
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="library")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=create_purchase_order" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Create Purchase Order</a>
            </div>
        </div>
		<?php
		}
		?>	

        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Purchase</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Purchase ID</th>
                                            <th>Purchased Date</th>
											<th>Created Date</th>
											<th>Stock Type</th>
											<th>Quantity</th>
											<th>Amount</th>
											<th>Discription</th>
											<th>Vendor Details</th>
											<th>Identification Number</th>
											<th>Attachments</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query = mysqli_query($con,"SELECT * FROM `purchase_order`");
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
									$image=$res['image'];
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $poid; ?></td>
										<td><?php echo $newpurdt; ?></td>
										<td><?php echo $newcreateddt;?></td>
										<td><?php echo $stockname; ?></td>
										<td><?php echo $quantity;?></td>
										<td><?php echo $amount;?></td>
										<td><?php echo $res['description'];?></td>
										<td><?php echo $r4['stock_vendor_name'];?></td>
										<td><?php echo $res['identification_no']; ?></td>
										<td><a href="gallery/purchaseorder/<?php echo $image; ?>" target="_blank"><img src="gallery/purchaseorder/<?php echo $image;?>" height="70px" width="70px"/></td>
										<td><button type="submit" name="update" class="btn btn-secondary btn-sm" value="<?php echo $id;?>"><i class='fa fa-edit'></i> Edit</button></td>
										<td><button type="submit" name="delete" class="btn btn-danger btn-sm" value="<?php echo $id;?>"><i class='fa fa-trash'></i> Delete</button></td>
													
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
	</form>
 <?php include('bootstrap_datatable_javascript_library.php'); ?>