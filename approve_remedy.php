<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

$user=$res['username'];




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

<nav class="breadcrumb" style="width:1000px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <a class="breadcrumb-item" href="#"> Remedies Management</a>

  <span class="breadcrumb-item active"> Approve Remedy</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

				

		<div class="col-md-3">Enter Remedies No : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-89px">

		<select style="width:180px;" name="remedyno" class="form-control" 

		onchange="search_sec(this.value);" required autofocus>

		<option value="" selected="selected" disabled>Select Remedy No</option>

		<?php

		$scls = mysqli_query($con,"select * from remedy");

		while( $rcls = mysqli_fetch_array($scls) ) {

		?>

		<option value="<?php echo $rcls['remedy_id']; ?>"><?php echo $rcls['rid']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Improvements : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="improvement" class="form-control" style="width:545px;height:50px;" autofocus required></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Improvements Proofs : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file" style="margin-top:5px;" accept="image/*" autofocus required />

	</div>

	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Approved By : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="text" name="approvedby" class="form-control" style="margin-top:5px;width:170px;" autofocus required />

	</div>

	</div>

		

	<br/><br/>

	<div>

	<input type="submit" name="approve" value="Approve" style="margin-left:390px;" class="btn btn-primary btn-sm"/>



	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "approve_remedy";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/AdministrationControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				window.location.href='dashboard.php?option=approve_remedy';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val("Approve");  
	$('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

