<?php
error_reporting(1);
extract($_REQUEST);
?>

	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
<script type="text/javascript">
	// $("#table").dataTable({
		
	// 	paging : false
	// });
	
</script>

<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <!-- <a class="breadcrumb-item" href="#">Student Panel</a> -->
  <a class="breadcrumb-item" href="#">Exam & Result</a>
  <span class="breadcrumb-item active">Marks Entry</span>
</nav>
<!-- breadcrumb -->
<!-- dashboard.php?option=marks_entry -->
   <form method="post" name="marks_entry" action="" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-2" style="margin-left:20px;">Class</div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">
							<select name="class" id="class" class="form-select" onchange="searchtest(this.value);search_sec(this.value)" style="width:180px;" autofocus required>
							<option value="" selected="selected" disabled>Select Class</option>
							<?php
							$scls = "select * from class";
							$rcls = mysqli_query($con, $scls);
							while( $rescls = mysqli_fetch_array($rcls) ) {
							?>
			
							<option value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
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
							<select class="form-select" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:195px;" autofocus required>
							<option value="" selected="selected" disabled>Select Section</option>
							<?php
							// $qsec=mysqli_query($con,"select * from section where class_id='$class'");
							// while($rsec=mysqli_fetch_array($qsec))
							// {
							// $secname=$rsec['section_name'];
							// ?>
						<!-- 	// <option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>
							// </option> -->
							<?php 
							// }
							?>							
							</select>	
							</div>
							<script>
							function searchtest(str)
							{

							var clsid = $('#class').val();
							//alert(clsid);
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);
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
							<select class="form-select" name="test" id="search_test" onchange="searchsub(this.value)"
							style="width:195px;" autofocus required>				
							<option value="" selected="selected" disabled>Select Test</option>
								
							</select>
							</div>							
							<script>
							function searchsub(str)
							{
							$('#search_sub').html('');  //at first null	
							var clsid = $('#class').val();
							var secid = $('#search_sect').val();
							//alert(secid);
							var xmlhttp = new XMLHttpRequest();
							xmlhttp.open("get","search_ajax_testsub.php?clsid="+clsid+"&secid="+secid+"&testname="+str,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200 && xmlhttp.readyState==4)
							{
							document.getElementById("search_sub").innerHTML=xmlhttp.responseText;	
							}									
							}
							}
							</script>

							
							<div class="col-md-2" style="margin-left:50px;">Subject </div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
							<select class="form-select" name="subject" id="search_sub" style="width:195px;" autofocus required>				
							<option value="" selected="selected" disabled>Select Subject</option>
							<?php
							// $qsub = mysqli_query($con,"select test.subject_id, subject.subject_name from test INNER JOIN subject ON test.subject_id = subject.subject_id where test.class_id='$class' && test.section_id='$section' && test.test_name='$test'");
							// while( $rsub= mysqli_fetch_array($qsub) ) {
							// ?>
							<!-- // <option <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name']; ?>
							// </option> -->
							<?php//} ?>	
							</select>
							</div>
														
							
							<div class="col-md-2">
							<input type="submit" id="load_btn" name="load" class="btn btn-primary btn-sm" style="margin-top:-90px;width:120px;margin-left:60px;" value="Load"><br><br>
							</div>

						</div><span id="error" style="color:red;"></span><br>
								
						
				
						<div id="Load_marks_format">
						</div>
						
						 
						 		
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<!-- <input  type="submit" name="save" id="marks_submit" style="display: none;" value="Save" class="btn btn-primary btn-md"/> -->
		<input  type="button" name="save" id="marks_submit" style="display: none;" value="Save" class="btn btn-primary btn-md"/>
		</div>
						 
						<?php
						// }
						?>								
                            		
		
		
	</form>	
    </div><!-- /#right-panel -->


	
 <!-- <?php //include('bootstrap_datatable_javascript_library.php'); ?> -->
 <?php include('datatable_links.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
 
 <script>
 
$(document).ready(function(){
	// $('.marks').blur(function(){
	$(document).on('blur','.marks',function(){
		
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
});

	// "use strict";
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
		"timeOut": "3000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					}); 
$(document).ready(function() {

	// $('#devel-generate-content-form').on('submit',function(e){
	// $('#load_btn').on('click',function(e){
	$('form').on('submit',function(e){
			e.preventDefault();

			// alert("load");
			var flag=1;
			var  classname =$('#class').val();
			var search_test=$('#search_test').val();
			var search_sub=$('#search_sub').val();
			if(classname==''){
			
				$('#error').html("*Please select class");

				flag=1;
			}else if(search_test=''){
				$('#error').html("*Please select Test name");

			}else if(search_sub==''){
				$('#error').html("*Please select Subject");

			}else{
	     	$(".marks_entry").removeAttr('name');	 
             $(".marks_entry").remove();
			var action ='LoadMarksFormat';        
			$(this).append('<input type="hidden" name="'+ action+'" class="LoadMarksFormat" />');          			          
			var formData =new FormData($('#devel-generate-content-form')[0]);		            		 
				$.ajax({              
					type: "POST",                
					url : 'AjaxHandler.php',             
					data : formData,                
					contentType: false,               
					cache: false,                
					processData:false,              
					success: function (responce) { 
					// alert(responce);                
					$('#Load_marks_format').html(responce);
					 $('#marks_submit').show();	

                    // $("#updatetest").prop('disabled', false);					
					}	
				 }); 
			}
		});	 





   $('#marks_submit').on('click',function(e){
   	e.preventDefault();
   // alert(1);	
    	if(confirm("Do you want to save the Marks.")){
         // $("input[type='hidden']").removeAttr('name');	 
         $(".LoadMarksFormat").removeAttr('name');	 
         $(".LoadMarksFormat").remove();	 
            var action ='marks_entry';     
            $(this).append('<input type="hidden" name="'+ action+'" class="marks_entry"/>');   
            var formData =new FormData($('#devel-generate-content-form')[0]);
            $('#marks_submit').attr('disabled',true);
            $('#marks_submit').val('Please wait...');

            // var formData =$('#Attendance-form').serialize();		
            // console.log(formData);   
            // alert($('#regno').val());         		 		
        $.ajax({              	
 		    type: "POST",    
 		    url : 'AjaxHandler.php', 
 		    data : formData,
 		    contentType: false,   
		    	cache: false,    
		    	processData:false, 
		    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.type=='success') {  
 		    	    	 $('#marks_submit').attr('disabled',false);
 		     		  	 $('#marks_submit').val('Save');  
 		    	    	toastr.success(responce.msg);	
 		    	    	// setInterval(function(){
 		    	    	// $('#attendance').empty();	
 		    	    	// // window.location.reload();
 		    	    	// window.location.href = "dashboard.php?option=marks_entry";			
 		    	    	// 	},3000);
 		    	    	setTimeout(function(){
	 		    	    	// $('#attendance').empty();	
	 		    	    	$('#Load_marks_format').html('');
	 		    	    	 $('#marks_submit').hide();	
	 		    	    	// $('#devel-generate-content-form')[0].reset();
	 		    	    	// $(this).ajax.reload();		
 		    	    	},3000);
 		    	    	
 		    	    }else{      
 		    	    	$('#marks_submit').attr('disabled',false);
 		    	    	$('#marks_submit').val('Save'); 
 		    	    	toastr.error("Somethings is Wrong");	
 		    	    			}		
 		    	}					
 		});
 	}else{
 		return false;	
 	}       	 
 		

    });
    });
</script>