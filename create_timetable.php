<?php

error_reporting(1);




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



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Time Table</a>

  <span class="breadcrumb-item active">Create Time Table</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

													

							<div class="col-md-2" style="margin-top:-8px;">Class : </div>

							<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

							<select style="width:150px;" name="class" id="class" class="form-control" 	onchange="search_sec(this.value);" required autofocus>
<!-- searchstudent(this.value); -->
							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = mysqli_query($con,"select * from class");

							while( $rcls = mysqli_fetch_array($scls) ) {

							?>

							<!-- <option <?php if($class==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?> -->
								<option value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

						<div class="col-md-2" style="margin-left:50px;">Section : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-60px;">

						<select style="width:150px;" name="sectionid" id="sectionid" class="form-control" required autofocus>
<!-- onchange="searchstudent(this.value);"  -->
						<option value="" selected="selected" disabled>Select Section</option>							

						<?php

						// $qsec=mysqli_query($con,"select * from section where class_id='$class'");

						// while($rsec=mysqli_fetch_array($qsec))

						// {

						?>
<!-- 
						<option <?php if($sectionid==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

						</option> -->

						<?php 

						// }

						?>	

						</select>

						</div>
						<script>

							function search_sec(str)

							{
								// alert(1);

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


						

						<div class="col-md-2" style="font-size:16px;margin-left:60px;">No of Period : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">

						<input type="number" name="tperiod" class="form-control" value="<?php echo $tperiod;?>" 

						required autofocus>

						</div>					

						</div><br>

                     

						<div class="row" style="margin-top:20px;">

						<div class="col-md-2">No of Break : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

						<input type="number" name="tbreak" class="form-control" style="width:150px;" 

						value="<?php echo $tbreak;?>"  autofocus>

						</div>

							

							

						<div class="col-md-2" style="margin-left:50px;">Select Day : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-60px;">

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

						<input type="button" name="load" value="Create"  id="load_btn" class="btn btn-primary btn-sm" style="margin-left:100px;width:120px">

						</div>														

						</div><br>	



						</div><br>	

												

						<!--table starts from here-->

						<?php 

						// if(isset($load))

						// {

						// 	$que = mysqli_query($con,"select * from time_table where class_id='$class' && 

						// 	section_id='$sectionid' && day='$cday'");

						// 	$row = mysqli_num_rows($que);

						// 	if(!$row)

						// 	{

							

						// 	$trow = $tperiod + $tbreak;

											

						?>		

						<div class="card" style="width:1000px">

                            <div class="card-body" id="append_format">

                                

                            </div>

                        </div><br><br>

						

						<div style="text-align:center;display:none;" id="submit_btn_row" >

						<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm" style="margin-left:350px;"/>

						

						<input type="reset" name="reset" value="Cancel" class="btn btn-info btn-sm" style="margin-left:20px;"/>

						

						</div>

						

						<?php

						// 	}

						// 	else

						// 	{

						// 		echo "<script>alert('Time Table Already Scheduled.')</script>";

						// 	}						

						// }

						?>



						

                </div>

            </div>

        </div><!-- .animated -->

        

		

		

		

		

	</form>	

    </div>



 <?php //include('bootstrap_datatable_javascript_library.php'); ?>

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
  
  $('#load_btn').on('click',function(e){	

  	// console.log(this);
  	var cday=$('#cday').find(':selected').val();
  	// alert(cday);
  	if(cday!=""){
   			var action="LoadTimeTableFormat";
       
            $(this).append('<input type="hidden" name="'+ action+'" class="LoadTimeTableFormat" />');   
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
		    		// alert(responce);
		    		if($.trim(responce)=='already') {
		    			toastr.error("Already Created");
		    			// $('#devel-generate-content-form')[0].reset();
		    			$('#append_format').hide();
		    			$('#submit_btn_row').hide();
		    		}else{
		    			$('#append_format').show();
		    			$('#append_format').html(responce);
		    			$('#submit_btn_row').show();
		    		}
 		    	    $('input[type="button"]').attr('disabled',false);
                    $('input[type="button"]').val('Load');
 		       }					
 	    }); 
 	            e.preventDefault();		

 	return false;	
    }else{
    	toastr.error("Please Select Day");
    }

 	 });   
 	

   $('form').on('submit',function(e){	
   	// $('#Attendance-form').preventDefault();
   		e.preventDefault(); 
   		// alert(12);
     if(confirm('Do you want to Create Time Table') ){ 
     			
       	  console.log(this);
         // $("input[type='hidden']").removeAttr('name');	 
            var action ='CreateTimeTable'; 
            $('.LoadTimeTableFormat').removeAttr('name');    
            $('.LoadTimeTableFormat').remove();    
            $(this).append('<input type="hidden" name="'+ action+'"/>');   
            var formData =new FormData($('#devel-generate-content-form')[0]);
            $('input[type="submit"]').attr('disabled',true);
            $('input[type="submit"]').val('Please wait...');
            // $('#saveattendence').val('Please wait...');

            // var formData =$('#Attendance-form').serialize();		
            // console.log(formData);   
            // alert($('#regno').val());         		 		
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
 		    	    	setTimeout(function(){
 		    	    	
 		    	    	// window.location.reload();
 		    	    	// window.location.href = "dashboard.php?option=create_timetable";	
 		    	    		// $('#cday').reset();
 		    	    		$('#cday').prop('selectedIndex',0);
 		    	    		
			    			$('#append_format').html('');
			    			$('#append_format').hide();
			    			$('#submit_btn_row').hide();

 		    	    		},3000);
 		    	    }else{      
 		    	    
 		    	    	toastr.error(responce.msg);	
 		    	    }		
 		    	    $('input[type="submit"]').attr('disabled',false);
                    $('input[type="submit"]').val('Load');
 		       }					
 	    }); 
 	            e.preventDefault();		

 	return false;	  }   
 	   });
 	   });

   // Attendence with sms

 </script>

 