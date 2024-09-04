<?php
error_reporting(1);
date_default_timezone_set('Asia/Kolkata');
extract($_REQUEST);
$email=$_SESSION['user_logged_in'];
$username=$res['username']; 
$atdate=(date("Y-m-d"));	

if(isset($load))
{
	 $atdate = $_REQUEST['atdate'];  	
	  $query=mysqli_query($con,"select * from student_daily_attendance where class_id='$class' && section_id='$section' && date='$atdate'  && session='".$_SESSION['session']."'");
	 $row = mysqli_num_rows($query);
	 if(!$row)
	 {	 
	  // $query="select * from students where class_id='$class' && section_id='$section'  && session='".$_SESSION['session']."'  order by (roll_no) ASC";
	   $query="select `student_id`,`student_name`,`register_no`,`sr`.`roll_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where sr.class_id='$class' && sr.section_id='$section' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."' order by sr.roll_no ASC";
	 $search_result = filterTable($query);
	 } 
	 else
	 {
		 ?>
		 
		 <script>
		if(confirm('Attendance already taken. Do you want to Edit?')==true)
		{
			<?php
				// $query="select * from students where class_id='$class' && section_id='$section'   && session='".$_SESSION['session']."' order by (roll_no) ASC"; //(student_id) DESC
				$query="select `student_id`,`student_name`,`register_no`,`sr`.`class_id`,`sr`.`roll_no`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where  sr.class_id='$class' && sr.section_id='$section' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."' order by sr.roll_no ASC";
				$search_result = filterTable($query);
			?>
		} 
		else 
		{
			window.location.href = "dashboard.php?option=stu_daily_attendance";
			// setTimeout(function(){ window.open(url+response.url, '_blank');  },3000);
			// setTimeout(function(){ window.open(url+response.url, '_blank');  },3000);
			// // window.location= "dashboard.php?option=stu_daily_attendance";
			// //  target = "_blank";
			//  window.open('dashboard.php?option=stu_daily_attendance', '_blank'); 
		}
		 
		 </script>
		 <?php
	 }
	
}



function filterTable($query)
	{
		include('connection.php');
		$filter_Result = mysqli_query($con, $query);
		return $filter_Result;
	}	
	
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Attendence Panel</a>
  <a class="breadcrumb-item" href="#"> Student Attendence</a>
  <span class="breadcrumb-item active">Student Daily Attendance</span>
