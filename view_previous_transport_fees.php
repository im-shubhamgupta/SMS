<script type="text/javascript">

/*function del(x)

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

	}*/

</script>

<div id="right-panel" class="right-panel">

        <!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#"> Previous Transport Fees</a>

  <span class="breadcrumb-item active"> View Previous Transport Fees</span>

</nav>



<div class="breadcrumbs" style="width:1000px">

	<div class="col-sm-4" style="padding:10px;">  

		<a href="dashboard.php?option=create_previous_transport_fees" class="btn btn-primary"> <i class="fa fa-plus"></i> Create Previous Transport Fees</a>

	</div>

</div>

		

        <div class="content mt-3" style="width:1020px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Previous Transport Fees</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                           <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Student Name</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Previous Transport Fees Due</th>

											 <th>Remark</th>

										

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$que = mysqli_query($con,"select * from previous_transport_fees where session='".$_SESSION['session']."' order by modify_date desc");

									while($res=mysqli_fetch_array($que))

									{

									$id=$res['prev_trans_fee_id'];

									

									$stuid=$res['student_id'];

									// $q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."' ");
									$q1=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'") ;


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

									

									$pretransfees=$res['previous_transport_fees'];

									$remark=$res['remarks'];

												

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $fathername; ?></td>

										<td><?php echo $clsname;?></td>

										<td><?php echo $secname;?></td>

										<td><?php echo $pretransfees;?></td>

										<td><?php echo $remark;?></td>

										

										

																				

									</tr>

                                    <?php $sr++; } } ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

 <!-- <?php //include('bootstrap_datatable_javascript_library.php'); ?> -->
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