

	<style>

	tr th{

		

		font-size:15px;

	}



	tr td{

		

		font-size:15px;

	}



	</style>



<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <span class="breadcrumb-item active">View Logs</span>

</nav>

<!-- breadcrumb -->

   <form method="post" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Log Detail</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Deleted By</th>

											 <th>Deleted Date</th>

											 <th>Action Type</th>

											 <th>Amount</th>

											 <th>Action</th>

											 <th>Reason</th>											

	                                    </tr>

                                    </thead>

                                    <tbody>

									<?php 

									include('connection.php');

									extract($_REQUEST);

									$sr=1;

									$query=mysqli_query($con,"select * from student_due_fees where status=4 and session='".$_SESSION['session']."'");

									while($res=mysqli_fetch_array($query))

									{

									$stuid=$res['student_id'];

									$q1=mysqli_query($con,"select * from students where student_id='$stuid'  and session='".$_SESSION['session']."'");

									$r1=mysqli_fetch_array($q1);

									$stuname=$r1['student_name'];

									$regno=$r1['register_no'];

									$tamt = $res['total_amount'];							

									$user=$res['loginuser'];	

									

									$actdt = $res['action_date'];

									$nactdt = date("d-m-Y H:i:s", strtotime($actdt));

																			

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res['loginuser']; ?></td>

										<td><?php echo $nactdt;?></td>

										<td><?php echo $res['action_type'];?></td>

										<td><?php echo $tamt;?></td>

										<td><?php echo "The Paid Fees of amount $tamt for the Student '$stuname' Register Number '$regno' is deleted by '$user'.";?></td>

										<td><?php echo $res['reason'];?></td>

																											

									</tr>

                                    <?php $sr++; } ?>

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

							<a href="export_logreport_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>" 

							class="btn btn-success btn-sm" style="margin-right:30px"> <i class="fa fa-download"> </i> Download To Excel</a>

							

							<a href="print_log_report.php?class=<?php echo $class;?>&section=<?php echo $section;?>" 

							class="btn btn-primary btn-sm" target='_blank' style="margin-right:30px;"><i class="fa fa-print"></i> Print</a>

						

							</div>

							

							

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

		

	</form>

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>