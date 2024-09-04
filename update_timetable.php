<?php

error_reporting(1);

extract($_REQUEST);



// if(isset($save))

// {

	

// 	$id = $_REQUEST['id'];

// 	$endperiod = $_REQUEST['endperiod'];

// 	$subject = $_REQUEST['subject'];

// 	$teacher = $_REQUEST['teacher'];

	

// 	$count = sizeof($id);

	

// 	for($i=0; $i<$count; $i++)

// 	{

// 		$nid = $id[$i];

// 		$nstperiod = $stperiod[$i];

// 		$nendperiod = $endperiod[$i];

// 		$nsubject = $subject[$i];

// 		$nteacher = $teacher[$i];

		

// 		$q1=mysqli_query($con,"update time_table set start_period='$nstperiod', end_period='$nendperiod', 

// 		subject_id='$nsubject', staff_id='$nteacher' where tt_id='$nid'");



	

// 	}

// 		echo "<script>window.location='dashboard.php?option=update_timetable'</script>";

// }



?>



	<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}



	</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb" style="width:1000px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Time Table</a>

  <span class="breadcrumb-item active">Update Time Table</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=update_timetable" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

													

							<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">Class : </div>

							<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

							<select style="width:150px;" name="class" id="class" class="form-control" 

							onchange="search_sec(this.value);" required autofocus>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = mysqli_query($con,"select * from class");

							while( $rcls = mysqli_fetch_array($scls) ) {

							?>

							<option <?php if($class==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

							

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_section_withoutall.php?cls_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("sectionid").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>



						<div class="col-md-2" style="margin-left:50px;">Section : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-60px;">

						<select style="width:150px;" name="sectionid" id="sectionid" class="form-control" required autofocus>
							<!-- onchange="searchstudent(this.value);"  -->

						<option value="" selected="selected" disabled>Select Section</option>							

						<?php

						$qsec=mysqli_query($con,"select * from section where class_id='$class'");

						while($rsec=mysqli_fetch_array($qsec))

						{

						?>

						<option <?php if($sectionid==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

						</option>

						<?php 

						}

						?>	

						</select>

						</div>

																		

						</div><br>

                     

						<div class="row" style="margin-top:20px;">

						<div class="col-md-2" style="margin-left:50px;">Select Day : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

						<select style="width:150px;" name="cday" id="cday" class="form-control" 

						required autofocus>

						<option value="" selected="selected" disabled>Select Day</option>

						<?php

						$sday = mysqli_query($con,"select * from days");

						while( $rday = mysqli_fetch_array($sday) ) {

						?>

						<option <?php if($cday==$rday['day_id']){echo "selected";}?> value="<?php echo $rday['day_id']; ?>"><?php echo $rday['day_name']; ?>

						</option>

						<?php } ?>							

						</select>

						</div>

						

						<div class="col-md-2" style="margin-top:-8px;">

						<input type="submit" name="load" value="Load" class="btn btn-primary btn-sm" style="margin-left:100px;width:100px;">

						</div>														

						</div><br>	



						</div><br>	

												

						<!--table starts from here-->

						<?php 

						if(isset($load))

						{

							$que = mysqli_query($con,"select * from time_table where class_id='$class' && 

							section_id='$sectionid' && day='$cday'");

							$row = mysqli_num_rows($que);

							if($row)

							{

											

						?>		

						<div class="card" style="width:950px">

                            <div class="card-body">

                                <table class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Period</th>

											 <th>Start Period</th>

											 <th>End Period</th>

											 <th>Subject</th>

											 <th>Teacher</th>

											 

										</tr>

                                    </thead>

                                    <tbody>

										

											<?php

											while($res = mysqli_fetch_array($que))

											{

											$ttid = $res['tt_id'];

											$period = $res['period'];

											

											$stperiod = $res['start_period'];

																						

											$endperiod = $res['end_period'];

											

											$subid = $res['subject_id'];

											$staffid = $res['staff_id'];	

											

											?>

											<tr>

											<input type="hidden" name="id[]" value="<?php echo $ttid;?>"/>

											

											<td><?php echo $period;?></td>

											

											<td><input type="time" name="stperiod[]" value="<?php echo $stperiod;?>" class="form-control" style="width:150px"/></td>

											<td><input type="time" name="endperiod[]" value="<?php echo $endperiod;?>" class="form-control" style="width:150px"/></td>

											

											<td>

											<select name="subject[]" class="form-control" style="width:150px;">

											<option value="" selected="selected" Disabled>Select Subject</option>

											<option <?php if($subid == "Lunch"){echo "selected";}?> value="Lunch" >Lunch</option>

											<option <?php if($subid == "Break"){echo "selected";}?> value="Break" >Break</option>

											<?php

											$qu=mysqli_query($con,"select * from subject where class_id='$class'");

											while($re=mysqli_fetch_array($qu))

											{										

											?>

											<option <?php if($subid==$re['subject_id']){echo "selected";}?> value="<?php echo $re['subject_id']; ?>"><?php echo $re['subject_name'];?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											<td>

											<select name="teacher[]" class="form-control" style="width:150px;">

											<option value="" selected="selected" Disabled>Select Teacher</option>

											<option <?php if($staffid == "Lunch"){echo "selected";}?> value="Lunch" >Lunch</option>

											<option <?php if($staffid == "Break"){echo "selected";}?> value="Break" >Break</option>

											<?php

											$qu=mysqli_query($con,"select * from staff");

											while($re=mysqli_fetch_array($qu))

											{

											?>

											<option <?php if($staffid==$re['st_id']){echo "selected";}?> value="<?php echo $re['st_id']; ?>"><?php echo $re['staff_name'];?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											</tr>

											<?php

											}

											?>



											

                                    </tbody>

                                </table>

                            </div>

                        </div><br><br>

						

						<div style="text-align:center">

						<input type="button" name="save" value="Update" id="update_btn" class="btn btn-primary btn-sm" style="margin-left:350px;"/>

						

						<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm" style="margin-left:20px;"/>

						

						</div>

						<?php

							}

							else

							{

								echo "<script>alert('Time Table Not Scheduled.')</script>";

							}

						}

						?>				



						

                </div>

            </div>

        </div><!-- .animated -->

        

		

		

		

		

	</form>	

    </div>



 <?php include('bootstrap_datatable_javascript_library.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
 <script>$(document).ready(function(){	
 	toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	

		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "3000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					}); 

  $(document).ready(function(){	


   $('#update_btn').on('click',function(e){	
   	// $('#Attendance-form').preventDefault();
   		e.preventDefault(); 
   		// alert(12);
     if(confirm('Do you want to Update Time Table') ){ 
     			
       	  console.log(this);
         // $("input[type='hidden']").removeAttr('name');	 
            var action ='UpdateTimeTable'; 
             
            // $('.LoadTimeTableFormat').remove();    
            $(this).append('<input type="hidden" name="'+ action+'"/>');   
            var formData =new FormData($('#devel-generate-content-form')[0]);
            $('input[type="button"]').attr('disabled',true);
            $('input[type="button"]').val('Please wait...');
                 		 		
        $.ajax({              	
 		    type: "POST",    
 		    url : 'Controllers/StudentControllers.php', 
 		    data : formData,
 		    contentType: false,   
		    	cache: false,    
		    	processData:false, 
		    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.status=='success') {  
 		    	    	
 		     		  	   
 		    	    	toastr.success(responce.msg);	
 		    	    	setInterval(function(){
 		    	    	
 		    	    	// window.location.reload();
 		    	    	window.location.href = "dashboard.php?option=update_timetable";			
 		    	    		},3000);
 		    	    }else{      
 		    	    
 		    	    	toastr.error(responce.msg);	
 		    	    }		
 		    	    $('input[type="button"]').attr('disabled',false);
                    $('input[type="button"]').val('Update');
 		       }					
 	    }); 
 	            e.preventDefault();		

 	return false;	  }   
 	   });
 	   });



 </script>

 

 