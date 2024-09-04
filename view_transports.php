<script type="text/javascript">

function del(x)

{

	//alert(x);

	var datastring={"id":x};

	$.ajax({

		url:'delete_transports.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str=='true')

			{

				if(confirm('Cannot Delete Route. Students are linked with this Route.')==true)

				{

					$("#PTResults").load(location.href+" #PTResults>*","");

				}

			}

			else

			{

				if(confirm('Do you want to delete the Route?')==true)

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

		url:'delete_transports.php',

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

  <a class="breadcrumb-item" href="#">Route</a>

  <span class="breadcrumb-item active">View Route</span>

</nav>

<!-- breadcrumb -->

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>	

		<div class="breadcrumbs" style="width:1020px">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=add_transports" class="btn btn-primary btn-sm">

				<i class="fa fa-plus"></i> Add Route</a>

            </div>

        </div>

		<?php

		}

		?>

		

        <div class="content mt-3" style="width:1020px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Transport</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

											<th>Route Name</th>

											<th>Transportation Price</th>

											

										<?php

										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

										{

										?>		

                                            <th>Action</th>

										<?php

										}

										?>		

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;
											
									$query=mysqli_query($con,"select * from transports where 1 and session='".$_SESSION['session']."'");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['trans_id'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res['route_name']; ?></td>

										<td><?php echo "Rs: ".$res['price'] ?></td>

										

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>	

										<td>

										<?php echo "<a href='dashboard.php?option=update_transports&tid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

											?>

										

										<!-- <a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a> -->

					

										</td>

									<?php

									}

									?>		

										

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