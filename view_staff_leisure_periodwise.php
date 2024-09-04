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
  <span class="breadcrumb-item active"> View Staff Leisure Period Wise</span>
</nav>
<!-- breadcrumb -->
	<form method="post" action="dashboard.php?option=view_timetable" id="devel-generate-content-form" enctype="multipart/form-data">      
	
	<div class="row" style="margin-top:50px;margin-left:20px;">
		<div class="col-md-2">Day :</div>
		<div class="col-md-2">
		<select style="width:170px;margin-left:-70px;" class="form-control" name="day" id="day" required>
		<option value="" selected="selected" disabled>Select Day</option>
		<?php
		$scls = mysqli_query($con,"select * from days");
		while( $rcls = mysqli_fetch_array($scls) ) {
		?>
		<option value="<?php echo $rcls['day_id']; ?>"><?php echo $rcls['day_name']; ?>
		</option>
		<?php } ?>
		</select>
		</div>
		
		<div class="col-md-2" style="font-size:16px;margin-left:80px;">Select Period :</div>
		<div class="col-md-2">
		<select style="width:170px;margin-left:-50px;" name="period" id="period" class="form-control" onchange="showtimetable(this.value);" autofocus required>
		<option value="" selected disabled>Select Period</option>
		<option value="">All</option>
		<?php
		$qp = mysqli_query($con,"select distinct period from staff_timetable");
		while($rp = mysqli_fetch_array($qp))
		{
		?>
		<option value="<?php echo $rp['period']; ?>"><?php echo $rp['period'];?></option>
		<?php
		}
		?>
		</select>
		</div>
		
	</div>
	
		<script>
		function showtimetable(str)
		{
			var dayid = $('#day').val();
			$.ajax({
				url:'get_ajax_staff_leisure_periodwise.php?dayid='+dayid+'&period='+str,
				type:'get',
				success:function(data) {
					$('#showtimetable').html(data);
				}
				
			});
		}
		</script>
	
	<br><br>	
	<!--table starts from here-->
								
		<div id="showtimetable">
		
		</div>

	
	</form>	
    </div>

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
	