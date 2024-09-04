<?php

error_reporting(1);

// extract($_REQUEST);



// if(isset($search))

// {

// 	if($lstatus=="All")

// 	{

// 		if($class!="" and $section!="" and $student!="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && section_id='$section' && student_id='$student'";

// 		$search_result = filterTable($query);

// 		}

// 		else if($class!="" and $section!="" and $student=="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && section_id='$section'";

// 		$search_result = filterTable($query);	

// 		}

// 		else if($class!="" and $section=="" and $student=="")

// 		{

// 		$query="select * from student_leave where class_id='$class'";

// 		$search_result = filterTable($query);	

// 		}

// 		else if($class=="" and $section=="" and $student=="")

// 		{

// 		$query="select * from student_leave";

// 		$search_result = filterTable($query);	

// 		}

// 	}

// 	else if($lstatus=="Approve")

// 	{

// 		if($class!="" and $section!="" and $student!="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && section_id='$section' && student_id='$student' && status=1";

// 		$search_result = filterTable($query);

// 		}

// 		else if($class!="" and $section!="" and $student=="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && section_id='$section' && status=1";

// 		$search_result = filterTable($query);	

// 		}

// 		else if($class!="" and $section=="" and $student=="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && status=1";

// 		$search_result = filterTable($query);	

// 		}

// 		else if($class=="" and $section=="" and $student=="")

// 		{

// 		$query="select * from student_leave where status=1";

// 		$search_result = filterTable($query);	

// 		}

// 	}

// 	else if($lstatus=="Disapprove")

// 	{

// 		if($class!="" and $section!="" and $student!="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && section_id='$section' && student_id='$student' && status=2";

// 		$search_result = filterTable($query);

// 		}

// 		else if($class!="" and $section!="" and $student=="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && section_id='$section' && status=2";

// 		$search_result = filterTable($query);	

// 		}

// 		else if($class!="" and $section=="" and $student=="")

// 		{

// 		$query="select * from student_leave where class_id='$class' && status=2";

// 		$search_result = filterTable($query);	

// 		}

// 		else if($class=="" and $section=="" and $student=="")

// 		{

// 		$query="select * from student_leave where status=2";

// 		$search_result = filterTable($query);	

// 		}

// 	}

// }





// // function to connect and execute the query

// function filterTable($query)

// {

// 	include('connection.php');

// 	$filter_Result = mysqli_query($con, $query);

// 	return $filter_Result;

// }	

	

?>





<div id="right-panel" class="right-panel">



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Student Panel</a>

  <a class="breadcrumb-item" href="#"> Leave Management</a>

  <span class="breadcrumb-item active"> View Leave Report</span>

</nav>



	<form method="post" action="dashboard.php?option=view_leave_report" enctype="multipart/form-data">

		

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-40px;margin-top:-10px">

							<select name="class" id="class_id" class="form-control" onchange="searchstudent(this.value);search_sec(this.value)" style="width:175px;" autofocus >

							<!-- <option value="" selected="selected" disabled>Select Class</option> -->

							<option value="" selected="selected">All</option>

							<?php

							$scls = "select * from class";

							$rcls = mysqli_query($con, $scls);

							while( $rescls = mysqli_fetch_array($rcls) ) {

							?>

							<!-- <option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?> -->
							<option  value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

							

							<div class="col-md-2" style="margin-left:60px;">Section </div>

							<div class="col-md-2" style="margin-left:-60px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" onchange="searchstudent(this.value)"   style="width:175px;" autofocus >

							<!-- <option value="" selected="selected" disabled>Select Section</option> -->

							<option value="" selected="selected">All</option>

							<?php

							// $qsec=mysqli_query($con,"select * from section where class_id='$class'");

							// while($rsec=mysqli_fetch_array($qsec))

							// {

							// $secname=$rsec['section_name'];

							?>

							<!-- <option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

							</option> -->

							<?php 

							// }

							?>							

							</select>	

													

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_section_withall_report.php?cls_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>

							</div>

							

							<script>

							function searchstudent(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_student_leave.php?sec_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("student").innerHTML=xmlhttp.responseText;

							}

							}

							}

							</script>

						</div><br>

						

												

                        <div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="margin-left:20px;">Leave Status</div>

							<div class="col-md-2" style="margin-left:-40px;margin-top:-10px;">

							<select class="form-control" id="leave_status" name="lstatus" style="width:175px;" autofocus >

							<!-- <option value="" selected="selected" disabled>Select Status</option> -->

							<option  value="">All</option>					

							<option value="1">Approve</option>	

							<option  value="2">Dicline</option>					

							</select>

							</div>	



							<div class="col-md-2" style="margin-left:60px;">Student Name </div>

							<div class="col-md-2" style="margin-left:-60px;margin-top:-10px">

							<select class="form-control" name="student" id="student" style="width:175px;">

							<option value="" selected="selected">All</option>

							<?php

							// $qstu=mysqli_query($con,"select * from students where student_id='$student'");

							// while($rstu=mysqli_fetch_array($qstu))

							// {

							// ?>

						    <!-- <option  value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>

							// </option> -->
							 <!-- <option value=''>All Students</option> -->

							 <?php 

							// }

							// ?>							

							</select>	

							</div>								

							

							<div class="col-md-2">

							<input type="submit" id="search" name="search" class="btn btn-primary btn-sm" style="margin-top:-80px;margin-left:40px;width:120px;" value="search"><br><br>

							</div>

							

						</div><br>

					

					

                        <div class="card">

                            <div class="card-body">
                            	<!-- table-responsive -->
                                <table id="table-grid" class="table table-striped table-bordered ">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Register No</th>

											 <th>Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Leave</th>

											 <th>Submitted Date</th>

											 <th>From Date</th>

											 <th>To Date</th>

											 <th>No of Days</th>

											 <th>Reason</th>

											 <th>Note</th>

											 <th>Status</th>

											 <th>Comment</th>

										</tr>

                                    </thead>

                                    
                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		

	</form>

