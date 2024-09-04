<?php

error_reporting(1);

extract($_REQUEST);



?>





<div id="right-panel" class="right-panel">



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <span class="breadcrumb-item active"> View Assign Class Teacher</span>

</nav>



	<form method="post" enctype="multipart/form-data">

		

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

					

                        <div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Teacher</th>

											 <th colspan="2" class="text-center">Action</th>

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from assign_clsteacher");		

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['assign_clst_id'];

																		

									$clid=$res['class_id'];

									$quec=mysqli_query($con,"select * from class where class_id='$clid'");

									$resc=mysqli_fetch_array($quec);

									$clsname=$resc['class_name']; 

									

									$seid=$res['section_id'];

									$qse=mysqli_query($con,"select * from section where section_id='$seid'");

									$rsec=mysqli_fetch_array($qse);

									$secname=$rsec['section_name'];

									

									$stid=$res['st_id'];

									$qst=mysqli_query($con,"select * from staff where st_id='$stid'");

									$rst=mysqli_fetch_array($qst);

									$staffname=$rst['staff_name'];

																		

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $clsname;?></td>

										<td><?php echo $secname;?></td>

										<td><?php echo $staffname;?></td>

										<td><?php echo "<a href='dashboard.php?option=edit_assigned_classteacher&id=$id&smid=20' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>"?></td>

										<td><a onclick="return confirm('Do you want to Delete.')" href="dashboard.php?option=delete_assigned_classteacher&id=<?php echo $id;?>" class="btn btn-danger btn-sm text-white"> <i class="fa fa-trash"></i> Delete</a>

										</td>

									</tr>

                                    <?php $sr++; } ?>

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

							<a href="export_view_assign_classteacher_excel.php" 

							class="btn btn-success btn-sm" style="margin-right:30px"> <i class="fa fa-download"> </i> Download To Excel</a>

							

							<a href="print_view_assign_classteacher.php" target="_blank" 

							class="btn btn-primary btn-sm" style="margin-right:30px;"><i class="fa fa-print"></i> Print</a>

							</div>

							

                        </div>

                    </div>

				

					

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>