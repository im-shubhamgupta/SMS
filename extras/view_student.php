<div id="right-panel" class="right-panel">
         <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                          <a href="dashboard.php?option=add_students" class="btn btn-outline-primary">Add Student</a>
            </div>
        </div>
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Student</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Register No</th>
											 <th>Student Name</th>
											 <th>Father Name</th>
											 <th>Admission Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from students where stu_status='0'");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['student_id'];
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $res['father_name']; ?></td>
										<td><?php echo $res['date']; ?></td>
										
										
										<td>
										<?php echo "<a href='dashboard.php?option=view_student_details&sid=$id' class='btn btn-outline-success btn-sm' title='View all details of student.'>View Details</a>";
											?>
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
 <?php include('bootstrap_datatable_javascript_library.php'); ?>