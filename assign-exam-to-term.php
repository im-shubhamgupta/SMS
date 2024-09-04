<?php
error_reporting(1);
include('connection.php');

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

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">Assign To Term</span>

</nav>

<!-- breadcrumb -->

   <form method="post"  id="assign-to-term" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

              


						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Class</div>

							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">

							<select name="class" id="class" class="form-select" onchange="searchtest(this.value);search_sec(this.value)" style="width:175px;" autofocus required>

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

							

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>

							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">

							<select class="form-select" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:175px;" autofocus required>

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

                        </div>
						<div class="row" style="margin-top:50px;">
						
						   
						   <div class="col-md-2" style="font-size:14px;margin-left:40px;">Select Term</div>

							<div class="col-md-2" style="margin-left:-85px;margin-top:-10px;">

							<select name="term"  id="term_exam" class="form-select" style="width:180px"  required>
									<option value="">Select Term</option>
									<?php
									$qtest=mysqli_query($con,"select id, name from parent_exam");
									while($rtest=mysqli_fetch_array($qtest))
									{	
									?>
									<option value="<?php echo $rtest['id']; ?>"><?php echo $rtest['name'];?>
									</option>
									<?php 
									}
									?>		
							</select>
						
						   </div>

							<div class="col-md-2" style="font-size:14px;margin-left:40px;">Test Name </div>

							<div class="col-md-2" style="margin-left:-95px;margin-top:-10px;">

							<select class="form-control"  multiple name="test[]" id="search_test" style="width:175px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

							

							</select>

							</div>

						 </div>
						
						
						
						<br><br>

                     

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2">

							<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-80px;width:120px;margin-left:270px;" value="Assign"><br>

							</div>

						</div><br>		



                         </div>
					  </div>
						<!--table starts from here-->

	</form>	

    </div><!-- /#right-panel -->
	 <?php include('bootstrap_datatable_javascript_library.php'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script> -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
	<script>
	
	$(document).ready(function(){
		toastr.options = {
		"closeButton": true, 
		"debug": false,
		"newestOnTop": false,
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
		
	});	     
		
	
	
	
	
   
   $('form').on('submit', function (e) {
	 if( !confirm('Do you want to Assign This Test? ') ){ 
		e.preventDefault(); 
	  }else{ 
	  
	  var action = 'AssignTerm'; 
	  $(this).append('<input type="hidden" name="'+ action+'"/>'); 
	  $("input[type='submit']").attr("value", "Sending, please wait...");        
	  $("input[type='submit']").attr("disabled", true);
	  $.ajax({ 
		type: "POST",
		url : 'AjaxHandler.php',               
		data : new FormData(this),  
		contentType: false, 
		cache: false, 
		processData:false, 
		success: function (responce) {
		var response = JSON.parse(responce); 
		 if(response.status=='success') { 
		 
			toastr.success(response.message); 
			// setInterval(function(){ 
			// 		window.location.href='dashboard.php?option=assign-test-to-term';
			// 		},4000);
			setTimeout(function(){ 
				$('#assign-to-term')[0].reset();
			},3000);		 


	     }else if(response.status=='error'){
			 
			toastr.error(response.message); 
			
		}else if(response.status=='not'){
		  toastr.error(response.message);	
		}

         $("input[type='submit']").attr("value", "Assign");        
	     $("input[type='submit']").attr("disabled", false);
         // $('#assign-to-term')[0].reset();		 

		}		 
	  
		});
		
		e.preventDefault(); 
	  }
	});
	

	</script>


 

 