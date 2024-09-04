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
		$cond.=" && vendor_id='$_REQUEST[vendor]'";
	}
	
	$query = mysqli_query($con,"SELECT * FROM `dead_stock` WHERE returned_date between '$fromdt' AND '$todt' $cond");
	
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
  <a class="breadcrumb-item" href="#">Stock Report</a>
  <span class="breadcrumb-item active">Dead Stock Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_dead_stock_report" enctype="multipart/form-data">      
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
                               <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Dead Stock ID</th>
                                            <th>Returned Date</th>
											<th>Stock Type</th>
											<th>Issued No</th>
											<th>Purchased ID</th>
											<th>Quantity</th>
											<th>Discription</th>
										</tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['dead_stock_id'];
									$dsid=$res['dsid'];
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
									
									$quantity = $res['dead_stock_qty'];
									$desc = $res['description'];
									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $dsid; ?></td>
										<td><?php echo $newretdt; ?></td>
										<td><?php echo $stockname;?></td>
										<td><?php echo $issuedid; ?></td>
										<td><?php echo $purchaseid; ?></td>
										<td><?php echo $quantity;?></td>
										<td><?php echo $desc;?></td>
									</tr>
                                    <?php 
									$sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
							
							<div class="card-footer">
								<a href="export_deadstock_report_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&sttypeid=<?php echo $sttypeid;?>&vendorid=<?php echo $vendor;?>" class="btn btn-success btn-sm">
								<i class="fa fa-download"></i> Download To Excel</a>
							</div>
							
                        </div>
		
						
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
 
 