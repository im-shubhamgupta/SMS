<?php

error_reporting(1);

extract($_REQUEST);

$id = $_REQUEST['gid'];



$query = mysqli_query($con,"select * from grade where grade_id='$id'");

$res = mysqli_fetch_array($query);

$gname = $res['grade_name'];

$c1= $res['condition1'];

$c2 = $res['condition2'];



// if(isset($update))

// {

// 	$que2 = mysqli_query($con,"update grade set grade_name='$grade', condition1='$value1', condition2='$value2' where grade_id='$id'");

	

// 	echo "<script>window.location='dashboard.php?option=view_grade'</script>";

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

	<a class="breadcrumb-item" href="#">Exam & Result</a>

	<a class="breadcrumb-item" href="dashboard.php?option=view_grade">View Grade</a>

    <span class="breadcrumb-item active">Update Grade</span>

</nav>

<!-- breadcrumb -->

   <form method="post" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

							<div class="col-md-3" style="margin-left:200px;">Enter the Grade Name : </div>

							<div class="col-md-2" style="margin-left:-50px;">

							<input type="text" name="grade" class="form-control" value="<?php echo $gname;?>" 

							style="text-align:center" autofocus required>

							</div>								

						</div><br>

                     

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2" style="margin-left:200px;">Condition : </div>

							<div class="col-md-2" style="margin-left:-50px;">

							<input type="text" name="value1" class="form-control" value="<?php echo $c1;?>" 

							style="text-align:center" autofocus required>

							</div>

							<div class="col-md-1" style="margin-top:5px;"> to </div>

							<div class="col-md-2" style="margin-left:-30px;">

							<input type="text" name="value2" class="form-control" value="<?php echo $c2;?>" 

							style="text-align:center" autofocus required>

							</div>

					    </div><br><br>	

						

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2">
							<input type="hidden" name="grade_id" value="<?=$res['grade_id']?>">	

							<!-- <input type="submit" name="update" onclick="return confirm('Do you want to update the Grade.')" class="fa fa-edit btn btn-primary btn-sm" value="Update" style="width:120px;height:35px;margin-left:350px;"> -->

							 <button onclick="return confirm('Do you want to update the Grade.')" type="submit" name="update" class="btn btn-primary btn-sm" style="width:120px;height:35px;margin-left:400px;"> 

							 <i class='fa fa-edit'></i> Update </button> 

							</div>

						</div>

								

						<!--table starts from here-->						 		

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->						

		

	</form>	

    </div><!-- /#right-panel -->

	

 <!-- <?php
 // include('bootstrap_datatable_javascript_library.php'); ?> -->
 <?php include('datatable_links.php'); ?>

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
   	// alert(1);
	 // if( !confirm('Do You Assign This Test ') ){ 
		e.preventDefault(); 
	  // }else{ 
	  
	  var action = 'UpdateGrade'; 
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
		 		window.location.href='dashboard.php?option=view_grade';
		 	},3000)
			

	     }else if(response.type=='already'){
			 
			toastr.error(response.message); 
			
		}else{
		  toastr.error(response.message);	
		}

         $("input[type='submit']").attr("value", "Update");        
	     $("input[type='submit']").attr("disabled", false);
         // $('#devel-generate-content-form')[0].reset();		 

		}		 
	  
		});
		
		e.preventDefault(); 
	  // }
	});
   	});	     
		
	

	</script>


 

 