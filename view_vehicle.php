<script type="text/javascript">

function del(x)

{

	//alert(x);

	var datastring={"id":x};

	$.ajax({

		url:'delete_vehicle.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str=='true')

			{

				if(confirm('Cannot Delete Vehicle Details. Vehicle are linked with this Route.')==true)

				{

					$("#PTResults").load(location.href+" #PTResults>*","");

				}

			}

			else

			{

				if(confirm('Do you want to delete?')==true)

				{

					delet(x);

				}

			}

          

		}

		

	});

}

	function delet(id)

	{

		//alert(id);

		var datastring={"del_id":id};

	    $.ajax({

		url:'delete_vehicle.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str=="deleted Successfully")

			{

				$("#PTResults").load(location.href+" #PTResults>*","");

			}

			//alert(str);

			

          

		}

		

	});

	}

</script>

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport</a>

  <span class="breadcrumb-item active">View Vehicle</span>

</nav>

<!-- breadcrumb -->

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>	

		<div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=add_vehicle" class="btn btn-primary btn-sm">

				<i class="fa fa-plus"></i> Add Vehicle</a>

            </div>

        </div>

		<?php

		}

		?>

		

        <div class="content mt-3" style="width:1030px">

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

											<th>Vehicle Name</th>

											<th>Vehicle Type</th>

											<th>Vehicle No</th>

											<th>Chassis No</th>

											<th>Purchased Year</th>

											<th>Vehicle Status</th>

											<th>About Vehicle</th>

											<th>Previous Experience</th>

											<th>About Him/Her</th>

										

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

									$query=mysqli_query($con,"select * from vehicle where status='0' AND `session`='".$_SESSION['session']."'  ORDER BY 'modify_date' DESC "); //AND `session`='".$_SESSION['session']."'

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['vehicle_id'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res['vehicle_name']; ?></td>

										<td><?php echo $res['vehicle_type']; ?></td>

										<td><?php echo $res['vehicle_number']; ?></td>

										<td><?php echo $res['chassis_no']; ?></td>

										<td><?php echo $res['purchased_year']; ?></td>

										<td><?php echo $res['vehicle_status']; ?></td>

										<td><?php echo $res['about_vehicle']; ?></td>

										<td><?php echo $res['prev_exp']; ?></td>

										<td><?php echo $res['description']; ?></td>

										

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>	

										<td>

										<?php echo "<a href='dashboard.php?option=update_vehicle&vid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

											?>

										</td>

										

										<!-- <td>

										<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>

										</td> -->

									<?php

									}

									?>

										

									</tr>

                                    <?php $sr++; } ?>

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

								<a href="export_viewvehicle_excel.php" class="btn btn-success btn-sm">

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
					"scrollX": true,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });
</script>