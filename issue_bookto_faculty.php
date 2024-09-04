<?php

error_reporting(1);

// extract($_REQUEST);


	

?>	

	



<div id="right-panel" class="right-panel">

<style>



#inp{

	margin-left:-25px;

}



#lab{

	font-weight:bold;

}

</style>



<nav class="breadcrumb" style="width:1000px;">

<a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Library Management</a>

  <a class="breadcrumb-item" href="#">Issue Book</a>

  <span class="breadcrumb-item active">Issue Book to Faculty</span>

</nav>



<h5>Faculty Book Issue</h5>

<br>



<form method="post" enctype="multipart/form-data" multiple>

 	 

<div class="container" style="background-color:#fff;padding-left:10px;padding-right:10px;">

	<div class="row">

	<div class="col-md-4" style="font-weight:bold">ISSUE BOOK TO FACULTY</div>

	</div>

	<br>

	

	<div class="row">

		<div class="col-md-2">Faculty : </div>

		<div class="col-md-2">

		<select name="faculty" id="faculty" class="form-control" onchange="search_sec(this.value)" style="margin-left:-30px;" autofocus required>

		<option value="" selected="selected" disabled >Select Faculty</option>

		<?php

		$qstaff = mysqli_query($con,"select * from staff");

		while( $rst = mysqli_fetch_array($qstaff) ) {

		?>

		<option value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

	</div>

	<br>

	

	<div class="row">

		<div class="col-md-2">Branch : </div>

		<div class="col-md-2">

		<select name="branch" class="form-control" style="margin-left:-30px;" onchange="show_branch_book(this.value)" autofocus required>

		<option value="" selected="selected" disabled >Select Class</option>

		<?php

		$qbr = mysqli_query($con,"select * from branch");

		while( $rbr = mysqli_fetch_array($qbr) ) {

		?>

		<option value="<?php echo $rbr['branch_id']; ?>"><?php echo $rbr['branch_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<script>

		function show_branch_book(str)

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_ajax_branch_book.php?branch_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("showbook").innerHTML=xmlhttp.responseText;

		}

		}

		}

		</script>

		

		<div class="col-md-2">Remark :</div>

		<div class="col-md-2" style="">

		<textarea type="text" name="remark" class="form-control" style="margin-left:-60px;width:250px;"></textarea>

		</div>

	</div>

	<br>

	

	<div class="row">

		<div class="col-md-2">Return Type : </div>

		<div class="col-md-2">

		<select name="returntype" class="form-control" style="margin-left:-30px;" autofocus required>

		<option value="" selected="selected" disabled >Select Class</option>

		<?php

		$qret = mysqli_query($con,"select * from book_return_type");

		while( $rret = mysqli_fetch_array($qret) ) {

		?>

		<option value="<?php echo $rret['book_return_type_id']; ?>"><?php echo $rret['book_return_type_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<div class="col-md-2">Date of Issue :</div>

		<div class="col-md-2">

		<input type="date" name="issuedt" value="<?php echo date('Y-m-d'); ?>" class="form-control" style="margin-left:-60px;width:175px" readonly>

		</div>

		

	</div>

	<br>

	<br>

</div>

	

<div class="container" style="background-color:papayawhip;padding-left:10px;padding-right:10px;">

	<div class="row">

	<div class="col-md-4" style="font-weight:bold">BOOK LIST</div>

	</div>

	<br>

	

	<div class="row">

	<div class="col-md-12">

	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">

	<thead>

		<tr>

			 <th>Sr. No</th>

   			 <th>Book ISBN</th>

   			 <th>Book Name</th>

   			 <th>Book Author</th>

   			 <th>Publisher Name</th>

   			 <th>Available Book</th>

			 <th>Select</th>

		</tr>

	</thead>

	

	<tbody id="showbook">



	</tbody>

	</table>

	

	</div>

	</div>

	<hr>

		

	<div class="row">

	<div class="col-md-10"></div>

	<div class="col-md-1" align="right">

	<input type="submit" name="issue" value="Issue" class="btn btn-primary btn-sm">

	</div>

	<div class="col-md-1" align="right">

	<input type="reset" name="reset" value="Reset" class="btn btn-info btn-sm">

	</div>

	</div>

	<br>

</div>

<br><br>

	



<div class="container" style="background-color:papayawhip;padding-left:10px;padding-right:10px;">

	<div class="row">

	<div class="col-md-4" style="font-weight:bold">ISSUED BOOK LIST</div>

	</div>

	<br>

	

	<div class="row">

	<div class="col-md-12">

	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">

	<thead>

		<tr>

			 <th>Sr. No</th>

   			 <th>Branch</th>

   			 <th>Book Name</th>

   			 <th>Issued Date</th>

   			 <th>Return Date</th>

   			 <th>Returned Date</th>

		</tr>

	</thead>

	

	<tbody>

		<?php

		$sr = 1;

		$q1=mysqli_query($con,"select * from issue_bookto_faculty");

		while($r1=mysqli_fetch_array($q1))

		{



				$facissueid=$r1['faculty_issue_id '];

				$brid=$r1['branch_id'];

				$qbr=mysqli_query($con,"select * from branch where branch_id ='$brid'");

				$rbr=mysqli_fetch_array($qbr);

				$brname=$rbr['branch_name'];

				

				$bkid=$r1['book_id'];

				$qbk=mysqli_query($con,"select * from books where book_id ='$bkid'");

				$rbk=mysqli_fetch_array($qbk);

				$bkname=$rbk['book_name'];

				$issuedt=$r1['issue_date'];

				$issdt = date("d-m-Y",strtotime($issuedt));

				

				$returndt=$r1['return_date'];

				$retdt = date("d-m-Y",strtotime($returndt));

				

				$retstatus=$r1['return_status'];

				if($retstatus==0)

				{

					$status = "Not Returned";

				}

				else if($retstatus==1)

				{

					$status = "Returned";

				}

		?>

		<tr>

			<td><?php echo $sr; ?></td>

			<td><?php echo $brname; ?></td>

			<td><?php echo $bkname; ?></td>

			<td><?php echo $issdt; ?></td>

			<td><?php echo $retdt; ?></td>

			<td><?php echo $status; ?></td>

		</tr>

		

		<?php $sr++; } ?>

		

		

	</tbody>

	</table>

	

	</div>

	</div>

	<hr>

		

	<div class="row">

	<div class="col-md-10"></div>

<!--	<div class="col-md-2" align="right">

	<input type="submit" name="issue" value="Export to Excel">

	</div>-->

	</div>

	<br>

</div>

<br><br>

	

</form>

	

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 <script>

	function ckeck(strr)

		{

		var facid=$("#faculty").val();

		var datastr={"facid":facid,"bkid":strr};

			$.ajax({

				url:'chk_issued_bookstaff.php',

				type:'post',

				data:datastr,

				success:function(str)

				{

					if(str=="true")

					{

						alert("The book is already issued");

						$("#"+strr). prop("checked", false);

					}

				}

			});

		}
			function check_avilable_book(strr){
			// alert(23);
		var chk_avi_book=document.getElementById('avilable_book_qty_'+strr+'').value;
	// alert(chk_avi_book);
			if(chk_avi_book<1){
							alert("Currently book not avilable");
							$("#"+strr). prop("checked", false);
			}

		}

	</script>
		<?php include('datatable_links.php')?>
<script>

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "issue_bookto_faculty";
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
				window.location.href='dashboard.php?option=issue_bookto_faculty';
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