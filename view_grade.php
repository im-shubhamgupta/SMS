<script type="text/javascript">

	function del(id)

	{

		if(confirm("Do You want to delete this Grade???"))

		{

			window.location.href='delete_grade.php?x='+id;

		}

	}

</script>

<form method="post">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">View Grade

  </span>

</nav>

<!-- breadcrumb -->

<div id="right-panel" class="right-panel">

	<div class="breadcrumbs container-fluid">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=assign_grade" class="btn btn-primary btn-sm" id="assign_grade">

				<i class="fa fa-plus"></i>Assign Grade</a>

            </div>

        </div>



        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Grade</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Grade Name</th>

                                            <th>Min Marks</th>

                                            <th>Max Marks</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from grade");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['grade_id'];

									$name=$res['grade_name'];	

									$con1=$res['condition1'];	

									$con2=$res['condition2'];	

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $name; ?></td>

										<td><?php echo $con1; ?></td>

										<td><?php echo $con2; ?></td>

										<td>

									<?php echo "<a href='dashboard.php?option=update_grade&gid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?>

										

									<a  title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"><i class="fa fa-trash"></i> Delete </a>

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