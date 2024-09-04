<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

	

?>

	

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



<div id="right-panel" class="right-panel">

   <form method="post" action="dashboard.php?option=view_logs" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

								<h3 align="center">Log Report <?php echo $clsn; ?> Section <?php echo $sec; ?> </h3>

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

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

									$sr=1;

									$query=mysqli_query($con,"select * from student_due_fees where status=4  and session='".$_SESSION['session']."'");

									while($res=mysqli_fetch_array($query))

									{

									$stuid=$res['student_id'];

									$q1=mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."' ");

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

                                    <?php $sr++; }

									

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

		<style>

			

		@media print{

		#printbtn{

		display: none;

				}

			}

		</style>

		

		

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=view_logs" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 