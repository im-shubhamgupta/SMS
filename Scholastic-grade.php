<?php
error_reporting(1);
extract($_REQUEST);

if(isset($load))
{ 
	$query="select * from test where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$subject' and session='".$_SESSION['session']."'";
	$search_result = filterTable($query);

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
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Exam & Result</a>
  <span class="breadcrumb-item active">Scholastic Grade</span>
</nav>
<!-- breadcrumb -->
   <form method="post"  id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-2" style="margin-left:20px;">Class</div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">
							<select name="class" id="class" class="form-control" onchange="searchtest(this.value);search_sec(this.value)" style="width:180px;" autofocus required>
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
							xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);
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
							
							<div class="col-md-2" style="margin-left:50px;">Section </div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">
							<select class="form-control" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:195px;" autofocus required>
							<option value="" selected="selected" disabled>Select Section</option>
							<?php
							$qsec=mysqli_query($con,"select * from section where class_id='$class'");
							while($rsec=mysqli_fetch_array($qsec))
							{
							$secname=$rsec['section_name'];
							?>
							<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>
							</option>
							<?php 
							}
							?>							
							</select>	
							</div>
							<script>
							function searchtest(str)
							{
							var clsid = $('#class').val();
							//alert(clsid);
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_term.php?sec_id="+str+"&cls_id="+clsid,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200  && xmlhttp.readyState==4)
							{
							document.getElementById("search_test").innerHTML=xmlhttp.responseText;
							}
							} 
							}
							</script>	
						</div><br><br>
                     
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Test Name </div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
							<select class="form-control" name="test" id="search_test"
							style="width:195px;" autofocus required>				
							<option value="" selected="selected" disabled>Select Test</option>
							<?php
							$quet = mysqli_query($con,"select * from parent_exam");
							while( $rtest= mysqli_fetch_array($quet) ) { 
							?>
							<option <?php if($test==$rtest['id']){echo "selected";}?> value="<?php echo $rtest['id']; ?>"><?php echo $rtest['name']; ?>
							</option>
							<?php } ?>	
							</select>
							</div>							
							

							
							<div class="col-md-2" style="margin-left:50px;">Subject </div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
							<select class="form-control" name="subject" id="search_sub" style="width:195px;" autofocus required>				
							<option value="" selected="selected" disabled>Select Subject</option>
							<?php
							$qsub = mysqli_query($con,"select * from `co_scholastic`");
							while( $rsub= mysqli_fetch_array($qsub) ) {
							?>
							<option  <?php if($subject==$rsub['scholastic_id']){echo "selected"; }?> value="<?php echo $rsub['scholastic_id']; ?>"><?php echo $rsub['scholastic_name']; ?>
							</option>
							<?php } ?>	
							</select>
							</div>
														
							
							<div class="col-md-2">
							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-90px;width:120px;margin-left:60px;" value="Load"><br><br>
							</div>
						</div><br>
								
						<!--table starts from here-->
						
						
						<?php
						if(isset($load))
						{
							$res=mysqli_fetch_array($search_result);
						
							
							$cid = $class;
							$qcls = mysqli_query($con,"select * from class where class_id='$cid'");
							$rcls = mysqli_fetch_array($qcls);
							
							$sid = $section;
							$qsid = mysqli_query($con,"select * from section where section_id='$sid'");
							$rsid = mysqli_fetch_array($qsid);
							
							$sub = $subject;
							$qsub = mysqli_query($con,"select * from co_scholastic where scholastic_id='$sub'");
							$rsub = mysqli_fetch_array($qsub);
							
							$mmax = $res['max_marks'];
						?>	
						<div class="card">
						<div class="card-body">
						<h6>Scholastic Grade</h6>
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="margin-left:50px;">Class : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-80px">
							<input type="text" value="<?php echo $rcls['class_name'];?>" class="form-control" style="width:175px;" disabled>
							</div>
							
														
							<div class="col-md-2" style="margin-left:80px;">Section : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-60px;">
							<input type="text" value="<?php echo $rsid['section_name'];?>" class="form-control" style="width:175px;" disabled>
							</div>
						</div><br>
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="margin-left:50px;">Subject : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-80px;">
							<input type="text" value="<?php echo $rsub['scholastic_name'];?>" class="form-control" style="width:175px;" disabled>
							</div>
							
							<div class="col-md-2" style="margin-left:80px;">Term Name : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-60px;">
							<input type="text" value="<?php echo gettermName($test,$con);?>" class="form-control" style="width:175px;" disabled>
							</div>
						</div><br><br>	
								
						<h6>STUDENT DETAILS</h6><br>
						
					    <table id="table" class="table table-striped table-bordered">
							<thead>
								<tr>
									 <th>Sl No.</th>
									 <th>Student Name</th>
									 <th>Gender</th>
									 <th>Grade</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							// $que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' && stu_status='0'  and session='".$_SESSION['session']."' ");
							$que2 = mysqli_query($con,"select `student_id`,`register_no`,`student_name`,`father_name`,`gender`,`parent_no`,`msg_type_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");
							if(mysqli_num_rows($que2)>0){
							$i=1;							
							while($res1=mysqli_fetch_array($que2))
							{									
							$stuid = $res1['student_id'];
							$stuname = $res1['student_name'];
							$gender = $res1['gender'];
									
							$que3 = mysqli_query($con,"select * from `scholastic-grade` where class_id='$class' && section_id='$section' && student_id='$stuid' && term_id='$test' && subject_id='$subject' && session='".$_SESSION['session']."'");
							$res3 = mysqli_fetch_array($que3);
							$grade = $res3['grade'];
							?>
							<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $stuname; ?></td>
							<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">
							
							<td><?php echo $gender;?></td> 
							
							<td><input type="text" name="marks[]" oninput="this.value = this.value.toUpperCase()"  id="marks" value="<?php echo $grade;?>" style="width:100px" class="form-control marks" autofocus ></td>
																
							</tr>
							<?php
							$i++;
							}
						      }
							?>					
						 	</tbody>
						</table>
						</div>	
						</div><br>
						 
						 		
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<input id="save-grade" type="submit" name="save" value="Save" class="btn btn-primary btn-sm"/>
		</div>
						 
						<?php
						}
						?>								
                            		
		
		
	</form>	
    </div><!-- /#right-panel -->


	
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
 
 <script>
