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

		window.location.href="delete_trans_transaction.php?x=" + id + "& rea=" +reason + "& smid=" +smid;

		return true;

		}

		else

		{	

		return false;

		}

	}

		

</script>

<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$stuid=$_REQUEST['stuid'];







?>





<div id="right-panel" class="right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Accounts Panel</a>

  <a class="breadcrumb-item" href="#">Fees</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_transport_fee_detail">Collect Transport Fees</a>

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

											 <th>Transport Fee</th>

											 <th>Previous Transport Fee</th>

											 <th>Total Paid</th>
											 <th>Route_name</th>

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

									$query=mysqli_query($con,"select * from student_transport_due_fees where student_id='$stuid' and (status='0' || status='1') and session='".$_SESSION['session']."' ");

									$sr=1;
									if(mysqli_num_rows($query)>0){
									while($res=mysqli_fetch_array($query))

									{

										

									$row = mysqli_num_rows($query);

									

									$sdid=$res['student_trans_fee_id'];	

									

									$date=$res['issue_date'];

									$issdate=date("d-m-y H:i:s", strtotime($date));

									

									$trans_id =$res['trans_id'];
									$transfee =$res['trans_amount'];

									$prefee =$res['previous_trans_amount'];

									

									$tpaid = $transfee + $prefee;

									

									$totpaid +=$tpaid;

									

									$ptid=$res['payment_type_id'];

									$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");

									$rptid=mysqli_fetch_array($qptid);

									$paidby=$rptid['payment_type_name'];

									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $transfee; ?></td>

										<td><?php echo $prefee; ?></td>

										<td><?php echo $tpaid; ?></td>
										<td><?php echo get_route_name($trans_id); ?></td>

										<td><?php echo $paidby; ?></td>

										<td><?php echo $res['payment_detail']; ?></td>

										<td><?php echo $res['issued_by'];?></td>

										<td><?php echo $issdate;?></td>

										<td>

										<?php echo "<a href='reprint_trans_receipt.php?id=$sdid' 

										class='btn btn-outline-success btn-sm' target='_blank' title='Print Receipt'>Re-Print</a>";

										?>

										</td> 

										

										<?php 

										// if($sr<$row)

										// {	

										?>

										<td>

										<input onclick="return confirm('Cannot able to delete the old Transactions. Contact Administrator.');" type="submit" value="Delete" id="add" class="btn btn-outline-danger btn-sm"/>

										</td> 

										<?php

										// }else

										// {

										?>
<!-- 
										<td>

										<a href="#" class="btn btn-outline-danger btn-sm" onclick="delet('<?php echo $sdid;?>',30)">Delete</a>

										</td> -->

										<?php

										// }

										?>

										

									</tr>

                                    <?php $sr++;

									} 
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

		

		<a href="dashboard.php?option=view_transport_fee_detail" class="btn btn-primary">Back</a>

		

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