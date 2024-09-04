<?php
//error_reporting(1);
extract($_REQUEST);
		
?>	
	

<div id="right-panel" class="right-panel">

<nav class="breadcrumb" style="width:1000px;">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Staff Panel</a>
  <a class="breadcrumb-item" href="#">Syllabus Management</a>  
  <span class="breadcrumb-item active">Assign Syllabus to Staff</span>
</nav>

<form method="post" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						<div class="row" style="margin-top:20px;">	
													
							<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">Select Staff : </div>
							<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">
							<select style="margin-left:20px;width:150px;" name="class" id="class" class="form-select" 
							onchange="showsubjects(this.value);" required autofocus>
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
						function showsubjects(str)
						{
							//alert(str);
							$.ajax({
								url:'get_ajax_syllabus_subject.php?stid='+str,
								type:'get',
								success:function(data) {
									$('#showsubjects').html(data);
								}
								
							});
						}
						</script>
									
						<!--table starts from here-->
								
						<div id="showsubjects">
						
						</div>
							
                </div>
            </div>
        </div><!-- .animated -->
        
		
	</form>	


</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>