<?php
error_reporting(1);
extract($_REQUEST);
	// echo "<pre>";
	// print_r($_REQUEST);
	// echo "</pre>";
if(isset($return))
{

		$rettype=$_REQUEST['returntype'];
		
		$id=$_REQUEST['issid'];
		$retdt1=$_REQUEST['returndt1'];
		$retdt2=$_REQUEST['returndt2'];
		
		if($rettype=="stu")
		{
			foreach($id as $val)
			{
							
			$que=mysqli_query($con,"update issue_bookto_students set return_status='1', returned_date='$retdt1' where issue_id='$val'");
			
			}
		}
		else if($rettype=="fac")
		{
			foreach($id as $val)
			{
							
			$que=mysqli_query($con,"update issue_bookto_faculty set return_status='1', returned_date='$retdt2' where issue_id='$val'");
			
			}
		}		 	 
		
		// echo "<script>window.location='dashboard.php?option=return_book'</script>";	
	
}
	
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
  <span class="breadcrumb-item active">Book Return</span>
</nav>

<h5>Return Book </h5>
<br>

<form method="post" enctype="multipart/form-data" multiple id="return_book_form">
 	 	
<div class="container" style="background-color:#fff;">
	
	<div class="row">
		<div class="col-md-3" style="font-weight:bold">
		Student Return <input type="radio" name="returntype" id="stu_return_book" value="stu" <?php if($returntype=="stu"){echo "checked";}?> checked>
		</div>
		<div class="col-md-3" style="font-weight:bold">
		Faculty Return <input type="radio" name="returntype" id="fac_return_book" value="fac" <?php if($returntype=="fac"){echo "checked";}?>>
		</div>
	</div>
	<br><br>
	
	
	<div class="row stu selectt stu_div">
	<div class="col-md-12" style="background-color:papayawhip;">
		<h5>Student Book Return</h5>
		<br>
		<div class="row">
		<div class="col-md-2">Class : </div>
		<div class="col-md-2">
		<select name="class" class="form-control" onchange="searchstudent(this.value);search_sec(this.value)" style="margin-left:-30px;">
		<option value="" selected="selected" disabled >Select Class</option>
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
		xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);
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
		
		<div class="col-md-2">Section :</div>
		<div class="col-md-2">
		<select class="form-control" onchange="searchstudent(this.value);" name="section" id="search_sect" 
		style="margin-left:-60px;width:162px;">
		<option value="" selected disabled>Select Section</option>
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
		</div>
		<br>
	
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
	
		<div class="row">
		<div class="col-md-2">Student Name : </div>
		<div class="col-md-2">
		<select name="student" id="student" class="form-control" onchange="search_fathername(this.value)" 
		style="margin-left:-30px;">
		<option value="" selected="selected" disabled >Select Student</option>						
		<?php
		// $qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'");

		$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and sr.class_id='$class' && sr.section_id='$section' "; //and sr.session='".$_SESSION['session']."'
		$qstu=mysqli_query($con,$sql1);
		while($rstu=mysqli_fetch_array($qstu))
		{
		?>
		<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>
		</option>
		<?php 
		}
		?>	
		</select>
		</div>
		
		<script>
		function search_fathername(str)
		{
		var xmlhttp= new XMLHttpRequest();	
		xmlhttp.open("get","search_parentdetail.php?stu_id="+str,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
		if(xmlhttp.status==200  && xmlhttp.readyState==4)
		{
		document.getElementById("fathername").value=xmlhttp.responseText;
		}
		} 
		}
		
		
		function show_issued_book(str)
		{
		var xmlhttp= new XMLHttpRequest();	
		xmlhttp.open("get","show_issued_book_student.php?stu_id="+str,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
		if(xmlhttp.status==200  && xmlhttp.readyState==4)
		{
		document.getElementById("showbooks").innerHTML=xmlhttp.responseText;
		}
		} 
		}
		</script>
		
		<div class="col-md-2">Father Name :</div>
		<div class="col-md-2">
		<input type="text" name="fathername" id="fathername" value="<?php echo $fathername;?>" class="form-control" style="margin-left:-60px;width:162px;" readonly>
		</div>
		</div>
		<br>
		
		
		<div class="row">
		<div class="col-md-2">Returning Date : </div>
		<div class="col-md-3">
		<input type="date" name="returndt1" class="form-control" value="<?php echo date('Y-m-d'); ?>" style="margin-left:-30px;width:180px" readonly>
		</div>
		</div>
		<br>
		<br>
		<br>
		
	</div>
	</div>

	
	
	<div class="row fac selectt fac_div" style="display:none">
	<div class="col-md-12" style="background-color:papayawhip;padding-left:10px;padding-right:10px;">
		<h5>Faculty Book Return</h5>
		<br>
		
		<div class="row">
		<div class="col-md-2">Search Faculty : </div>
		<div class="col-md-2">
		<select name="faculty" class="form-control" onchange="search_sec(this.value)" style="margin-left:-30px;width:180px">
		<option value="" selected="selected" disabled >Select Faculty</option>
		<?php
		$sst = mysqli_query($con,"select * from staff");
		while( $rst = mysqli_fetch_array($sst) ) {
		?>
		<option <?php if($faculty==$rst['st_id']){echo "selected";}?>  value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>
		</option>
		<?php } ?>							
		</select>
		</div>
		</div>
		<br>
		
		<div class="row">
		<div class="col-md-2">Returning Date : </div>
		<div class="col-md-2">
		<input type="date" name="returndt2" class="form-control" value="<?php echo date('Y-m-d'); ?>" style="margin-left:-30px;width:180px" readonly>
		</div>
		</div>
		<br>
		<br>
		<br>
		
	</div>
	</div>
	
	
		<div class="row">
		<div class="col-md-2">
		<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-80px;margin-left:150px;width:80px;" value="Load"><br><br>
		</div>
		</div>
		
