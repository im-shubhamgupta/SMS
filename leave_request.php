<?php

error_reporting(1);

include('connection.php');

// extract($_REQUEST);



// if(isset($save))

// {

// 	$img = $_FILES['file']['name'];

// 	if($img=="")

// 	{

// 		$q1 = $con->query("insert into student_leave (student_id,class_id,section_id,submission_date,from_date,to_date,leave_id,total_days,reason,note,status) values('$student','$classid','$sectionid','$subdate','$fromdate','$todate','$leaveid','$nodays','$reason','$note',0)");

		

// 		if(mysqli_error($con)){

// 			echo ("Error description : ". mysqli_error($con));

// 		}

		

// 	}

// 	else

// 	{

// 		$q1 = mysqli_query($con,"insert into student_leave (student_id,class_id,section_id,submission_date,from_date,to_date,leave_id,total_days,reason,note,attachment,status) 

// 		values('$student','$classid','$sectionid','$subdate','$fromdate','$todate','$leaveid','$nodays','$reason','$note',

// 		'$img',0)");

		

// 		if($q1)

// 		{

// 			mkdir("images/leave/$student");

// 			move_uploaded_file($_FILES['file']['tmp_name'],"images/leave/$student/".$_FILES['file']['name']);

// 		}

	

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

  <a class="breadcrumb-item" href="#"> Student Panel</a>

  <a class="breadcrumb-item" href="#"> Leave Management</a>

  <span class="breadcrumb-item active"> Leave Request</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data" id='leaverequestfrom'> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Date of Submission: </div>

		<div class="col-md-2" style="margin-top:8px;margin-left:-5px;margin-top:0px;">

		<input type="date" name="subdate" class="form-control" style="width:180px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Class : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-30px;">

	<select style="width:170px;" name="classid" id="classid" class="form-control" 

	onchange="searchstudent(this.value); search_sec(this.value)" required autofocus>
 <!-- search_subject(this.value); -->
  <!-- totalstu2(this.value)" -->
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

xmlhttp.open("get","search_ajax_staff_section1.php?cls_id="+str,true);

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



	<div class="col-md-2" style="font-size:16px;margin-left:50px;">Section : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-90px;">

	<select style="width:170px;" name="sectionid" id="sectionid" class="form-control" onchange="searchstudent(this.value);" required autofocus>

	<option value="" selected="selected" disabled>Select Section</option>							

	</select>

	</div>



<script>

function searchstudent(str)

{

var xmlhttp= new XMLHttpRequest();	

xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);

xmlhttp.send();

xmlhttp.onreadystatechange=function()

{

if(xmlhttp.status==200  && xmlhttp.readyState==4)

{

document.getElementById("student").innerHTML=xmlhttp.responseText;

}

}

}

</script>



	<div class="col-md-2" style="font-size:16px;margin-left:50px;">Select Student : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-40px;">

	<select style="width:170px;" name="student" id="student" class="form-control" required autofocus>

	<option value="" selected="selected" disabled> All </option>

	</select>

	</div>

	</div>

	

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">From Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-30px;">

	<input type="date" name="fromdate" class="form-control" style="width:170px;" required autofocus>

	</div>

	<div class="col-md-2" style="font-size:16px;margin-left:50px;">To Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

	<input type="date" name="todate" class="form-control" style="width:170px;" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Leave Type : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-30px;">

	<select class="form-control" name="leaveid" style="width:170px;" autofocus required>

	<option value="" selected="selected" disabled>Select Leave</option>

	<?php

	$ql=mysqli_query($con,"select * from leave_type");

	while($rl=mysqli_fetch_array($ql))

	{

	?>

	<option value="<?php echo $rl['leave_id']; ?>"><?php echo $rl['leave_name'];?>

	</option>

	<?php 

	}

	?>							

	</select>

	</div>

	<div class="col-md-2" style="font-size:16px;margin-left:50px;">No of Days : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

	<input type="number" name="nodays" class="form-control" style="width:170px;" required autofocus>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Reason : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-30px;">

	<textarea name="reason" class="form-control" style="width:500px;height:50px;;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Note : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-30px;">

	<textarea name="note" class="form-control" style="width:500px;height:180px;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Attachment : </div>

	<div class="col-md-8" style="margin-top:-8px;margin-left:-30px;">

	<input type="file" name="file" accept="image/*" >

	</div>

	</div><br><br><br>

	

	

	<div>

	<input type="submit" name="save" value="Request For Approval" id="add" style="margin-left:300px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:50px;" class="btn btn-info btn-sm"/>

	</div>



</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script> 
 <script>
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

 

  $(document).ready(function(){	
   $('form').on('submit',function(e){
   	// alert(1);
  	e.preventDefault();

     if( !confirm('Do you want to Apply') ){ 
     		e.preventDefault(); 	
        }else{ 	  
         // $("input[type='hidden']").removeAttr('name');	 
            var action ='LeaveRequest';     
            $(this).append('<input type="hidden" name="'+ action+'"/>');   
            var formData =new FormData($('#leaverequestfrom')[0]);
            // $('#saveattendence').attr('disabled',true);
            // $('#saveattendence').val('Please wait...');
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
 		    	    if(responce.type=='success') {  
 		    	    	toastr.success(responce.msg);	
 		    	    	setInterval(function(){
 		    	    	// $('#attendance').empty();	
 		    	    	// window.location.reload();
 		    	    	window.location.href = "dashboard.php?option=leave_request";			
 		    	    		},3000);
 		    	    }else{      
 		    	    
 		    	    	toastr.error(responce.msg);	
 		    	    }

 		    	    $('input[type="submit"]').attr('disabled',false);
                    $('input[type="submit"]').val('Request For Approval');					
 		        }					
 		    	    			 
 		});         e.preventDefault();		
 	    return false;	  }   
    });
    });

 

</script>