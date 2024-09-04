<?php

error_reporting(1);

include('connection.php');



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

  <a class="breadcrumb-item" href="#">Library Management</a>

  <a class="breadcrumb-item" href="#">Configuration</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_books">View Books</a>

  <span class="breadcrumb-item active">Add Books</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="card-header">

		<strong>Add</strong> Books

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Name : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="bookname" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Book ISBN : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="bookisbn" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Author : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="author" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Publisher : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select style="width:175px;" name="publisherid" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Publisher</option>

		<?php

		$qpub = mysqli_query($con,"select * from publisher");

		while( $rpub = mysqli_fetch_array($qpub) ) {

		?>

		<option value="<?php echo $rpub['publisher_id']; ?>"><?php echo $rpub['publisher_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Books Category : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="booktypeid" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Books Category</option>

		<?php

		$qbk = mysqli_query($con,"select * from book_type");

		while( $rbk = mysqli_fetch_array($qbk) ) {

		?>

		<option value="<?php echo $rbk['book_type_id']; ?>"><?php echo $rbk['book_type_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Quantity : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="number" name="qty" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Price : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="amount" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Vendor : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select style="width:175px;" name="vendorid" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Vendor</option>

		<?php

		$qvn = mysqli_query($con,"select * from vendor");

		while( $rvn = mysqli_fetch_array($qvn) ) {

		?>

		<option value="<?php echo $rvn['vendor_id']; ?>"><?php echo $rvn['vendor_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

	</div>

	

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Branch : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="branchid" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Branch</option>

		<?php

		$qvn = mysqli_query($con,"select * from branch");

		while( $rvn = mysqli_fetch_array($qvn) ) {

		?>

		<option value="<?php echo $rvn['branch_id']; ?>"><?php echo $rvn['branch_name']; ?>

		</option>

		<?php } ?>							

		</select>

	</div>

	</div>



		

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to save?')" type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>
<?php include('datatable_links.php')?>
<script>

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "add_books";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/LibraryControllers.php",
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
				window.location.href='dashboard.php?option=add_books';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('input[type="submit"]').val('Save ');  
	      $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

