<script type="text/javascript">

	function delet(id)

	{

		var reason=prompt("Do you want to Delete this Expense??");

		if(reason=="") 

		{

		alert("Please Enter Reason ???");

		}

		else if(reason)

		{	

		window.location.href="delete_trans_expense.php?x=" + id + "& rea=" +reason;

		return true;

		}

		else

		{	

		return false;

		}

	}

</script>

<form method="post">

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport Expense</a>

  <span class="breadcrumb-item active">View Transport Expense</span>

</nav>

<!-- breadcrumb -->

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

        <div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                     <a href="dashboard.php?option=add_transport_expense" class="btn btn-primary btn-sm">

					 <i class="fa fa-plus"></i> Add Transport Expense</a>

            </div>

        </div>

		<?php

		}

		?>	


<!--  -->
        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Expenses</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Expense Receipt No</th>

                                            <th>Expense Type</th>

											<th>Expense Details</th>

											<th>Amount</th>

											<th>Point of Contact</th>

											<th>Expensed Datetime</th>

											<th>Proof</th>

											<th style="width:300px"> Edit</th>
											<th  style="width:300px"> Delete</th>

										</tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from transport_expense where status='0' and session='".$_SESSION['session']."' order by modify_date desc");
									if(mysqli_num_rows($query)>0){
									while($res=mysqli_fetch_array($query))

									{

									$id=$res['trans_expense_id'];

									$exp_typeid=$res['trans_expense_type_id'];

									$proof=$res['proofs'];

									$expdt = $res['expensed_datetime'];

									$chgexdt = date("d-m-Y h:i:s A", strtotime($expdt));

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $id; ?></td>

										<?php 

									$re=mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id='$exp_typeid'");

									$result=mysqli_fetch_array($re);

									?>

										<td><?php echo $result['trans_expense_type_name']; ?></td>

										<td><?php echo $res['trans_expense_details']; ?></td>

										<td><?php echo $res['amount']; ?></td>

										<td><?php echo $res['point_of_contact']; ?></td>

										<td><?php echo $chgexdt;?></td>

										<td><img src="images/transport/<?php echo $proof; ?>" height="70px" width="70px"></td>

				<!-- For Permission -->						

								

										

										<td>

										<?php echo "<a href='dashboard.php?option=update_trans_expense&eid=$id&smid=27' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

											?>

											</td>
											<td>
										<a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Expense" onclick="delet('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete</a>

										</td>

																

				<!-- For Permission -->	

				

									</tr>

                                    <?php $sr++; } }?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

	</form>

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
    <?php include('datatable_links.php'); ?>
 <script>

 var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 500, 999999999], [10, 25, 50, 100, 500, 'All'] ],	
                    // 'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });
</script>