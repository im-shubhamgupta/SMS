<?php

error_reporting(1);

extract($_REQUEST);



?>

<script type="text/javascript">

function del(x)

{

	//alert(x);

	var datastring={"id":x};

	$.ajax({

		url:'delete_staff.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str=='true')

			{

				if(confirm('Cannot Delete Staff. Classes and Subjects are linked with this Staff.')==true)

				{

					$("#PTResults").load(location.href+" #PTResults>*","");

				}

			}

			else

			{

				if(confirm('Do you want to delete')==true)

				{

					delet(x,3);

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

	url:'delete_staff.php',

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

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <span class="breadcrumb-item active">View Staff</span>

</nav>



	<form method="post" enctype="multipart/form-data">

        

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

		<div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=add_staff&smid=<?php echo '15';?>" class="btn btn-primary btn-sm">

				<i class="fa fa-plus"></i> Add Staff</a>

            </div>

        </div>

		<?php

		}

		?>

		
<!-- -->
        <div class="content mt-3" style="width:1030px;" >

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               <strong class="card-title">View Staff</strong>							   

                            </div>

                            <div class="card-body">
                                <!-- <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive"> -->
                                <table id="table-grid" class="table table-striped table-bordered " >

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Name</th>

											 <th>Staff Id</th>

											 <th>Gender</th>

											 <th>Mobile No</th>

											 <th>Alt. Mobile No</th>

											 <th>Address</th>

											 <th>Qualification</th>

											 <th>Teaching Type</th>

											 <th>Teaching Type Other</th>

											 <th>Skills</th>

											 <th>Date of Joining</th>

											 <th>Designation</th>

											 <th>Message Type</th>

											 <th>Aadhar No</th>

											 <th>Caste</th>

											 <th>Edit</th>
											 <?php	if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" ){  ?>

											 <th>Delete</th>
											<?php } ?>

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from staff where status='1'");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['st_id'];

									$name=$res['staff_name'];

									$staffid=$res['staff_id'];

									$gender=$res['gender'];

									$mobno=$res['mobno'];

									$altmobno=$res['alt_mobno'];

									$add=$res['address'];

									$quali=$res['qualification'];

									$teachtype=$res['teaching_type'];

									$teachtypeother=$res['teaching_type_other'];

									$skills=$res['skills'];

									$date=$res['joining_date'];

									$joindate=date("d-M-Y", strtotime($date));

									$designation=$res['designation'];

									$msgid=$res['msg_type_id'];

									$qmsg=mysqli_query($con,"select * from message_type where msg_type_id='$msgid'");

									$rmsg=mysqli_fetch_array($qmsg);

									$msgname = $rmsg['msg_name'];

									$aadhar=$res['aadharno'];

									$caste=$res['caste'];

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo "$name"; ?></td>

										<td><?php echo "$staffid"; ?></td>

										<td><?php echo "$gender"; ?></td>

										<td><?php echo "$mobno"; ?></td>

										<td><?php echo "$altmobno"; ?></td>

										<td><?php echo "$add"; ?></td>

										<td><?php echo "$quali"; ?></td>

										<td><?php echo "$teachtype"; ?></td>

										<td><?php echo "$teachtypeother"; ?></td>

										<td><?php echo "$skills"; ?></td>

										<td><?php echo "$joindate"; ?></td>

										<td><?php echo "$designation"; ?></td>

										<td><?php echo "$msgname"; ?></td>

										<td><?php echo "$aadhar"; ?></td>

										<td><?php echo "$caste"; ?></td>

										<td><?php echo "<a href='dashboard.php?option=update_staff&id=$id&smid=16' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

										?></td>
								<?php	if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" ){  ?>
										<td>

										<a href="#" title="All Data will be Deleted from floor and Block." class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>

										</td>
								<?php } ?>		

									</tr>

                                    <?php $sr++; } ?>

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

								<a href="export_viewstaff_excel.php" class="btn btn-success btn-sm">

								<i class="fa fa-download"></i> Download To Excel</a>

							</div>	

								

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

	<!--	

		<div style="text-align:center">

		

		<a href="export_viewstudents_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success" style="margin-left:20px;">Download To Excel</a>

		

		<a href="dashboard.php?option=view_students" class="btn btn-primary" style="margin-left:20px;">Back</a>

			

		</div>-->

		

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <?php
 include('datatable_links.php'); ?>

	<script>
	 $(document).ready(function(){
			var dataTable = $("#table-grid").DataTable({
                    // "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // //'order':[7,'ASC'],
                    // dom: 'Blfrtip',
					"scrollX": true,
                    "pageLength":25,
					buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
				});
			});
	</script>		

                 