<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Setting Panel</a>

  <a class="breadcrumb-item" href="#">User Panel</a>

  <span class="breadcrumb-item active">View User</span>

</nav>

<!-- breadcrumb -->

         <div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                          <a href="dashboard.php?option=add_user" class="btn btn-primary btn-sm">

					 <i class="fa fa-plus"></i> Add User</a>

            </div>

        </div>

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View User</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>User Name</th>

											 <th>Designation</th>

											 <th>Email</th>

											 <th>Phone</th>
											 <th>Status</th>

											 <th>Image</th>

                                             <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from users where `roles` != 'superadmin'");

									while($res=mysqli_fetch_array($query))

									{

										$id=$res['user_id'];

										$uname=$res['username'];

										$role=$res['roles'];

										$email=$res['email'];

										$pass=$res['pass'];

										$phone=$res['phone'];
										$status=$res['status'];

										$img=$res['profile_image'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $uname; ?></td>

										<td><?php echo $role; ?></td>

										<td><?php echo $email; ?></td>

										<td><?php echo $phone ?></td>
										<td><?php if($status=='1'){
											echo "Active";
										}else{
											echo "Deactive";
										} ?></td>

										<td><img src="images/admin/<?php echo $img;?>" width="50px" height="50px"/></td>

																			

										<td>

										<?php echo "<a href='dashboard.php?option=update_user&id=$id' class='btn btn-secondary btn-sm' title='View all details of student.'><i class='fa fa-edit'></i> Edit </a>";

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