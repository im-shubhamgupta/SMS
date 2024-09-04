<script type="text/javascript">

	function delet(id)

	{

		if(confirm("Do You want to delete this Subject???"))

		{

			window.location.href='delete_subject.php?x='+id;

		}

	}

</script>

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Subject Assignment</a>

  <span class="breadcrumb-item active">View Subject</span>

</nav>

<!-- breadcrumb -->



		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>
<!-- style="width:1020px" -->
        <div class="breadcrumbs" >

            <div class="col-sm-4" style="padding:10px;">  

				<a href="dashboard.php?option=add_subject" class="btn btn-primary btn-sm">

					 <i class="fa fa-plus"></i> Add Subject</a>

            </div>

        </div>

		<?php

		}

		?>			

		
<!--  -->
        <div class="content mt-3" style="width:1020px" >

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Section</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Class</th>

											 <th>Subject</th>

											 

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

                                    <tbody>

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from subject");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['subject_id'];

									$subname=$res['subject_name'];

									$class_id=$res['class_id'];									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

									

									<?php 

									$re=mysqli_query($con,"select * from class where class_id='$class_id'");

									$result=mysqli_fetch_array($re);

									?>	

										<td><?php echo $result['class_name']; ?></td>

										<td><?php echo $subname; ?></td>

										

										

								<?php

								if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

								{

								?>			

										<td>

										<?php echo "<a href='dashboard.php?option=update_subject&sid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

											?>

										

										<a href="#" title="All Data will be Deleted from floor and Block." class="btn btn-danger btn-sm text-white" onclick="delet('<?php echo $id;?>')">  <i class="fa fa-trash"></i> Delete </a>

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

 <?php// include('bootstrap_datatable_javascript_library.php'); ?>
 <?php include('datatable_links.php'); ?>
<script>


 var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // 'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });

</script>                    