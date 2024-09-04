<?php

error_reporting(1);

extract($_REQUEST);





?>



	<style>





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

  <span class="breadcrumb-item active">Assign Grade</span>

</nav>

<!-- breadcrumb -->

   <form method="post" name=AssignGrade action="dashboard.php?option=assign_grade" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-3" style="margin-left:0px;">Enter the Grade Name : </div>

							<div class="col-md-2" style="margin-left:0px;">

							<input type="text" name="grade" class="form-control" style="text-align:center" autofocus required>

							</div>								

						</div><br>

                     

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="margin-left:0px;margin-top:20px">Condition : </div>

							<div class="col-md-3" style="margin-left:0px;">

							<label style="margin-left:30px">From Percentage(%)</label>

							<input type="number" name="value1" id="fromper" class="form-control nonegative toper" style="text-align:center" autofocus required>

							</div>

							<div class="col-md-1" style="margin-top:5px;"> to </div>

							<div class="col-md-3" style="margin-left:-50px;">

							<label style="margin-left:30px">To Percentage(%)</label>

							<input type="number" name="value2" id="toper" class="form-control nonegative toper" style="text-align:center" autofocus required>

							</div>

					    </div><br><br>	

						

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2">

							<input type="submit" name="save" class="btn btn-primary btn-sm" value="Assign" style="width:120px;height:35px;margin-left:350px;">

							</div>

							<div class="col-md-2">

							<input type="reset" class="btn btn-info btn-sm" value="Cancel" style="width:120px;height:35px;margin-left:350px;">

							</div>

						</div>

								

						<!--table starts from here-->						 		

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->						

		

	</form>	

    </div><!-- /#right-panel -->

	

<script>

$(document).ready(function(){

	$(".nonegative").keyup(function(){

	if($(this).val() < 0){

		 $(this).val('');

		 return false;

	 }

	

	 // if(key.charCode < 48 || key.charCode > 57){

		 // $(this).val('');

		 // return false;

	 // }

	

	});	

});

</script>	



<script>

$(document).ready(function(){

	$(".toper").blur(function(){

	var fromp = $("#fromper").val();

	var top = $("#toper").val();

	if((top!= '') && (fromp!= ''))

	{

		if(parseInt(top) < parseInt(fromp) || parseInt(top) == parseInt(fromp))

		{

		 alert('From Percentage should not be greater than To Percentage.')

		 $(this).val('');

		 $(this).focus();

		}

	}

	});	

});

</script>	



 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
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
		

	
	
	
	
   
   $('form').on('submit', function (e) {

	 // if( !confirm('Do You Assign This Test ') ){ 
		e.preventDefault(); 
	  // }else{ 
	  
	  var action = 'AssignGrade'; 
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
		success: function (result) {
		var response = JSON.parse(result); 
		console.log(response);
		 if(response.type=='success') { 
		 	toastr.success(response.message);  
		 	setInterval(function(){
		 		window.location.href='dashboard.php?option=assign_grade';
		 	},4000)
			

	     }else if(response.type=='already'){
			 
			toastr.error(response.message); 
			
		}else{
		  toastr.error(response.message);	
		}

         $("input[type='submit']").attr("value", "Assign");        
	     $("input[type='submit']").attr("disabled", false);
         // $('#devel-generate-content-form')[0].reset();		 

		}		 
	  
		});
		
		e.preventDefault(); 
	  // }
	});
   	});	     
		
	

	</script>


 

 