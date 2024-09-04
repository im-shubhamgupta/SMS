<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



if(isset($_POST['search']))

{

		

	$cond = " and session='".$_SESSION['session']."' ";

	

	if($_POST['header']!='') 

	{

		$cond.=" && budget_header_id='$header'";

	}

				

	$query = mysqli_query($con,"SELECT * FROM `allocate_budget_expense` WHERE expense_date between '$fromdt' AND '$todt' $cond");

	

}

	

?>





<div id="right-panel" class="right-panel">



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Report</a>

  <span class="breadcrumb-item active">Allocated Budget Expense Report</span>

</nav>



	<form method="post" action="dashboard.php?option=allocated_budget_expense_report" enctype="multipart/form-data">

		

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

					

						<div class="row" style="margin-top:20px;">

								

								<div class="col-md-2" style="font-size:14px;margin-left:50px;">From Date</div>

								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">

								<input type="date" name="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>" autofocus required>

								</div>

								<div class="col-md-2" style="font-size:14px;margin-left:60px;">To Date</div>

								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

								<input type="date" name="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>" autofocus required>

								</div>

							

						</div><br>	



						<div class="row" style="margin-top:20px;">

								

								<div class="col-md-2" style="font-size:14px;margin-left:50px;">Budget Header</div>

								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">

								<select class="form-control" name="header" id="header" style="width:175px;">

								<option value="">All</option>

								<?php

								$ql=mysqli_query($con,"select * from budget_header");

								while($rl=mysqli_fetch_array($ql))

								{

								?>

								<option <?php if($header==$rl['budget_header_id']){echo "selected";}?> value="<?php echo $rl['budget_header_id']; ?>"><?php echo $rl['budget_header_name'];?>

								</option>

								<?php 

								}

								?>							

								</select>

								</div>

								

								

								<div class="col-md-2">

								<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:140px;margin-left:180px;" value="Load"><br><br>

								</div>	

						</div><br>	

						<br>

										

					

                        <div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Budget Expense ID</th>

											 <th>Budget Expense Date</th>

											 <th>Budget Expense Type</th>

											 <th>Description</th>

											 <th>Expensed Amount</th>

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$totalamt = 0;
									if(isset($query) && mysqli_num_rows($query)>0){
									while($res=mysqli_fetch_array($query))

									{

									$id=$res['id'];

									$expense_id=$res['expense_id'];

									$expense_date=$res['expense_date'];

									$nwdate = date("d-m-Y",strtotime($expense_date));

									

									$header_id=$res['budget_header_id'];

									$qh=mysqli_query($con,"select * from budget_header where budget_header_id ='$header_id'");

									$rh=mysqli_fetch_array($qh);

									$headername=$rh['budget_header_name'];

									$description=$res['description'];

									$expensed_amount=$res['expensed_amount'];

									

									$totalamt = $totalamt + $expensed_amount;

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $expense_id; ?></td>

										<td><?php echo $nwdate; ?></td>

										<td><?php echo $headername; ?></td>

										<td><?php echo $description;?></td>

										<td><?php echo $expensed_amount;?></td>

									</tr>

                                    <?php $sr++; } }?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						if(isset($search))

						{

							if($header=="")

							{

								$head = "All";

							}

							else

							{

								$q1=mysqli_query($con,"select * from budget_header where budget_header_id='$header'");

								$r1=mysqli_fetch_array($q1);

								$head = $r1['budget_header_name'];

							}

							

							$nfrmdt = date("d-m-Y",strtotime($fromdt));

							$ntodt = date("d-m-Y",strtotime($todt));

									

								

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> Total Expense of the Allocated Budget for $head from $nfrmdt to $ntodt is Rs $totalamt. </h5>" ;

						}

						?>

						</div>						

						</div><br>

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

					

						<div style="text-align:center">

		

						<a href="export_allocated_budget_expense_excel.php?header=<?php echo $header;?>&fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download To Excel</a>

		

						</div>

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>