</div>

<script type="text/javascript">
	$(document).ready(function() {
	 if($('#fac_return_book').is(':checked')){
    	// alert('faculty');
		  $('.stu_div').hide(); 
		  $('.fac_div').show(); 

    }
});

</script>
	
<?php 
if($search)
{
	$retype=$_REQUEST['returntype'];
	
	if($retype=="stu")
	{
	$q=mysqli_query($con,"select * from issue_bookto_students where student_id='$student' && return_status='0'");
	}
	else if($retype=="fac")
	{
	$q=mysqli_query($con,"select * from issue_bookto_faculty where st_id='$faculty' && return_status='0'");	
	}
?>	
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
   			 <th>Book Name</th>
   			 <th>Issued Date</th>
   			 <th>Return Date</th>
   			<!-- <th>Paid Fine</th>
   			 <th>Returned Date</th>
   			 <th>Remaining Fine</th>
   			 <th>Raying Fine</th>-->
   			 <th>Select</th>
		</tr>
	</thead>
	
	<tbody id="showbooks">
<?php
$sr =1;

while($res1=mysqli_fetch_array($q))
{		
	// echo "<pre>";
	// print_r($res1);
	// echo "</pre>";
		if(!isset($res1['issue_id'])){
			    $issueid=$res1['faculty_issue_id'];
		}else{
			$issueid=$res1['issue_id'];
		}
		
		$bkid=$res1['book_id'];
		$q1=mysqli_query($con,"select * from books where book_id='$bkid'");
		$r1=mysqli_fetch_array($q1);
		$bkname=$r1['book_name'];
		
		$issdt=$res1['issue_date'];
		$chgissdt = date("d-m-Y",strtotime($issdt));
		
		$retdt=$res1['return_date'];
		$chgretdt = date("d-m-Y",strtotime($retdt));
		
		
?>
	
		<tr>
		<td><?php echo $sr; ?></td>
		<td><?php echo $bkname; ?></td>
		<td><?php echo $chgissdt; ?></td>
		<td><?php echo $chgretdt; ?></td>
		
		<td><input type="checkbox" name="issid[]" id="issid" value="<?php echo $issueid;?>"></td>
		</tr>
	
<?php $sr++; 
}
?>	
	</tbody>
	</table>
	
	</div>
	</div>
	<hr>
		
	<div class="row">
	<div class="col-md-11"></div>
	<div class="col-md-1" align="right">
	<input type="submit" name="return" value="Return" id="return_btn" class="btn btn-primary btn-sm">
	</div>
	</div>
	<br>
</div>
<?php 
}
?>
<br><br>

	
</form>
	
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 <script>
 $(document).ready(function() {
    $('input[type="radio"]').click(function() {
		var inputValue = $(this).attr("value"); 
		var targetBox = $("." + inputValue); 
		$(".selectt").not(targetBox).hide(); 
		$(targetBox).show(); 
    });

   
});
 </script>
  	<?php include('datatable_links.php')?>
<script>

	"use strict";
$(document).ready(function(){
$('#return_btn').on('click', function (e) {
	e.preventDefault();
  var action = "return_book";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData($('#return_book_form')[0]);
	$(this).val("please wait...");  
	$(this).attr("disabled", true);

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
				window.location.href='dashboard.php?option=return_book';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$(this).val('Return');  
	      $(this).attr("disabled", false);
		}
	})
});

});

</script>

 