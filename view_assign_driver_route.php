

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport</a>

  <span class="breadcrumb-item active">View Assigned Driver & Vehicle to Route</span>

</nav>

<!-- breadcrumb -->

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>	

		<div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=assign_driver_route" class="btn btn-primary btn-sm">

				<i class="fa fa-plus"></i> Assign Driver to Route</a>

            </div>

        </div>

		<?php

		}

		?>

		

        <div class="content mt-3" style="width:900px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Vehicle</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

											<th>Driver Name</th>

											<th>Vehicle Name</th>

											<th>Vehicle Number</th>

											<th>Route</th>

											<th>Description</th>

										<?php

										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

										{

										?>		

                                            <th>Edit</th>

                                            <th>Delete</th>

										<?php

										}

										?>	

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from assign_driver_route where status='0' and session='".$_SESSION['session']."'");

									while($res=mysqli_fetch_array($query))

									{

										// print_r($res);
									$id=$res['assign_id'];

									$driverid=$res['driver_id'];

									$q1 = mysqli_query($con,"select * from driver where id='$driverid'");

									$r1 = mysqli_fetch_array($q1);

									

									$vehicleid=$res['vehicle_id'];

									$q2 = mysqli_query($con,"select * from vehicle where vehicle_id='$vehicleid'");

									$r2 = mysqli_fetch_array($q2);
										// print_r($r2)."<br>";
									

									$routeid=$res['route_id'];

									$q3 = mysqli_query($con,"select * from transports where trans_id='$routeid' ");

									$r3 = mysqli_fetch_array($q3);

									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $r1['name']; ?></td>

										<td><?php echo $r2['vehicle_name']; ?></td>

										<td><?php echo $r2['vehicle_number']; ?></td>

										<td><?php echo $r3['route_name']; ?></td>

										<td><?php echo $res['description']; ?></td>

										

									

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>	

										<td>

										<?php echo "<a href='dashboard.php?option=update_assign_driver_route&aid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?>

										</td>

										

										<td>

										<a onclick="return confirm('Do you want to Delete.')" href="dashboard.php?option=delete_assigned_driver&id=<?php echo $id;?>" class="btn btn-danger btn-sm text-white"> <i class="fa fa-trash"></i> Delete

										</td>

									<?php

									}

									?>	

										

									</tr>

                                    <?php $sr++; } ?>

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

								<a href="export_assign_driver_excel.php" class="btn btn-success btn-sm">

								<i class="fa fa-download"></i> Download To Excel</a>

							</div>

							

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

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