</div><!-- /#right-panel -->

 <!-- <?php// include('bootstrap_datatable_javascript_library.php'); ?> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
 <?php include('datatable_links.php'); ?>


 <script>
 				
$(document).ready(function(){
	toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	

		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "4000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};	

 			function custom_params() {
                let new_form_data = {

	                class_id : $("#class_id").val(),
	                section_id : $("#search_sect").val(),
	                leave_status : $("#leave_status").val(),
	                student_id : $("#student").val(),
		            }	    
	            return new_form_data;
	            }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100,500, 1000,999999999999], [10, 25, 50, 100,500,1000,'All']],	
                    'order':[13,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
					"processing": true,
					"serverSide": true,
                    "scrollX": true,
                    // "searching":false,
					"ajax":{
						'url' :"view_leave_report_table_data.php", // json datasource
						'type': "post",  // method  , by default get
						'data': function(d){
						// ClassType: classtype,
                        d.custom = custom_params() 

						},
						error: function(response){  // error handling
							$(".grid-error").html("");
							$("#grid").append('<tbody class="grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#grid_processing").css("display","none");
							
						}
						
					}
			});
			$('#search').on("click", function(e){
				e.preventDefault();

			    $('#table-grid').DataTable().ajax.reload();
			});
		
			});

</script>

<!-- <tbody>

									<?php 

									$sr=1;
									if($search_result){
									while($res=mysqli_fetch_array($search_result))

									{

									$id=$res['stu_leave_id'];

									$stuid=$res['student_id'];

									$qstu=mysqli_query($con,"select * from students where student_id='$stuid'");

									$rstu=mysqli_fetch_array($qstu);

									

									$clid=$res['class_id'];

									$quec=mysqli_query($con,"select * from class where class_id='$clid'");

									$resc=mysqli_fetch_array($quec);

									

									$seid=$res['section_id'];

									$qse=mysqli_query($con,"select * from section where section_id='$seid'");

									$rsec=mysqli_fetch_array($qse);

									

									$lid=$res['leave_id'];

									$qlv=mysqli_query($con,"select * from leave_type where leave_id='$lid'");

									$rqlv=mysqli_fetch_array($qlv);

									

									$submitdate=$res['submission_date'];

									$nsubmitdate = date("d-m-Y",strtotime($submitdate));

									

									$fdate=$res['from_date'];

									$nfdate = date("d-m-Y",strtotime($fdate));

									

									$totdate=$res['to_date'];

									$ntotdate = date("d-m-Y",strtotime($totdate));

									

									$image=$res['attachment'];

									$aprvstatus = $res['status'];	

									if($aprvstatus==1)

									{

										$status = "Approve";

										$comment = "Ok";

									}

									else if($aprvstatus==2)

									{

										$status = "Disapprove";

										$comment = "Not Approved";

									}

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $rstu['register_no']; ?></td>

										<td><?php echo $rstu['student_name']; ?></td>

										<td><?php echo $resc['class_name'];?></td>

										<td><?php echo $rsec['section_name'];?></td>

										<td><?php echo $rqlv['leave_name'];?></td>

										<td><?php echo $nsubmitdate;?></td>

										<td><?php echo $nfdate;?></td>

										<td><?php echo $ntotdate;?></td>

										<td><?php echo $res['total_days'];?></td>

										<td><?php echo $res['reason'];?></td>

										<td><?php echo $res['note'];?></td>

										<td><?php echo $status;?></td>

										<td><?php echo $comment;?></td>

										

									</tr>

                                    <?php $sr++; }  }?>

                                    </tbody>
 -->