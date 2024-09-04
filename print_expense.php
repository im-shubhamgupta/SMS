<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

$fromdt = $_REQUEST['fromdt'];

$chg_fdate = date("d-m-Y", strtotime($fromdt));

	

$todt = $_REQUEST['todt'];

$chg_tdate = date("d-m-Y", strtotime($todt));



	$expense = $_REQUEST['expense'];

	$expn=mysqli_query($con,"select * from expense_type where expense_type_id='$expense'");

	$rexp=mysqli_fetch_array($expn);

	$expname=$rexp['expense_type_name'];

	

/*	if($expense=="" and $fromdt=="" and $todt=="")

	{

	$query = "SELECT * FROM `expense` and status='0'";

	$search_result = filterTable($query);	

	}	

	if($expense!="" and $fromdt!="" and $todt!="")

	{

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense' and 

	date between '$fromdt' AND '$todt' and status='0'";

	$search_result = filterTable($query);

    }

	else if($expense!="" and $fromdt=="" and $todt=="")

	{

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense' and status='0'";

	$search_result = filterTable($query);	

	}

	else if($expense=="" and $fromdt!="" and $todt!="")

	{

	$query = "SELECT * FROM `expense` WHERE date between '$fromdt' AND '$todt' and status='0'";

	$search_result = filterTable($query);	

	}
*/
	
	if($expense!="" ){

	$query = "SELECT * FROM `expense` WHERE expense_type_id='$expense'  and status='0' and session='".$_SESSION['session']."' ";

	

    }else if($expense=="" ){

	$query = "SELECT * FROM `expense` where status='0' and session='".$_SESSION['session']."' ";

	}	

if(!empty($fdt) && !empty($tdt)){

    $query.=" and date between '$fromdt' AND '$todt' ";

}

// echo $query;
$search_result = filterTable($query);	
	
	

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

		

		font-size:12px;

	}



	tr td{

		

		font-size:12px;

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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



<div id="right-panel" class="right-panel">

   <form method="post" action="dashboard.php?option=expense_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

							if($fromdt=="" and $todt=="" and $expense=="")

							{

							echo "<h3 align='center'> Expense Report</h3>" ;	

							}

							else if($fromdt!="" and $todt!="" and $expense!="")

							{

							echo "<h3 align='center'> Expense Report for $expname from $chg_fdate to $chg_tdate  </h3>" ;

							}

							else if($fromdt=="" and $todt=="" and $expense!="")

							{

							echo "<h3 align='center'> Expense Report for $expname from $chg_fdate to $chg_tdate  </h3>" ;	

							}

							else if($fromdt!="" and $todt!="" and $expense=="")

							{

							echo "<h3 align='center'> Expense Report for $expname from $chg_fdate to $chg_tdate  </h3>" ;	

							}

							

						?>

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

											<th>Expense Details</th>

											<th>Amount</th>

											<th>Point of Contact</th>

											<th>Expense Datetime</th>

											<th>Proof</th>

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									while($res=mysqli_fetch_array($search_result))

									{

									$id=$res['expense_id'];

									$exp_typeid=$res['expense_type_id'];

									$proof=$res['proofs'];

									$amount+=$res['amount'];

									$expdt = $res['expensed_datetime'];

									$nexpdt = date('d-m-Y h:i A', strtotime($expdt));

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $id; ?></td>

										<?php 

									$re=mysqli_query($con,"select * from expense_type where expense_type_id='$exp_typeid'");

									$result=mysqli_fetch_array($re);

									?>

										<td><?php echo $result['expense_type_name']; ?></td>

										<td><?php echo $res['expense_details']; ?></td>

										<td><?php echo $res['amount']; ?></td>

										<td><?php echo $res['point_of_contact']; ?></td>

										<td><?php echo $nexpdt; ?></td>

										<td><img src="images/proof/<?php echo $proof; ?>" height="70px" width="70px"></td>

				

									</tr>

                                    <?php $sr++; } ?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

							if($fromdt=="" and $todt=="" and $expense=="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Expense is : Rs $amount </h5>" ;	

							}

							else if($fromdt!="" and $todt!="" and $expense!="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Expense from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; for &nbsp;$expname is : Rs $amount </h5>" ;

							}

							else if($fromdt=="" and $todt=="" and $expense!="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Expense for &nbsp;$expname is : Rs $amount </h5>" ;	

							}

							else if($fromdt!="" and $todt!="" and $expense=="")

							{

							echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Expense from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; is : Rs $amount </h5>" ;	

							}

							

						?>

						</div>						

						</div><br>

						

			

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

		

		<a href="dashboard.php?option=expense_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:20px">Back</a>

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 