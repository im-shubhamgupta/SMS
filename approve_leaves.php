<?php

error_reporting(1);

extract($_REQUEST);



?>



<div id="right-panel" class="right-panel">



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Student Panel</a>

  <a class="breadcrumb-item" href="#"> Leave Management</a>

  <span class="breadcrumb-item active"> Approve Leave</span>

</nav>



	<form method="post" enctype="multipart/form-data">

		

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               <strong class="card-title">View Leave Request</strong>					   

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

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

											 <th>Attachments</th>

											 <th>Approve</th>

											 <th>Disapprove</th>

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

 <!-- <?php //include('bootstrap_datatable_javascript_library.php'); ?> -->
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

	                // reference_no : $("#reference_no").val(),
	                // admission_grade : $("#admission_grade").val(),
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
						'url' :"approve_leaves_table_data.php", // json datasource
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
			// $('#reference_no').on( "keyup", function() {
			//     $('#table-grid').DataTable().ajax.reload();
			// });
		
			});

</script>
<script type="text/javascript">

	function decline(id){

		if(confirm("Are you sure want to Decline")){
			 
			var	datastring='stu_leave_id='+ id +'&reject_student_leave='+ 1 ; 
	           
	        $.ajax({              	
	 		    type: "POST",    
	 		    url : 'Controllers/StudentControllers.php', 
	 		    data : datastring,
	 		    // contentType: false,   
		    	// cache: false,    
		    	// processData:false, 
		    	success: function (responce) {  
			    	var responce = JSON.parse(responce);	
	 		    	    if(responce.type=='success') { 
	 		    	        toastr.success(responce.msg);	 
	 		    	    	setInterval(function(){
	 		    	    	
	 		    	    
	 		    	    	window.location.reload();
	 		    	    		},4000);		
	 		    	    	
	 		    	    }else{      
	 		    	    	// $('#registration_btn').attr('disabled',false);
	 		    	    	// $('#error').html(responce.msg);
	 		    	    	toastr.error("Somethings is Wrong, Please try Again");			
	 		    	    }
	 		  	    }	
	 		  	});
	 	

			return true;

		}else{	

		return false;

		}

	}
	function Approve(id){
		if(confirm("Do you want to Approve")){
		// var id=id;	
		 
		var	datastring='stu_leave_id='+ id +'&approve_student_leave='+ 1 ; 
		// alert(datastring);
           
        $.ajax({              	
 		    type: "POST",    
 		    url : 'Controllers/StudentControllers.php', 
 		    data : datastring,
 		    // contentType: false,   
	    	cache: false,    
	    	// processData:false, 
	    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.type=='success') {  
 		    	    	 // $('#registration_btn').attr('disabled',false);
 		     		  	 // $('#error').html(""); 
 		    	    	toastr.success(responce.msg);		
 		    	    	setInterval(function(){
	 		    	    	
	 		    	    
	 		    	    	window.location.reload();
	 		    	    		},4000);
 		    	    }else{      
 		    	    	// $('#registration_btn').attr('disabled',false);
 		    	    	// $('#error').html(responce.msg);
 		    	    	toastr.error("Somethings is Wrong, Please try Again");			
 		    	    }
 		  	    }	
 		  	});
 	
 		
		}else{
			return false;
		}

	}

</script>
<!-- 
 <tbody>

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from student_leave where status='0'");

									while($res=mysqli_fetch_array($query))

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

									

									$reason=$res['reason'];

									$image=$res['attachment'];

									$aprvstatus = $res['status'];									

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

										<td><?php echo $reason;?></td>

										<td><?php echo $res['note'];?></td>

										<td><a href="images/leave/<?php echo $stuid;?>/<?php echo $image;?>" target="blank">

										<img src="images/leave/<?php echo $stuid;?>/<?php echo $image;?>" 

										style="width:100px;height:80px;"></td>

										

										<td>
 -->
									<!-- 	<a onclick="return confirm('Do you want to Approve the leave.')" href="dashboard.php?option=update_leave_approve&id=<?php echo $id;?>&stuid=<?php echo $stuid;?>&reason=<?php echo $reason;?>&fromdate=<?php echo $fdate;?>&todate=<?php echo $totdate;?>" class="btn btn-success" style="width:100px;border-radius:20px">Approve</a>

										</td>



										<td>

										<a onclick="return confirm('Do you want to Disapprove the leave.')" href="dashboard.php?option=update_leave_disapprove&id=<?php echo $id;?>&stuid=<?php echo $stuid;?>&reason=<?php echo $reason;?>&fromdate=<?php echo $fdate;?>&todate=<?php echo $totdate;?>" class="btn btn-danger" style="width:100px;border-radius:20px">Disapprove</a>

										</td>

										 -->

										

										

									<!--	

										<td>

									<?php if($aprvstatus==1 || $aprvstatus==2){

												?>

												

												<a onclick="return false"><button type="button" class="btn btn-secondary" style="width:100px;border-radius:20px" >Approve</button></a>

											<?php } else { ?>

											

												<a onclick="return confirm('Do you want to Approve the leave.')" href="dashboard.php?option=update_leave_approve&id=<?php echo $id;?>&stuid=<?php echo $stuid;?>&reason=<?php echo $reason;?>&fromdate=<?php echo $fdate;?>&todate=<?php echo $totdate;?>" class="btn btn-success" style="width:100px;border-radius:20px">Approve</a>

													

											<?php } ?>

										</td>

										

										<td>

											<?php if($aprvstatus==0){

												?>

													<a onclick="return false" href='dashboard.php?option=update_leave_disapprove&id=<?php echo $id;?>'><button type="button" class="btn btn-secondary" style="width:100px;border-radius:20px">Disapprove</button></a>

											<?php } else { ?>

											

													<a onclick="return confirm('Do you want to Disapprove the leave.')" href="dashboard.php?option=update_leave_disapprove&id=<?php echo $id;?>&stuid=<?php echo $stuid;?>&reason=<?php echo $reason;?>&fromdate=<?php echo $fdate;?>&todate=<?php echo $totdate;?>" class="btn btn-danger" style="width:100px;border-radius:20px">Disapprove</a>

													

													

											<?php } ?>

										</td>

									-->	

										
<!-- 
									</tr>

                                    <?php $sr++; } ?>

                                    </tbody> -->