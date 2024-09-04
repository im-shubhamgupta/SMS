<script type="text/javascript">

function del(x)

{

	//alert(x);

	var datastring={"id":x};

	$.ajax({

		url:'delete_student_route.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str=='true')

			{

				if(confirm('Cannot Delete Route.')==true)

				{

					$("#PTResults").load(location.href+" #PTResults>*","");

				}

			}

			else

			{

				if(confirm('Do you want to delete')==true)

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

		url:'delete_student_route.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str==1)

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

  <a class="breadcrumb-item" href="#">Accounts Panel</a>

  <a class="breadcrumb-item" href="#"> Previous Fees</a>

  <span class="breadcrumb-item active"> View Previous Fees</span>

</nav>
<style>
	table#bootstrap-data-table-export {
    display: block;
    overflow-x: auto;
    }
</style>


<div class="breadcrumbs" style="width:1000px">

	<div class="col-sm-4" style="padding:10px;">  

		<a href="dashboard.php?option=create_previous_fees&smid=<?php echo '34';?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Create Previous Fees</a>

	</div>

</div>

		

        <div class="content mt-3" style="width:1020px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Previous Fees Balance</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                           <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Student Name</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Roll no.</th>

											 <th>Previous Fees Due</th>

											 <th>Remark</th>

										<?php

																				

										$qa = mysqli_query($con,"select * from superadmin_authority where id='1'");

										$ra = mysqli_fetch_array($qa);

										$status = $ra['status'];

										

										if($status == 1)

										{

										?>

											 

											 <th>Edit</th>

											 <th>Delete</th>

										<?php

										}

										?>										

											

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$que = mysqli_query($con,"select * from previous_fees where 1 and session='".$_SESSION['session']."' ");//order by prev_fee_id desc

									while($res=mysqli_fetch_array($que))

									{

									$id=$res['prev_fee_id'];
									// $id=$sr;

									

									$stuid=$res['student_id'];

									// $q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."'");
									$q1=mysqli_query($con,"select `student_name`,`register_no`,`father_name`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`roll_no` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
									if(mysqli_num_rows($q1)>0){

									$r1 = mysqli_fetch_array($q1);

									$stuname = $r1['student_name'];

									$regno = $r1['register_no'];

									$fathername = $r1['father_name'];

									

									$clsid=$res['class_id'];

									$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

									$r2 = mysqli_fetch_array($q2);

									$clsname = $r2['class_name']; 

									

									$secid=$res['section_id'];

									$q2 = mysqli_query($con,"select * from section where section_id='$secid'");

									$r2 = mysqli_fetch_array($q2);

									$secname = $r2['section_name'];

									

									$prefees=$res['previous_fees'];

									$remark=$res['remarks'];

												

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $fathername; ?></td>

										<td><?php echo $clsname;?></td>

										<td><?php echo $secname;?></td>
										<td><?= ($r1['roll_no']) ? $r1['roll_no'] : '0' ; ?></td>

										<td><?php echo $prefees;?></td>

										<td><?php echo $remark;?></td>

										

										<?php

										if($status == 1)

										{

										?>

										<td><?php echo "<a href='dashboard.php?option=edit_prev_fees&id=$id&smid=35' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>"?></td>

										<td><a onclick="return confirm('Do you want to Delete.')" href="dashboard.php?option=delete_prev_fees&id=<?php echo $id;?>&smid=<?php echo '36';?>" class="btn btn-danger btn-sm text-white"> <i class="fa fa-trash"></i> Delete</a>

										</td>

										<?php

										}

										?>

																				

									</tr>

                                    <?php $sr++; } }?>

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
	 $(document).ready(function(){
 			
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // 'order':[4,'DESC'],
                    order: [[ 6, 'asc' ], [0 , 'asc' ]],
                    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
					$("td:first", nRow).html(iDisplayIndex +1);
					return nRow;
					},
                    dom: 'Blfrtip',
                    "scrollX":true,
                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    // "columnDefs": [ { orderable: false, targets: [0] }]
                });
                });
</script>