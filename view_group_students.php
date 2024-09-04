<?php
error_reporting(1);
extract($_REQUEST);

?>
<script type="text/javascript">
function del(id)
{
	if(confirm("Do You want to Delete"))
	{
		window.location.href='delete_group_assign.php?x='+id;
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

<nav class="breadcrumb" style="width:900px;">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Custome Group</a>
  <span class="breadcrumb-item active">View Group Students</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_timetable" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
													
							<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">Select Group: </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-20px;">
							<select style="width:150px;" name="group" id="group" class="form-control" 
							onchange="showgroup(this.value);" required autofocus>
							<option value="" selected="selected" disabled>Select Class</option>
							<?php
							$qgrp = mysqli_query($con,"select * from custome_group");
							while( $rgrp = mysqli_fetch_array($qgrp) ) {
							?>
							<option value="<?php echo $rgrp['group_id']; ?>"><?php echo $rgrp['group_name']; ?>
							</option>
							<?php } ?>							
							</select>
							</div>
																			
						</div><br>
                     
					</div><br>	
							
						<script>
						function showgroup(str)
						{
							$.ajax({
								url:'get_ajax_group_students.php?grpid='+str,
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
 
 