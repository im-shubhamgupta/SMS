<?php
error_reporting(1);

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
  <a class="breadcrumb-item" href="#">Report</a>
  <span class="breadcrumb-item active">Book Available Detail</span>
</nav>

<h5>Book Available Detail</h5>
<br>

<form method="post" enctype="multipart/form-data" multiple>
 	 
<div class="container" style="background-color:#fff;padding-left:10px;padding-right:10px;">
	<div class="row">
	<div class="col-md-4" style="font-weight:bold">Book Details</div>
	</div>
	<br>
	
	<div class="row">
		<div class="col-md-2" style="margin-left:50px">Branch : </div>
		<div class="col-md-2">
		<select name="branch" class="form-control" style="margin-left:-30px;" onchange="show_book_detail(this.value)" autofocus required>
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
	</div>
	<br>
	
		<script>
		function show_book_detail(str)
		{
		var xmlhttp= new XMLHttpRequest();	
		xmlhttp.open("get","search_ajax_book_detail.php?branch_id="+str,true);
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
		
	<br>
	<br>
</div>
	
<div class="container" style="background-color:papayawhip;padding-left:10px;padding-right:10px;">
	<div class="row">
	<div class="col-md-4" style="font-weight:bold">Available Book LIST</div>
	</div>
	<br>
	
	<div class="row">
	<div class="col-md-12">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			 <th>Sr. No</th>
   			 <th>Book Name</th>
   			 <th>Total No. of Books </th>
   			 <th>Issued Book</th>
   			 <th>Returned Book</th>
			 <th>Available Book</th>
		</tr>
	</thead>
	
	<tbody id="showbook">

	</tbody>
	</table>
	
	</div>
	
	</div>
	<hr>
	
	
	<!--<div class="row">
	<div class="col-md-10"></div>
	<div class="col-md-2" align="right">
	<a href="export_available_book_detail.php?branchid=<?php echo $class;?>" class="btn btn-success">Export To Excel</a>
	</div>
	</div>-->
	<br>
	
</div>
<br><br>	
</form>
	
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 <script>
	function ckeck(strr)
		{
			
		var stuid=$("#student").val();
		var datastr={"stuid":stuid,"bkid":strr};
			$.ajax({
				url:'chk_issued_book.php',
				type:'post',
				data:datastr,
				success:function(str)
				{
					if(str=="true")
					{
						alert("The book is already issued");
						$("#bookid"). prop("checked", false);
					}
				}
			});
		}
	</script>