$(document).ready(function(){
	$('#devel-generate-content-form')[0].reset();
	
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
	 "timeOut": "5000",			
	 "extendedTimeOut": "1000",		
	 "showEasing": "swing",			
	 "hideEasing": "linear",		
	 "showMethod": "fadeIn",		
	 "hideMethod": "fadeOut"		
	 };				
 }); 
	
	
	
	
	$('.marks').blur(function(){
		
	var m = parseInt($("#max1").val());
	
	if($(this).val() > m)
	{
		//console.log("Hi");
		alert("Marks is not greater than Max marks.");
		$(this).val("");
		$(this).focus();
		return false;
	}
	});
	
	$('#save-grade').click(function(e){	
	 if( !confirm('Do you want to Save Scholatic Grade?') ){ 
	    e.preventDefault(); 	 
		}else{ 	  
		
		var action ='scholastic-grade';        	 
		$(this).append('<input type="hidden" name="'+ action+'"/>');     
		var formData =new FormData($('#devel-generate-content-form')[0]);	
		$("input[type='submit']").attr("value", "Sending, please wait...");        
	    $("input[type='submit']").attr("disabled", true);	            		 	
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
						toastr.success(responce.msg);			
						setInterval(function(){ 					
						// window.location.reload();
						window.location.href="dashboard.php?option=assign-scholastic-grade";			
						},3000);								
				}else{         
				toastr.error("Somethings is Wrong");	
			   } 
			$("input[type='submit']").attr("value", "Save");        
	        $("input[type='submit']").attr("disabled", false);   
			}					
			});      
			e.preventDefault();		 	
			return false;	
		}   
		});  
	
	
	
	
	
	
});
</script>	