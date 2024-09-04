<script type="text/javascript">

	function delet(id)

	{

		if(confirm("Do You want to delete this Expense Type???"))

		{

			window.location.href='delete_expense.php?x='+id;

		}

	}

</script>

<!-- breadcrumb-->

<style>

.breadcrumb {

    display: -ms-flexbox;

    display: flex;

    -ms-flex-wrap: wrap;

    flex-wrap: wrap;

    padding: .75rem 1rem;

    margin-bottom: 1rem;

    list-style: none;

	margin-left:-18px;

	margin-top:-17px;

    background-color: #237791;

    border-radius: .25rem;

	font-size:19px;

}

.breadcrumb-item{

	color:#fff;

}

.breadcrumb-item .fa fa-home{

	color:#fff;

}

.breadcrumb-item.active {

    color: #eff7ff;

}

.breadcrumb-item+.breadcrumb-item::before {

    display: inline-block;

    padding-right: .5rem;

    color: #eff4f9;

    content: "/";

} 



</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Management</a>

  <span class="breadcrumb-item active">View Allocated Budget Expense</span>

</nav>

<!-- breadcrumb -->

<form method="post">

<div id="right-panel" class="right-panel">

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

        <div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                     <a href="dashboard.php?option=add_budget_expense" class="btn btn-primary btn-sm">

					  <i class="fa fa-plus"></i> Add Budget Expense</a>

            </div>

        </div>

		<?php

		}

		?>	





        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Budget Expense</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Expense Id</th>

                                            <th>Allocated To</th>

                                            <th>Allocated Amount</th>

                                            <th>Available Amount</th>

                                            <th>Expensed Amount</th>

                                            <th>Expensed Date</th>

                                            <th>Description</th>

                                            <th>Amount Remaining</th>

                                          

										<?php

										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

										{

										?>

											<th>Edit</th>

											<!-- <th>Delete</th> -->

										<?php

										}

										?>	

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from allocate_budget_expense where 1 and session='".$_SESSION['session']."'");
									if(mysqli_num_rows($query)>0){

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['id'];

									$expid=$res['expense_id'];	

									$headerid=$res['budget_header_id'];

									$q1=mysqli_query($con,"select * from budget_header where budget_header_id='$headerid'");

									$r1=mysqli_fetch_array($q1);

									$allocated_amt=$res['allocated_amount'];	

									$available_amount=$res['available_amount'];	

									$expensed_amount=$res['expensed_amount'];	

									$expdt=$res['expense_date'];

									$nexpdt=date("d-m-Y",strtotime($expdt));

									$description=$res['description'];	

									$remaining_amt=$res['amount_remaining'];	

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $expid; ?></td>

										<td><?php echo $r1['budget_header_name']; ?></td>

										<td><?php echo $allocated_amt; ?></td>

										<td><?php echo $available_amount; ?></td>

										<td><?php echo $expensed_amount; ?></td>

										<td><?php echo $nexpdt; ?></td>

										<td><?php echo $description; ?></td>

										<td><?php echo $remaining_amt; ?></td>

										

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>

										<td>

										<?php echo "<a href='dashboard.php?option=update_budget_expense&id=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?>

										</td>



										<!-- <td>

										<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>

										</td> -->

									<?php

									}

									?>

								

									</tr>

                                    <?php $sr++; } } ?>

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

 <?php include('bootstrap_datatable_javascript_library.php'); ?>