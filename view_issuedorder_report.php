<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($_POST['search']))
{
	
	$cond = '';
	
	if($_POST['stock']!='') 
	{
		$cond.=" && stock_type_id='$_REQUEST[stock]'";
	}
	if($_POST['vendor']!='') 
	{
		$cond.=" && stock_vendor_id='$_REQUEST[vendor]'";
	}

	$query = mysqli_query($con,"SELECT * FROM issue_order WHERE issued_date between '$fromdt' AND '$todt' $cond");
	
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
   <span class="breadcrumb-item active">Issued Order Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_issuedorder_report" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
                        <div class="row" style="margin-top:20px;">
								
								<div class="col-md-4" style="font-size:14px;">From Date</div>
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
								
								<div class="col-md-4" style="font-size:14px;">Issued Stock Type</div>
								<div class="col-md-2" style="margin-left:-180px;margin-top:-10px;">
								<select name="stock" class="form-control" style="width:175px;">
								<option value="" selected="selected">All</option>				
								<?php
								$sql = "SELECT * FROM stock_type";
								$resultset = mysqli_query($con, $sql);
								while( $rows = mysqli_fetch_array($resultset) ) {
								?>
								<option <?php if($stock==$rows['stock_type_id']){echo "selected";}?> value="<?php echo $rows['stock_type_id']; ?>"><?php echo $rows['stock_type_name']; ?>
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
                                            <th>Issued ID</th>
											<th>Stock Type</th>
											<th>Issued Date</th>
											<th>Identification Number</th>
											<th>Quantity</th>
											<!--<th>Amount</th>-->
											<th>Discription</th>
											<th>Vendor Detail</th>
										</tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['issue_ord_id'];
									$issuedid=$res['ioid'];
									$stockid=$res['stock_type_id'];
									$qst=mysqli_query($con,"select * from stock_type where stock_type_id ='$stockid'");
									$rst=mysqli_fetch_array($qst);
									$stockname=$rst['stock_type_name'];
									$issueddt=$res['issued_date'];
									$newissueddt= date("d-m-Y",strtotime($issueddt));
									$quantity = $res['quantity'];
									$amount = $res['amount'];
									$venid = $res['stock_vendor_id'];
									$qvn=mysqli_query($con,"select * from stock_vendor where stock_vendor_id ='$venid'");
									$rvn=mysqli_fetch_array($qvn);
									$venname=$rvn['stock_vendor_name'];
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $issuedid; ?></td>
										<td><?php echo $stockname; ?></td>
										<td><?php echo $newissueddt; ?></td>
										<td><?php echo $res['identification_no']; ?></td>
										<td><?php echo $quantity;?></td>
									<!--	<td><?php echo $amount;?></td> -->
										<td><?php echo $res['description'];?></td>
										<td><?php echo $venname;?></td>
									</tr>
                                    <?php 
									$tquantity += $quantity;
									$tamount += $amount;
									
									$sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
							
							<div class="card-footer">
								<a href="export_issueorder_report_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&stock=<?php echo $stock;?>&vendorid=<?php echo $vendor;?>" class="btn btn-success btn-sm">
								<i class="fa fa-download"></i> Download To Excel</a>
							</div>
							
                        </div>
						
						
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<?php 
						if(isset($search))
						{
							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> Total Issued count $tquantity. <!--for the worth of Amount $tamount.--> </h5>" ;
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
 
 