<?php
error_reporting(1);
extract($_REQUEST);

?>
<script type="text/javascript">
function del(id)
{
	if(confirm("Do You want to Delete"))
	{
		window.location.href='delete_dept_assign.php?x='+id;
	}
}
	
</script>

	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

	</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
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
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Staff Panel</a>
  <a class="breadcrumb-item" href="#">Staff Management</a>
  <span class="breadcrumb-item active">View Assign Department</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_timetable" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
													
							<div class="col-md-3" style="margin-top:-8px;margin-left:50px;">Select Department: </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-20px;">
							<select style="width:190px;" name="group" id="group" class="form-control" 
							onchange="showdept(this.value);" required autofocus>
							<option value="" selected="selected" disabled>Select Department</option>
							<?php
							$qgrp = mysqli_query($con,"select * from department");
							while( $rgrp = mysqli_fetch_array($qgrp) ) {
							?>
							<option value="<?php echo $rgrp['dept_id']; ?>"><?php echo $rgrp['dept_name']; ?>
							</option>
							<?php } ?>							
							</select>
							</div>
																			
						</div><br>
                     
					</div><br>	
							
						<script>
						function showdept(str)
						{
							//alert(str);
							$.ajax({
								url:'get_ajax_dept_staff.php?deptid='+str,
								type:'get',
								success:function(data) {
									$('#showtimetable').html(data);
								}
								
							});
						}
						</script>
									
						<!--table starts from here-->
								
						<div id="showtimetable">
						
						</div>
							
                </div>
            </div>
        </div><!-- .animated -->
        
		
	</form>	
    </div>

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 