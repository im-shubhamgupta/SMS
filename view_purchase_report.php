<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($_POST['search']))
{
	
	$cond = '';
	
	if($_POST['sttypeid']!='') 
	{
		$cond.=" && stock_type_id='$_REQUEST[sttypeid]'";
	}
	if($_POST['vendor']!='') 
	{
		$cond.=" && stock_vendor_id='$_REQUEST[vendor]'";
	}
	
	$query = mysqli_query($con,"SELECT * FROM `purchase_order` WHERE purchase_date between '$fromdt' AND '$todt' $cond");
	
}

?>

	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

	</style>
	
<script type="text/javascript">
$(document).ready(function(){
    $(".menu a").each(function(){
        if($(this).hasClass("disabled")){
            $(this).removeAttr("href");
        }
    });
});
</script>
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Stock Management</a>
   <span class="breadcrumb-item active">Purchase Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_purchase_report" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
                        <div class="row" style="margin-top:20px;">
								
							<div class="col-md-3" style="font-size:14px;">From Date</div>
							<div class="col-md-2" style="margin-left:-180px;margin-top:-10px;">
							<input type="date" name="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>" autofocus required>
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-3" style="font-size:14px;">To Date</div>
							<div class="col-md-2" style="margin-left:-180px;margin-top:-10px">
							<input type="date" name="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>" autofocus required>
							</div>
							
						</div><br>
						
						<div class="row" style="margin-top:20px;">
								
							<div class="col-md-3" style="font-size:14px;">Stock Type</div>
							<div class="col-md-2" style="margin-left:-180px;margin-top:-10px;">
							<select name="sttypeid" class="form-control" style="width:175px;">
							<option value="" selected="selected">All</option>
							<?php
							$qt = mysqli_query($con,"select * from stock_type");
							while( $rt = mysqli_fetch_array($qt) ) {
							?>
							<option <?php if($sttypeid==$rt['stock_type_id']){echo "selected";}?> value="<?php echo $rt['stock_type_id']; ?>"><?php echo $rt['stock_type_name']; ?>
							</option>
							<?php } ?>	
							</select>
							</div>
								
							<div class="col-md-1"></div>
							<div class="col-md-3" style="font-size:14px;">Vendor</div>
							<div class="col-md-2" style="margin-left:-180px;margin-top:-10px">
							<select name="vendor" class="form-control" style="width:175px;">
							<option value="" selected="selected">All</option>
							<?php
							$st = mysqli_query($con,"select * from stock_vendor");
							while( $rst = mysqli_fetch_array($st) ) {
							?>
							<option <?php if($vendor==$rst['stock_vendor_id']){echo "selected";}?> value="<?php echo $rst['stock_vendor_id']; ?>"><?php echo $rst['stock_vendor_name']; ?>
							</option>
							<?php } ?>	
							</select>
							</div>
							
							<div class="col-md-2">
							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:150px;" value="Submit"><br><br>
							</div>
						</div><br>
						
						
						<!--table starts from here-->
						<div class="card">
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
										</tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
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
									</tr>
                                    <?php 
									$tquantity += $quantity;
									$tamount += $amount;
									
									$sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
							
							<div class="card-footer">
								<a href="export_purchaseorder_report_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&sttypeid=<?php echo $sttypeid;?>&vendorid=<?php echo $vendor;?>" class="btn btn-success btn-sm">
								<i class="fa fa-download"></i> Download To Excel</a>
							</div>
							
                        </div>
						
						
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<?php 
						if(isset($search))
						{
							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> Total $tquantity items are purchased for $tamount Rupees. </h5>" ;
						}
						?>
						</div>						
						</div>
						<br>
						
						
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<style>
			
		@media print{
		#printbtn{
		display: block;
				}
			}
		</style>
	
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 