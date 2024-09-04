<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');

?>
<style>

/* Media Query  */
@media only screen and (max-width: 600px)
{
	.col-md-3{
		width:400px;
		
	}
	
}

</style>


<div id="right-panel" class=" right-panel">
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">ID Card</a>
  <span class="breadcrumb-item active">Faculty IDCard</span>
</nav>

	<form method="post" enctype="multipart/form-data">
        <div class="content mt-3" style="width:900px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                            <div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
											<th>Username</th>
											<th>Roles</th>
											<th>Phone</th>
											<th>Select All
											<span><input type="checkbox" name="selectall" id="selectall" style="width:40px"></span>
											</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$query =mysqli_query($con,"SELECT * FROM users");
									
									$sr=1;
									while($res=mysqli_fetch_array($query))
									{
										$userid = $res['user_id'];
										$username = $res['username'];
										$roles = $res['roles'];
										$phone = $res['phone'];
										$q1 = mysqli_query($con,"select * from class where class_id='$clsid'");
										$r1 = mysqli_fetch_array($q1);
										$clsname = $r1['class_name'];
										$secid = $res['section_id'];
										$q2 = mysqli_query($con,"select * from section where section_id='$secid'");
										$r2 = mysqli_fetch_array($q2);
										$secname = $r2['section_name'];
										$fname = $res['father_name'];
										
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $username; ?></td>
										<td><?php echo $roles; ?></td>
										<td><?php echo $phone; ?></td>
										<td><input type="checkbox" class="checkboxall" name="chk[]" value="<?php echo $userid;?>" style="margin-left:30px;"></td>
									</tr>
                                    <?php $sr++; }
									
									?>
                                    </tbody>
                                </table>
                            </div>
							</div>
							
							<div>
							<input type="submit" name="save" value="Generate IDCard" class="btn btn-warning btn-md" style="margin-left:320px">
						
							</div>
							<br> 
														
                    </div>
                </div>
            </div>
            </div><!-- .animated -->
			
</form>
 		
		<?php
		if(isset($save))
		{
			$uid = implode(',',$chk);
			
			echo "<script>window.location='print_faculty_idcard.php?uid=$uid'</script>";
						
		}
		?>

	
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 <script>
 $(document).ready(function()
 {
	$("#selectall").click(function(){
		if(this.checked)
		{
			$('.checkboxall').each(function(){
				$(".checkboxall").prop('checked', true);				
			})
		}
		else
		{
			$('.checkboxall').each(function(){
				$(".checkboxall").prop('checked', false);
			})
		}
		
	});
 }); 
 </script>