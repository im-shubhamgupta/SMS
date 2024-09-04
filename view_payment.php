  <?php 
	error_reporting(1);
	include('connection.php');
	extract($_REQUEST);
  ?>
<script type="text/javascript">
	function delet(id,smid)
	{
		var reason=prompt("Do you want to Delete the Transaction.");
		if(reason=="") 
		{
		alert("Please Enter Reason ???");
		}
		else if(reason)
		{	
		window.location.href="delete_transaction.php?x=" + id + "& rea=" +reason + "& smid=" +smid;
		return true;
		}
		else
		{	
		return false;
		}
	}
		
</script>
<?php
$stuid=$_REQUEST['stuid'];
function monthname($id,$con){	
	  $Query=$con->query("select * from months where fee_order_month IN ($id)");	
	  if($Query->num_rows>0){	
	  while($MonthRow=$Query->fetch_assoc()){
		  $Responce[]=$MonthRow['month_name'];	
		  }  
	  }	 
	if(!empty($Responce)){
	  $Responce=implode(',',$Responce);	
	 }	
	 return $Responce;	  
    }	
?>


<div id="right-panel" class="right-panel">
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_student_fees_detail">Collect Fees</a>
  <span class="breadcrumb-item active">Payment History</span>
</nav>

   <form method="post" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1050px;">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Payment Details</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                         <tr>
                                             <th>Sr. No</th>
											 <?php 
											 $qf = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid' and session='".$_SESSION['session']."'");
											 $rf = mysqli_fetch_array($qf);
											 $fid = $rf['fee_header_id'];
											 $arr = explode(',',$fid);
											 foreach($arr as $k)
											 {
									
											 $qf1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
											 $rf1 = mysqli_fetch_array($qf1);
											 $headname = $rf1['fee_header_name'];
											 ?>
											 <th><?php echo $headname; ?></th>
											 <?php
											 }
											 ?>
											 
											 <!--<th>Transportation Fee</th>-->
											 <th>Previous Fee</th>
											 <th>Total Paid</th>											 <th>Months</th>
											 <th>Paid By</th>
											 <th>Challan No.</th>
											 <th>Issued By</th>
											 <th>Issued Date</th>
											 <th>Re-Print</th>
											 <th>Delete</th>
											
	                                     </tr>
                                    </thead>
                                    <tbody>
									<?php
									$query=mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and (status='0' || status='1') and session='".$_SESSION['session']."'");
									$sr=1;
									while($res=mysqli_fetch_array($query))
									{
										
									$row = mysqli_num_rows($query);
									
									$sdid=$res['student_due_fee_id'];	
									$feeamt=$res['received_amount'];									$month=  $res['month'];
									$feearr = explode(',',$feeamt);
									
									$date=$res['issue_date'];
									$issdate=date("d-m-y H:i:s", strtotime($date));
									
									//$transfee =$res['transport_amount'];
									$prefee =$res['previous_amount'];
									
									$ptid=$res['payment_type_id'];
									$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");
									$rptid=mysqli_fetch_array($qptid);
									$paidby=$rptid['payment_type_name'];
									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<?php
										$totalfee = 0;	
										foreach($feearr as $f)
										{
										?>
										<td><?php echo $f; ?></td>
										<?php
										$totalfee = (int)$totalfee + (int)$f;
										}
										
										$tpaid = (int)$totalfee + (int)$prefee;
										$prevfee = (int)$prevfee + (int)$prefee;
										$totpaid = (int)$totpaid + (int)$tpaid;
										?>
										<td><?php echo $prefee; ?></td>
										<td><?php echo $tpaid; ?></td>										
										<td><?php echo monthname($month,$con);?></td>
										<td><?php echo $paidby; ?></td>
										<td><?php echo $res['payment_detail']; ?></td>
										<td><?php echo $res['issued_by'];?></td>
										<td><?php echo $issdate;?></td>
										<td><?php echo "<a href='dashboard.php?option=prereprint_receipt&id=$sdid' 
										class='btn btn-outline-success btn-sm' target='_blank' title='Print Receipt'>Re-Print</a>";?></td> 
										
										<?php 
										if($sr<$row)
										{	
										?>
										<td>
										<input onclick="return confirm('Cannot able to delete the old Transactions. Contact Administrator.');" type="submit" value="Delete" id="add" class="btn btn-outline-danger btn-sm"/>
										</td> 
										<?php
										}else
										{
										?>
										<td>
										<a href="#" class="btn btn-outline-danger btn-sm" onclick="delet('<?php echo $sdid;?>',30)">Delete</a>
										</td>
										<?php
										}
										?>
										
									</tr>
                                    <?php $sr++;
									} 
									?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		<div style="text-align:center">
		
		<a href="dashboard.php?option=view_student_fees_detail" class="btn btn-primary">Back</a>
		
		<br><br>
		<div class="row">
			<div class="col-md-5" style="font-size:16px;margin-left:300px;boder:1px solid black">
			<?php 
			
			echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Paid Amount : Rs $totpaid </h5>" ;
		
			?>
			</div>						
		</div><br>
		<!--<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<input type="submit" name="download_excel" value="Download to Excel" id="addprint" class="btn btn-warning btn-md" style="margin-left:20px;"/>
		
		<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>
		-->
		</div>
	</form>
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>