<?php
error_reporting(1);
extract($_REQUEST);

?>

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

<nav class="breadcrumb" style="width:1000px">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Staff Panel</a>
  <a class="breadcrumb-item" href="#"> Staff Time Table</a>
  <span class="breadcrumb-item active"> View Staff Time Table</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_timetable" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
													
							<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">Select Staff : </div>
							<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">
							<select style="margin-left:20px;width:150px;" name="class" id="class" class="form-control" 
							onchange="showtimetable(this.value);" required autofocus>
							<option value="" selected="selected" disabled>Select Staff</option>
							<?php
							$st = mysqli_query($con,"select * from staff where status='1'");
							while( $rst = mysqli_fetch_array($st) ) {
							?>
							<option <?php if($staffid==$rst['st_id']){echo "selected";}?> value="<?php echo $rst['st_id']; ?>"><?php echo $rst['staff_name']; ?>
							</option>
							<?php } ?>							
							</select>
							</div>
							
						</div><br>
                    </div><br>	
							
						<script>
						function showtimetable(str)
						{
							var clsid = $('#class').val();
							$.ajax({
								url:'get_ajax_staff_timetable.php?stid='+str,
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
 
	