</nav>
<!-- breadcrumb -->
   <form method="post" id="Attendance-form" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
                        <div class="row" style="margin-top:20px;">
								
								<div class="col-md-1"></div>
								<div class="col-md-1" style="font-size:14px;">Date <?php echo $cdate; ?></div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px;">
								<input type="date" name="atdate" value="<?php echo $atdate; ?>" class="form-control" style="width:175px;" autofocus required>
								</div>
								
								<div class="col-md-1" style="font-size:14px;margin-left:50px;">Class</div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select name="class" class="form-select" onchange="search_sec(this.value)" style="width:175px;" autofocus required>
								<option value="" selected="selected" disabled>Select Class</option>
								<?php
								$scls = "select * from class";
								$rcls = mysqli_query($con, $scls);
								while( $rescls = mysqli_fetch_array($rcls) ) {
								?>
								<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								
							<script>
							function search_sec(str)
							{
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_section_att.php?cls_id="+str,true);
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
							
								<div class="col-md-1" style="font-size:14px;margin-left:50px;">Section </div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select class="form-select" name="section" id="search_sect" style="width:175px;" autofocus required>
								<option value="" selected="selected">Select section</option>
								<?php
								$qsec=mysqli_query($con,"select * from section where class_id='$class'");
								while($rsec=mysqli_fetch_array($qsec))
								{
								?>
								<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>
								</option>
								<?php 
								}
								?>		
								</select>	
								</div>
								<div class="col-md-1"></div><br><br>
						</div>
						
								
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2">
							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:100px;margin-left:550px;" value="Load"><br><br>
							</div>
							<br>
							<br>
						</div>
						
			<script>	
			function test456(at_type,reg_no)
			{
				var tmp="demo345"+reg_no;
				// var tmp=tmp2.replace('/','/\\');
				 // var tmp=Parse.string(tmp2);
				if(at_type=="3")
				{			  
				  $("#"+tmp).css("display","block");
				  $("#"+tmp).prop('required',true); 
				}
				else
				{
				$("#"+tmp).css("display","none");
				$("#"+tmp).val('');
				$("#"+tmp).prop('required',false);
				}
			}
			</script>	
			
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sl No.</th>
                                             <th>Register No</th>
                                             <th>Roll No.</th>
											 <th>Student Name</th>
											 <th>Attendance</th>
											 <th>Reason</th>
										</tr>
                                    </thead>
                                    <tbody id="attendance">
									<?php 
									if($search_result){
									$row = mysqli_num_rows($search_result);
									if($row)
									{
										$found=1;
										
									}
									else
									{
										$found=0;
									}
									$i=1;	
									while($res1=mysqli_fetch_array($search_result))
									{	
										// echo "<pre>";
										// print_r($res1);
									
									$regno=$res1['register_no'];
									$stuid=$res1['student_id'];
									$roll_no=($res1['roll_no']) ? $res1['roll_no'] : '0' ;
									$stuname=$res1['student_name'];
									$attend=$res1['type_of_attend'];
														
									?>
									<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $regno; ?></td>
								<input  hidden type="text" name="regno[]"  value="<?php echo $regno;?>" style="display: none;">
								<td><?php echo $roll_no; ?></td>								
								<td><?php echo $stuname; ?></td>
								<input hidden type="text" name="stuid[]" value="<?php echo $stuid;?>"  style="display: none;">
								
								<td> 
									<!-- $regs=stripslashes($regno); -->
								<select name="attend[]" id="<?php echo $a=str_replace("/",'',$regno); ?>" class="form-select" onchange="test456(this.value,this.id)" style="width:150px;">
								<?php
								if($found ==1)
								{
								 $status = mysqli_query($con,"select * from student_daily_attendance where student_id='$stuid'
								 && date='$atdate'   && session='".$_SESSION['session']."' ");
								 $attres = mysqli_fetch_array($status);
								 $attend = $attres['type_of_attend'];
								 $reason = $attres['reason'];
								
								$qu=mysqli_query($con,"select * from attendance_type");
								while($re=mysqli_fetch_array($qu))
								{
								?>
								<option <?php if($attend==$re['att_type_id']){echo "selected";}?> value="<?php echo $re['att_type_id']; ?>"><?php echo $re['att_type_name'];?></option>
								<?php
								}
								
								?>
								</select>
								</td>
								
								<td><input type="text" name="reason[]" id="demo345<?php echo $a=str_replace("/",'',$regno); ?>" value="<?php echo $reason;?>" style="display:<?php if(!empty($reason)){echo 'block';} else {
								echo 'none';}?>" class="form-control"></td>									
									</tr>
								<?php
								}
								$i++;
								}
							      }
								?>					
                                    </tbody>
                                </table>
                            </div>
                        </div><br><br>
		
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
		
		<?php if($row > 0){?>	
			<div class="" style="margin:0px 0px 20px 222px ">	
				<div class="col-md-2">
				</div>
					<div class="col-md-1">
						<input type="submit" id="saveattendence" name="save"  value="Save" class="btn btn-primary btn-sm"/>
					</div>
				
				<!--<div class="col-md-2" style="margin-left:10px">
				<input type="checkbox" name="check"/><span style="margin-left:5px;">Send Bulk SMS</span>
				</div>-->
				
				<div class="col-md-2">
				<input type="submit" id="saveattendence_sms" name="saveattendence-sms"  value="Save & Send SMS" class="btn btn-primary btn-sm"/>
				</div>
				
				<div class="col-md-2">
				<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm"/>		
				</div>
			</div>	
		<?php } ?>
		
		
		
	</form>	
    </div><!-- /#right-panel --><script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
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
   $('#saveattendence').click(function(e){	
     if( !confirm('Do you want to Save the Attendance?') ){ 
     		e.preventDefault(); 	
        }else{ 	  
         $("input[type='hidden']").removeAttr('name');	 
            var action ='TakeAttendence';     
            $(this).append('<input type="hidden" name="'+ action+'"/>');   
            var formData =new FormData($('#Attendance-form')[0]);
            $('#saveattendence').attr('disabled',true);
                   		 		
        $.ajax({              	
 		    type: "POST",    
 		    url : 'AjaxHandler.php', 
 		    data : formData,
 		    contentType: false,   
		    	cache: false,    
		    	processData:false, 
		    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.status=='success') {  
 		    	    	 $('#saveattendence').attr('disabled',false);
 		     		  	   
 		    	    	toastr.success(responce.msg);	
 		    	    	setInterval(function(){
 		    	    	$('#attendance').empty();	
 		    	    	window.location.href = "dashboard.php?option=stu_daily_attendance";			
 		    	    		},3000);
 		    	    }else{      
 		    	    	$('#saveattendence').attr('disabled',false);
 		    	    	toastr.error("Somethings is Wrong");	
 		    	    			}		  }					
 		    	    			 });         e.preventDefault();		 		 return false;	  }      });

   // Attendence with sms

	$('#saveattendence_sms').click(function(e){	  
	if( !confirm('Do you want to Save  and  send the Attendance?') ){ 	
	e.preventDefault(); 	  }else{ 	
	  $("input[type='hidden']").removeAttr('name');
	  	  // var action ='TakeAttendence_sms';       
	  	  var action ='TakeAttendence';       
	   	  $(this).append('<input type="hidden" name="'+ action+'" id="takeatt" /> ');  
	   	  $('#saveattendence_sms').attr('disabled',true);
	   	  $('#saveattendence').attr('disabled',true);
	   	  $('#saveattendence_sms').val('Sending Please wait...');
	   	       var formData =new FormData($('#Attendance-form')[0]);

			$.ajax({              		
				type: "POST",         
				url : 'AjaxHandler.php',  
				data : formData, 
				contentType: false,  
				cache: false,     
				processData:false,              	
				success: function (responce) {    
				var responce = JSON.parse($.trim(responce));

				if(responce.status=='success') {

					toastr.options = {		
						"debug": false,
						"newestOnTop": false,
						"positionClass": "toast-bottom-right",	
						"preventDuplicates": false,	
						"timeOut": "12999999",		
						"extendedTimeOut": "10000000",
						"showEasing": "swing",	
						
						};
					if(responce.type=='insert'){
						toastr.success("Attendance Taken. <br> Please wait for Sending SMS");
						var att_type='insert';
						var arr_stuid='';
					}else{
						toastr.success("Attendance Updated. <br> Please wait for Sending SMS");
						var att_type='update';
						var arr_stuid=responce.result;   
					}	
					
					 $("input[type='hidden']").removeAttr('name');	
		   	        $('#takeatt').remove();      //must remove this
		   	        var action ='TakeAttendence_sms'; 

		   	        $('#Attendance-form').append('<input type="hidden" name="'+ action+'"/>');

					var formDatasms =new FormData($('#Attendance-form')[0]);
					formDatasms.append("att_type",att_type);
                    
					formDatasms.append("arr_stu",arr_stuid);
					$.ajax({              		
						type: "POST",         
						url : 'AjaxHandler.php',  
						data : formDatasms, 
						contentType: false,  
						cache: false,     
						processData:false,              	
						success: function (responce) {    
						var responce = JSON.parse($.trim(responce));
						alert('d');
						toastr.options = {		 
								"debug": false,
								"newestOnTop": false,
								"progressBar": true,
								"positionClass": "toast-bottom-right",	
								"preventDuplicates": false,	
								"timeOut": "6000",		
								"extendedTimeOut": "1000",
								"showEasing": "swing",	
								
								};
							if(responce.status=='success'){
								$('#saveattendence_sms').attr('disabled',false);
					            $('#saveattendence').attr('disabled',false);
					   	        $('#saveattendence_sms').val('Save & Save SMS');

					   	        // toastDiv.remove();
					   	        $('#toast-container').remove();  //remove the previous toastor
					            toastr.success(responce.msg);	
					   		    setInterval(function(){ 	
					   				$('#attendance').empty();	
					   							
					   				window.location.href = "dashboard.php?option=stu_daily_attendance";
					   							 				},6000);
																

						    }else{
						    	// alert("SMS not sent");
						    	$('#toast-container').remove();  //remove the previous toastor
						    	 toastr.error(responce.msg);
						    	 setInterval(function(){ 	
					   				$('#attendance').empty();	
					   							
					   				window.location.href = "dashboard.php?option=stu_daily_attendance";
					   							 				},6000);	


							    $('#saveattendence_sms').attr('disabled',false);
							    $('#saveattendence').attr('disabled',false);
							  	$('#saveattendence_sms').val('Save & Send SMS');

						    } 
						}
					});		

			    }	   	
			    else{   

				    toastr.error("Somethings is Wrong");	
				    $('#saveattendence_sms').attr('disabled',false);
				    $('#saveattendence').attr('disabled',false);
				  	$('#saveattendence_sms').val('Save & Send SMS');

						       	}		  }					
		    });  
				    e.preventDefault();	
				    return false;	  }   
    });	  	
 		 });	
</script>	 	

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
