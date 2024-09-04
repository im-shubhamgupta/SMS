<script type="text/javascript">

	function delet(id)

	{

		if(confirm("Do You want to delete?"))

		{

			window.location.href='delete_purge.php?x='+id;

		}

	}

</script>

<form method="post">

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <span class="breadcrumb-item active"> View Purge Data</span>

</nav>

<!-- breadcrumb -->

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

        <div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                     <a href="dashboard.php?option=add_purge_data" class="btn btn-primary btn-sm">

					  <i class="fa fa-plus"></i> Add Purge Data</a>

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

                                <strong class="card-title">View Expenses</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Purge Date</th>

											<th>Description</th>

											<th style="width:300px"> Action</th>

										</tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from purge_data where 1 and session='".$_SESSION['session']."'");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['purge_id'];

									

									$expdt = $res['purge_date'];

									$chgexdt = date("d-m-Y", strtotime($expdt));

									

									$desc = $res['description'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $chgexdt;?></td>

										<td><?php echo $desc;?></td>

																		

										<td>

										<?php echo "<a href='dashboard.php?option=update_purgedata&pid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

											?>

										

										<a href="#"	class="btn btn-danger btn-sm text-white" title="Delete" onclick="delet('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete</a>

										</td>

																

									</tr>

                                    <?php $sr++; } ?>

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