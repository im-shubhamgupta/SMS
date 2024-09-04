<script type="text/javascript">

function del(id)

	{

		if(confirm("Do You want to delete this Header???"))

		{

			window.location.href='delete_scholastic.php?x='+id;

		}

	}

</script>





 <!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <!-- <a class="breadcrumb-item" href="#">Report Card Panel</a> -->
  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">View Co-Scholastic Heading</span>

</nav>

<!-- breadcrumb -->  

<div id="right-panel" class="right-panel">     

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>		

		<div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                         <a href="dashboard.php?option=add_scholastic_header&smid=<?php echo '5';?>" class="btn btn-primary btn-sm">

						 <i class="fa fa-plus"></i>  Add Co-Scholastic Header</a>

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

                                <strong class="card-title">View Heading</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Heading Name</th>

											

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

									$query=mysqli_query($con,"select * from co_scholastic");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['scholastic_id'];

									$feename=$res['scholastic_name'];

																			

									?>

									

									<td><?php echo $sr; ?></td>

									<td><?php echo $feename; ?></td>

										

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>	

										<td>

										<?php echo "<a href='dashboard.php?option=update_scholastic_heading&id=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit' aria-hidden='true'></i> Edit</a>";

											?>

										

										<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash" aria-hidden="true"></i> Delete </a>

										

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

 <?php include('bootstrap_datatable_javascript_library.php'); ?>