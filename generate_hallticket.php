<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

?>

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

input[type=checkbox] {
    zoom: 1.8;
	margin-top:5px;
}
</style>
<nav class="breadcrumb" style="width:1000px">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <span class="breadcrumb-item active">Generate Hall Ticket</span>
</nav>
<!-- breadcrumb -->

<form method="post" action="generate_ticket.php" enctype="multipart/form-data" target="_blank"/> 
	<div class="row" style="margin-top:50px;margin-left:20px;">
		<div class="col-md-2">Class : </div>
		<div class="col-md-2" style="margin-top:-8px;">
		<select style="width:175px;" name="class" id="class" class="form-control" 
		onchange="search_sec(this.value);" required autofocus>
		<option value="" selected="selected" disabled>Select Class</option>
		<?php
		$scls = mysqli_query($con,"select * from class");
		while( $rcls = mysqli_fetch_array($scls) ) {
		?>
		<option <?php if($class==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>
		</option>
		<?php } ?>							
		</select>
		</div>
		
		<script>
		function search_sec(str)
		{
		var xmlhttp= new XMLHttpRequest();	
		xmlhttp.open("get","search_ajax_section_withoutall.php?cls_id="+str,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
		if(xmlhttp.status==200  && xmlhttp.readyState==4)
		{
		document.getElementById("section").innerHTML=xmlhttp.responseText;
		}
		} 
		}
		</script>

		<div class="col-md-2" style="margin-left:80px;">Section : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">
		<select style="width:175px;" name="section" id="section" onchange="searchstudent(this.value);" 
		class="form-control" required autofocus>
		<option value="" selected="selected" disabled>Select Section</option>
		<?php
		$qsec = mysqli_query($con,"select * from section where class_id='$class'");
		while( $rsec = mysqli_fetch_array($qsec) ) {
		?>
		<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name']; ?>
		</option>
		<?php } ?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2" style="font-size:16px;">Hall Ticket Header : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<input type="text" name="ticket_header" class="form-control" style="width:320px;" required autofocus>
	</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2" style="font-size:16px;">Select Exam : </div>
	<div class="col-md-2" style="margin-top:-8px;">
		<select style="width:175px;" name="exam" class="form-control" required autofocus>
		<option value="" selected="selected" disabled>Select Exam</option>
		<?php
		$qex = mysqli_query($con,"select distinct(test_name) from test");
		while( $rex = mysqli_fetch_array($qex) ) {
		?>
		<option <?php if($exam==$rex['test_name']){echo "selected";}?> value="<?php echo $rex['test_name']; ?>"><?php echo $rex['test_name']; ?>
		</option>
		<?php } ?>							
		</select>
	</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Instructions :  </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<select class="form-control" name="instr" id="instr" style="width:175px;" onchange="instruct()" autofocus required>
	<option value="yes">Yes</option>
	<option value="no">No</option>
	</select>
	</div>
	</div>

	<script>
	function instruct()
	{
		var p = document.getElementById("instr").value;
		if(p == "no")
		{
			document.getElementById("demo").style="display:none";
			document.getElementById("description").required=false;
		}
		else
		{
			document.getElementById("demo").style="display:block";
			document.getElementById("description").required=true;
		}
	}
	</script>

	
	<div class="row">
	<div class="col-md-12">
	<div class="row" id="demo">
	<div class="col-md-2" style="margin-left:35px;margin-top:50px;">
	<textarea name="description" id="description" class="form-control" style="width:580px;height:100px;" autofocus required></textarea>
	</div>
	</div>
	</div>
	</div>
	<br><br>
	
	<div>
	<input type="submit" name="save" value="Generate" style="margin-left:390px;" class="btn btn-primary btn-sm"/>
	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>
	</div>

</form>
