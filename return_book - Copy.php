<?php
error_reporting(1);
extract($_REQUEST);
if(isset($return))
{
		$book_id=$_REQUEST['bookid'];
			 	 
		foreach($book_id as $val)
		{
						
		 $que=mysqli_query($con,"update issue_bookto_students set return_status='1' where issue_id='$issid'");
		
		}
		
		echo "<script>alert('Successfully book is returned');window.location='dashboard.php?option=return_book'</script>";	
	
}
	
?>	
	

<div id="right-panel" class="right-panel">

<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

#inp{
	margin-left:-25px;
}

#lab{
	font-weight:bold;
}
</style>

<nav class="breadcrumb" style="width:1050px;">
<a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Library Management</a>
  <span class="breadcrumb-item active">Book Return</span>
</nav>

<h5>Return Book </h5>
<br>

<form method="post" enctype="multipart/form-data" multiple>
 	 	
<div class="container" style="background-color:#fff;">
	
	<div class="row">
		<div class="col-md-3" style="font-weight:bold">
		Student Return <input type="radio" name="colorRadio" value="C"/>
		</div>
		<div class="col-md-3" style="font-weight:bold">
		Faculty Return <input type="radio" name="colorRadio" value="Cplus"/>
		</div>
	</div>
	<br><br>
	
	
	<div class="row C selectt">
	<div class="col-md-12" style="background-color:papayawhip;">
		<h5>Student Book Return</h5>
		<br>
		<div class="row">
		<div class="col-md-2">Class : </div>
		<div class="col-md-2">
		<select name="class" class="form-control" onchange="search_sec(this.value)" style="margin-left:-30px;" autofocus required>
		<option value="" selected="selected" disabled >Select Class</option>
		<?php
		$scls = "select * from class";
		$rcls = mysqli_query($con, $scls);
		while( $rescls = mysqli_fetch_array($rcls) ) {
		?>
		<option value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
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
		style="margin-left:-60px;width:162px;" required>
		<option value="" selected disabled>Select Section</option>
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
		<select name="student" id="student" class="form-control" onchange="search_fathername(this.value), show_issued_book(this.value)" 
		style="margin-left:-30px;" autofocus required>
		<option value="" selected="selected" disabled >Select Student</option>						
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
		<input type="text" name="fathername" id="fathername" class="form-control" style="margin-left:-60px;width:162px;" readonly>
		</div>
		</div>
		<br>
		
		
		<div class="row">
		<div class="col-md-2">Returning Date : </div>
		<div class="col-md-3">
		<input type="date" name="returndt" class="form-control" value="<?php echo date('Y-m-d'); ?>" style="margin-left:-30px;width:180px" readonly>
		</div>
		</div>
		<br>
		<br>
		
	</div>
	</div>

	
	
	<div class="row Cplus selectt" style="display:none">
	<div class="col-md-12" style="background-color:papayawhip;padding-left:10px;padding-right:10px;">
		<h5>Faculty Book Return</h5>
		<br>
	</div>
	</div>
	<br>
</div>
	
	
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
	
	</tbody>
	</table>
	
	</div>
	</div>
	<hr>
		
	<div class="row">
	<div class="col-md-11"></div>
	<div class="col-md-1" align="right">
	<input type="submit" name="return" value="Return">
	</div>
	</div>
	<br>
</div>
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
 