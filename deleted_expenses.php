<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{

	

	$fromdt = $_POST['fromdt'];


	if(!empty($fromdt) ){
  			$chg_fdate = date("d-m-Y", strtotime($fromdt));
    }else{
    	$chg_fdate='';
    }

    $todt = $_POST['todt'];
    if(!empty($todt) ){
  			$chg_tdate = date("d-m-Y", strtotime($todt));
    }else{
    	$chg_tdate='';
    }

    $expense = $_POST['expense'];

	$expn=mysqli_query($con,"select * from expense_type where expense_type_id='$expense'");

	$rexp=mysqli_fetch_array($expn);

	$expname=$rexp['expense_type_name'];

    

	/*if($expense!="" and $fromdt!="" and $todt!="")

	{

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense' and 

	date between '$fromdt' AND '$todt' and status='1'";

	$search_result = filterTable($query);

    }

	else if($expense!="" and $fromdt=="" and $todt=="")

	{

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense' and status='1'";

	$search_result = filterTable($query);	

	}

	else if($expense=="" and $fromdt!="" and $todt!="")

	{

	$query = "SELECT * FROM `expense` WHERE date between '$fromdt' AND '$todt' and status='1'";

	$search_result = filterTable($query);	

	}

	else if($expense=="" and $fromdt=="" and $todt=="")

	{

	$query = "SELECT * FROM `expense` and status='1'";

	$search_result = filterTable($query);	

	}	*/

	if($expense!="" ){

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense'  and status='1' and session='".$_SESSION['session']."' ";

	

    }else if($expense=="" ){

	$query = "SELECT * FROM `expense` where status='1' and session='".$_SESSION['session']."' ";

	}	

if(!empty($fromdt) && !empty($todt)){

    $query.=" and date between '$fromdt' AND '$todt' ";

}
    $query.=" Order by expense_id desc ";
	$search_result = filterTable($query);	

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

  <a class="breadcrumb-item" href="#">Report Panel</a>

  <a class="breadcrumb-item" href="#">Expense Report</a>

  <span class="breadcrumb-item active">Deleted Expenses</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=deleted_expenses" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						
						<div class="row" style="margin-top:20px;">
								<div class="col-md-3">Expense Type</div>

								<div class="col-md-2" style="margin-left:-120px;margin-top:-10px;">

								<select name="expense" class="form-control" style="width:175px;">

								<option value="" selected="selected">All</option>

								<?php

								$sql = "SELECT * FROM expense_type";

								$resultset = mysqli_query($con, $sql);

								while( $rows = mysqli_fetch_array($resultset) ) {

								?>

								<option <?php if($expense==$rows['expense_type_id']){echo "selected";}?> value="<?php echo $rows['expense_type_id']; ?>"><?php echo $rows['expense_type_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								

							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:160px;" value="Submit"><br><br>

							</div>

						</div>
						<span><small><u>(optional filters)</u></small></span>

						<div class="row" style="margin-top:20px;">

								

								<div class="col-md-3">From Date</div>

								<div class="col-md-2" style="margin-left:-120px;margin-top:-10px;">

								<input type="date" name="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>" >

								</div>

								<div class="col-md-1"></div>

								<div class="col-md-3" style="font-size:14px;">To Date</div>

								<div class="col-md-2" style="margin-left:-180px;margin-top:-10px">

								<input type="date" name="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>" >

								</div>

							

						</div><br>


						

						

						

						

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                               <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Expense Receipt No</th>

                                            <th>Expense Type</th>

											<th>Expense Amount</th>

											<th>Description</th>

											<th>Deleted Reason</th>

											<th>Deleted By</th>

											<th>Deleted Date & Time</th>

										</tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$amount=0;

									while($res=mysqli_fetch_array($search_result))

									{

									$id=$res['expense_id'];

									$exp_typeid=$res['expense_type_id'];

									$proof=$res['proofs'];	

									$amount+=$res['amount'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $id; ?></td>

										<?php 

									$re=mysqli_query($con,"select * from expense_type where expense_type_id='$exp_typeid'");

									$result=mysqli_fetch_array($re);

									?>

										<td><?php echo $result['expense_type_name']; ?></td>

										<td><?php echo $res['amount']; ?></td>

										<td><?php echo $res['expense_details']; ?></td>

										<td><?php echo $res['reason']; ?></td>
										

				<!-- For Permission -->						

								        <td><?php echo $res['deleted_by']; ?></td>
										<td><?php echo $res['deleted_date']; ?></td>

										

												

				<!-- For Permission -->	

				

									</tr>

                                    <?php $sr++; } ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						if(isset($search))

						{

							if($fromdt!="" and $todt!="" and $expense!="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Deleted Expense from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; for &nbsp;$expname is : Rs $amount </h5>" ;

							}

							else if($fromdt=="" and $todt=="" and $expense!="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Deleted Expense for &nbsp;$expname is : Rs $amount </h5>" ;	

							}

							else if($fromdt!="" and $todt!="" and $expense=="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Deleted Expense from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; for all Expense type is : Rs $amount </h5>" ;	

							}

							else if($fromdt=="" and $todt=="" and $expense=="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Deleted Expense is : Rs $amount </h5>" ;	

							}

						}

						?>

						</div>						

						</div>

						<br>

						

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<!--

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

	

		<a href="print_expense.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&expense=<?php echo $expense;?>" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>

		

		<a href="export_expense_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&expense=<?php echo $expense;?>" class="btn btn-success btn-sm" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>

	

		</div>-->

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 