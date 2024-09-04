<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

$id = $_REQUEST['id'];



$q = mysqli_query($con,"select * from events where event_id='$id'");

$r = mysqli_fetch_array($q);



$class = $r['class_id'];

$section = $r['section_id'];

$eventfor = $r['event_for'];



// if(isset($update))

// {

// 	$query = mysqli_query($con,"update events set class_id='$nclassid', section_id='$nsectionid', 

// 	creation_date='$ncreationdate', from_date='$nfromdate', to_date='$ntodate', event_for='$neventfor',

// 	no_of_days='$nnodays', event_heading='$neventhead', description='$ndescription' where event_id='$id'");

	

// 	echo "<script>window.location='dashboard.php?option=view_event_calendar'</script>";

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

  <a class="breadcrumb-item" href="#">View Event Calendar</a>

  <span class="breadcrumb-item active">Edit Event Calendar</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data" id="devel-generate-content-form"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2" style="font-size:16px;">Date of Creation : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="ncreationdate" class="form-control" style="width:170px;" 

		value="<?php echo $r['creation_date'] ?>" required autofocus>

		</div>

	</div>



	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:170px;" name="nclassid" id="classid" class="form-control" 

	onchange="search_sec(this.value);">

	<option value="" selected>All</option>

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



	<div class="col-md-2" style="font-size:16px;margin-left:80px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<select style="width:170px;" name="nsectionid" id="sectionid" class="form-control">

	<option value="" selected="selected">All</option>

	<?php

	$ssec = "select * from section where class_id='$class'";

	$rsec = mysqli_query($con, $ssec);

	while( $ressec = mysqli_fetch_array($rsec) ) {

	?>

	<option <?php if($section==$ressec['section_id']){echo "selected";}?> value="<?php echo $ressec['section_id']; ?>"><?php echo $ressec['section_name'];?>

	</option>

	<?php } ?>

	</select>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">From Date : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="date" name="nfromdate" class="form-control" style="width:170px;" 

	value="<?php echo $r['from_date']?>" required autofocus>

	</div>

	

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">To Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="date" name="ntodate" class="form-control" style="width:170px;" 

	value="<?php echo $r['to_date']?>" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Event For : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select class="form-control" name="neventfor" style="width:170px;" autofocus required>

	<option value="" selected="selected" disabled>Select Event for</option>

	<?php

	$ql=mysqli_query($con,"select * from event_type");

	while($rl=mysqli_fetch_array($ql))

	{

	?>

	<option <?php if($eventfor==$rl['event_id']){echo "selected";}?> value="<?php echo $rl['event_id']; ?>"><?php echo $rl['event_name'];?>

	</option>

	<?php 

	}

	?>							

	</select>

	</div>

	<div class="col-md-2" style="font-size:16px;margin-left:80px;">No of Days : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" name="nnodays" class="form-control" style="margin-left:-20px;width:170px;" 

	value="<?php echo $r['no_of_days'];?>" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Event Heading : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="neventhead" class="form-control" style="width:545px;height:50px;" 

	required autofocus> <?php echo $r['event_heading'];?></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="ndescription" class="form-control" style="width:545px;height:180px;" 

	required autofocus> <?php echo $r['description'];?></textarea>
	<input	type="hidden" name="id" value="<?=$_GET['id']?>" />
	</div>

	</div>

	<br><br>

	

	

	<div>

	<button  type="submit" name="update" value="Update" id="add" 

	style="margin-left:390px;" class="btn btn-secondary btn-sm"/>

	<i class='fa fa-edit'></i> Update</button>

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
     if(confirm('Do you want to Update') ){ 
     			
       	  // console.log(this);
         // $("input[type='hidden']").removeAttr('name');	 
            var action ='UpdateEvent'; 
             
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
 		    	    	window.location.href = "dashboard.php?option=view_event_calendar";			
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

