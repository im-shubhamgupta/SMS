<script type="text/javascript">

function del(id)

{

	if(confirm("Do You want to Delete"))

	{

		window.location.href='delete_group.php?x='+id;

	}

}

	

</script>

<form method="post">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">custom Group</a>

  <span class="breadcrumb-item active">View Group</span>

</nav>

<!-- breadcrumb -->

<div id="right-panel" class="right-panel">

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

        <div class="breadcrumbs" style="width:800px">

            <div class="col-sm-4" style="padding:10px;">  

                     <a href="dashboard.php?option=create_group" class="btn btn-primary btn-sm">

					 <i class="fa fa-plus"></i> Create Group</a>

            </div>

        </div>

		<?php

		}

		?>	



        <div class="content mt-3" style="width:800px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Group</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Group</th>

											<th>Action</th>

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from custome_group");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['group_id'];

									$name=$res['group_name'];	

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $name; ?></td>

										

									<td>

									<?php echo "<a href='dashboard.php?option=updategroup&id=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?>

										

									<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"><i class="fa fa-trash"></i> Delete </a>

									</td>

										

									</tr>

                                    <?php 

									$sr++; 

									} ?>

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