<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

?>

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
<div id="right-panel" class="right-panel">

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <span class="breadcrumb-item active">Download Student Fees</span>
</nav>


   <form method="post" action="dashboard.php?option=download_student_fees" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                              
								<div class="row" style="margin-top:20px;">
								<div class="col-md-2" style="margin-left:10px;">Class</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
								<option value="" selected="selected" disabled >Select Class</option>
								<?php
								$scls = "select * from class";
								$rcls = mysqli_query($con, $scls);
								while( $rescls = mysqli_fetch_array($rcls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								
								<div class="col-md-2" style="margin-left:50px;">Section</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select class="form-control" name="section" id="search_sect" style="width:150px" autofocus required>
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
								<script>
								function search_sec(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_section_att.php?cls_id="+str,true);
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
								
								</div>
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
							    </div>
								<br/>
 
								<div class="row" style="margin-top:20px;">
								<div class="col-md-12" style="margin-left:50px;">
								<?php
								if(isset($search))
								{
								?>	
								<a href="export_student_fees_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success" style="margin-left:250px;">Download Fees</a> 
								<?php
								}
								?>
								</div>
								</div>
								<br/>
								<br/>
								
                            </div>
							
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		
		
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 