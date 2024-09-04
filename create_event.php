<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



// if(isset($save))

// {

// 	$q1 = $con->query("insert into events (class_id,section_id,creation_date,from_date,to_date,event_for,no_of_days,event_heading,description,status) values('$classid','$sectionid','$creationdate','$fromdate','$todate','$eventfor','$nodays','$eventhead','$description',0)");

	

// 	if(mysqli_error($con)){

// 		echo ("Error description :" .mysqli_error($con)); 		

// 	}

// }

?>



<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

	

	<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}



	</style>

	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>

<!-- breadcrumb-->

<style>

input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Event Calendar</a>

  <span class="breadcrumb-item active"> Create Event</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data" id="devel-generate-content-form"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Date of Creation : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="creationdate" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Event For : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select class="form-control" name="eventfor" id="eventfor" onchange="showcls()" style="width:175px;" autofocus required>

		<option value="" selected="selected" disabled>Select Event for</option>

		<?php

		$ql=mysqli_query($con,"select * from event_type");

		while($rl=mysqli_fetch_array($ql))

		{

		?>

		<option value="<?php echo $rl['event_id']; ?>"><?php echo $rl['event_name'];?>

		</option>

		<?php 

		}

		?>							

		</select>

		</div>

	</div>



	<script>

	function showcls()

	{

		var p = document.getElementById("eventfor").value;

		if(p==2)

		{

			document.getElementById("test").style="display:none";


		}

		else

		{

			document.getElementById("test").style="display:block";

			document.getElementById("classid").required=true;

			// document.getElementById("sectionid").required=true;

		}

		

	}	

	</script>

	

	<div class="row">

	<div class="col-md-12">

		<div class="row" id="test">

			<div class="col-md-2" style="margin-left:35px;margin-top:50px;">Class : </div>

			<div class="col-md-2" style="margin-left:-6px;margin-top:50px;">

			<select style="width:175px;" name="classid" id="classid" class="form-control" 

			onchange="search_sec(this.value);">

			<option selected>All</option>

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

xmlhttp.open("get","search_ajax_staff_section.php?cls_id="+str,true);

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



		<div class="col-md-2" style="margin-left:75px;margin-top:50px;">Section : </div>

		<div class="col-md-2" style="margin-left:-26px;margin-top:50px;">

		<select style="width:175px;" name="sectionid" id="sectionid" class="form-control">

		<option selected="selected">All</option>							

		</select>

		</div>

		</div>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">From Date : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="date" name="fromdate" class="form-control" style="width:175px;" required autofocus>

	</div>

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">To Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="date" name="todate" class="form-control" style="width:175px;" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">No of Days : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" name="nodays" class="form-control" style="width:175px;" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Event Heading : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="eventhead" class="form-control" style="width:580px;height:50px;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:180px;" required autofocus></textarea>

	</div>

	</div>

	<br><br>

	

	<div>

	<input type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>
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


   $('form').on('submit',function(e){	
   	// $('#Attendance-form').preventDefault();
   		e.preventDefault(); 
   		// alert(12);
     if(confirm('Do you want to Create Event') ){ 
     			
       	  // console.log(this);
         // $("input[type='hidden']").removeAttr('name');	 
            var action ='CreteEvent'; 
             
            // $('.LoadTimeTableFormat').remove();    
            $(this).append('<input type="hidden" name="'+ action+'"/>');   
            var formData =new FormData($('#devel-generate-content-form')[0]);
            $('input[type="submit"]').attr('disabled',true);
            $('input[type="submit"]').val('Please wait...');
                 		 		
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
 		    	    	window.location.href = "dashboard.php?option=create_event";			
 		    	    		},3000);
 		    	    }else{      
 		    	    
 		    	    	toastr.error(responce.msg);	
 		    	    }		
 		    	    $('input[type="submit"]').attr('disabled',false);
                    $('input[type="submit"]').val('Save');
 		       }					
 	    }); 
 	            e.preventDefault();		

 	return false;	  }   
 	   });
 	   });



 </script>



