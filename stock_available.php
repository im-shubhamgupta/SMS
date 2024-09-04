<?php
error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
	
    $sttypeid = $_POST['sttypeid'];
    
	if($sttypeid=="")
	{
	$query = "SELECT * FROM `purchase_order`";
	$search_result = filterTable($query);	
	}
	else if($sttypeid!="")
	{
	$query = "SELECT * FROM `purchase_order` WHERE stock_type_id='$sttypeid'";
	$search_result = filterTable($query);	
	}
		
}


// function to connect and execute the query
function filterTable($query)
{
    include('connection.php');
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
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
   <span class="breadcrumb-item active">Stock Availability</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=stock_available" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
												
						<div class="row" style="margin-top:20px;">
								
							<div class="col-md-2" style="font-size:14px;margin-left:150px">Select Stock Type</div>
							<div class="col-md-2" style="margin-top:-10px;">
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
							
						</div><br>
						
						<div class="row" style="margin-top:20px;">
								
							<div class="col-md-2" style="margin-left:315px;">
							<input type="submit" name="search" class="btn btn-primary btn-sm"  value="Submit"><br><br>
							</div>
							<div class="col-md-2" style="margin-left:-50px;">
							<input type="reset" name="search" class="btn btn-info btn-sm" value="Cancel"><br><br>
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
											<th>Stock Type</th>
											<th>Quantity</th>
											<th>Issued Quantity</th>
											<th>Dead</th>
											<th>Available Quantity</th>
											<th>Issued Details</th>
											<th>Amount</th>
											<th>Discription</th>
											<th>Attachments</th>
										</tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($search_result))
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
									
									$q3 = mysqli_query($con,"select * from issue_order where pur_ord_id='$id'");
									$tissue_qty = 0;
									$issdet = "";
									while($r3 = mysqli_fetch_array($q3))
									{
										$tissue_qty += $r3['quantity'];
										
										$issdet = $issdet.$r3['ioid'].",";
									}
									
									$issuedetail = rtrim($issdet,',');
									
									$q5 = mysqli_query($con,"select * from dead_stock where pur_ord_id='$id'");
									$tdead_qty = 0;
									while($r5 = mysqli_fetch_array($q5))
									{
										$tdead_qty += $r5['dead_stock_qty'];
									}
									
									$qret = mysqli_query($con,"select * from return_stock where stock_type_id='$stockid'");
									
									
									$tbal_qty = $quantity - $tissue_qty - $tdead_qty;
									
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
										<td><?php echo $stockname; ?></td>
										<td><?php echo $quantity;?></td>
										<td><?php echo $tissue_qty;?></td>
										<td><?php echo $tdead_qty;?></td>
										<td><?php echo $tbal_qty;?></td>
										<td><?php echo $issuedetail;?></td>
										<td><?php echo $amount;?></td>
										<td><?php echo $res['description'];?></td>
										<td><a href="gallery/purchaseorder/<?php echo $image; ?>" target="_blank"><img src="gallery/purchaseorder/<?php echo $image;?>" height="70px" width="70px"/></td>
								
									</tr>
                                    <?php 
									$tpurchased += $quantity;
									$tissued += $tissue_qty;
									$tbalance += $tbal_qty;
									$tamount += $amount;
									
									$sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
						
						
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<?php 
						if(isset($search))
						{
							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> 
							Total Purchased Quantity $tpurchased, Issued Quantity $tissued, and Available Quantity are $tbalance. 
							Total Amount spent on Purchase : Rs $tamount. 
							</h5>" ;
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
	
	<!--	<a href="print_expense.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&expense=<?php echo $expense;?>" class="btn btn-primary" style="margin-left:20px;">Print</a>
		
		<a href="export_expense_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&expense=<?php echo $expense;?>" class="btn btn-success" style="margin-left:20px;">Download To Excel</a>
		
		<a href="dashboard.php?option=expense_report" class="btn btn-primary" style="margin-left:20px;">Back</a>
			-->		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 