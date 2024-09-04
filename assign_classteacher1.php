<?php
//error_reporting(1);
extract($_REQUEST);
if(isset($assign))
{
	 $chksub=$_REQUEST['staf'];
	 if($chksub=="")
	 {
		 echo "<script>alert('Please Select Faculty')</script>";
	 }
	 else
	 {
		  foreach($chksub as $val)
		 {
			
		 $que=mysqli_query($con,"insert into assign_clsteacher (class_id,section_id,st_id) 
		 values ('$class','$section','$val')");
		 }
		  echo "<script>window.location='dashboard.php?option=assign_classteacher'</script>";
			
	 }
	 
	
}
	

if(isset($deassign))
{
	 $destaff=$_REQUEST['dstaf'];
	 if($destaff=="")
	 {
		 echo "<script>alert('Please Select Faculty to De-Assign')</script>";
	 }
	 else
	 {
		 foreach($destaff as $val1)
		 {
			$que1=mysqli_query($con,"delete from assign_clsteacher where assign_clst_id='$val1'");
		 }
		
			echo "<script>window.location='dashboard.php?option=assign_classteacher'</script>";
			
	 }
	 
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

<nav class="breadcrumb" style="width:1200px;">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
   <span class="breadcrumb-item active">Assign Class Teacher</span>
</nav><br>

<form method="post" enctype="multipart/form-data" multiple>
 
<h6>ASSIGN CLASS TEACHER</h6>	 
<div class="container-fluid" style="background-color:#fff;padding-top:50px;padding-bottom:10px;padding-left:10px;padding-right:10px;text-align:center">
	<div class="row">
		
		<div class="col-md-1"></div>
		<div class="col-md-1"><span id="lab">Class : </span></div>
		<div class="col-md-3">
		<select name="class" id="class" class="form-control" onchange="search_sec(this.value);" autofocus required>
		<option value="" selected="selected" disabled >---Select Class---</option>
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
		
		<div class="col-md-1"></div>
		<div class="col-md-1"><span id="lab">Section :</span></div>
		<div class="col-md-3">
		<select class="form-control" name="section" id="search_sect" onchange="search_assign_class_teacher(this.value);" required>
		<option value="" selected disabled>All</option>
		</select>
		</div>
		
		<script>
		function search_assign_class_teacher(str)
		{
			var clsid = $("#class").val();
			$.ajax({
				url:'get_ajax_assign_classteacher.php?sec_id='+str+'&classid='+clsid,
				type:'get',
				success:function(data) {
					if(!data=='')	
					{
					alert('Already Assigned Class Teacher to class '+data);
					$('#student').prop('selectedIndex',0);
					}
				}
				
			});
		}
		</script>
							
	</div><br></br>
	
</div>
<br><br><br>
		
	
<h6>EXISTING FACULTIES</h6>	
<div class="container-fluid" style="background-color:#fff;padding-top:20px;padding-bottom:20px;text-align:center">
<div class="row">

	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			 <th>Sr. No</th>
   			 <th>Faculty</th>
			 <th>Select</th>
		</tr>
	</thead>
	
	<tbody>
	<?php 
	$sr=1;
	$query1=mysqli_query($con,"SELECT  * FROM staff");
	
	while($res1=mysqli_fetch_array($query1))
	{
		$stid=$res1['st_id'];
		$stname=$res1['staff_name'];
	?>
	<tr>
		<td><?php echo $sr; ?></td>
		<td><?php echo $stname; ?></td>
		<td><input type="checkbox" class="form" name="staf[]" value="<?php echo $stid;?>"></td>
	</tr>
	<?php $sr++; } ?>
	
	<tr>
	<td colspan="3" align="right"><input type="submit" name="assign" value="Assign"></td>
	</tr>
	</tbody>
	</table>

</div>
</div>
<br><br><br>
</form>

<h6>ASSIGNED FACULTIES</h6>	
<form method="post" enctype="multipart/form-data" multiple>	
<div class="container-fluid" style="background-color:#fff;padding-top:20px;padding-bottom:20px;text-align:center">
<div class="row">
<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			 <th>Sr. No</th>
   			 <th>Faculty</th>
			 <th>Select</th>
		</tr>
	</thead>
	
	<tbody>
	<?php 
	$sr=1;
	$query1=mysqli_query($con,"select * from assign_clsteacher");
	while($res1=mysqli_fetch_array($query1))
	{
	$asclid=$res1['assign_clst_id'];
	$stid=$res1['st_id'];
	$arr=explode(',',$stid);
	
	foreach($arr as $key)
	{
		$query2=mysqli_query($con,"select * from staff where st_id='$key'");
		$res2=mysqli_fetch_array($query2);
		$stfname=$res2['staff_name'];
	
	?>
	<tr>
		<td><?php echo $sr; ?></td>
		<td><?php echo $stfname; ?></td>
		<td><input type="checkbox" class="form" name="dstaf[]" value="<?php echo $asclid;?>"></td>
	</tr>
	<?php $sr++; }} ?>
	
	<tr>
	<td colspan="3" align="right"><input type="submit" name="deassign" value="De-Assign"></td>
	</tr>
	</tbody>
</table>

</div>
</div>
<br><br><br>
</form>
		
	
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>