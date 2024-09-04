<?php
error_reporting(1);
// include('myfunction.php')
// include('connection.php');
// extract($_REQUEST);


?>
<style>
	table{
		width:inherit !important;
	}
	</style>

<div id="right-panel" class="right-panel">

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <span class="breadcrumb-item active">View Late Fee Assign to Class</span>
</nav>


<?php
if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
{
?>		
<div class="breadcrumbs" style="width:1020px">
	<div class="col-sm-4" style="padding:10px;">  
	<a href="dashboard.php?option=assign_late_fee_to_class" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i>Assign Late fee to Class </a>
	</div>
</div>
<?php
}
?>

   <form method="post" action="dashboard.php?option=view_assign_fees_students" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1050px">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                              
								
							<!-- table-responsive -->
							<div class="card-body">
                                <!-- <table id="bootstrap-data-table-export" class="table table-striped table-bordered "> -->
                                <table id="table-grid" class="table table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Class Name</th>
											 									
											 <th>Late Fees</th>
											 <th>Days</th>
											 <th>Create Date</th>
											 <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sql="SELECT * FROM `late_fee` WHERE 1 and session='".$_SESSION['session']."' group by class_id order by class_id ASC" ;
									$chkQuery = mysqli_query($con,$sql );
	   	                            if(mysqli_num_rows($chkQuery)>0){
									$sr=1;
									while($res=mysqli_fetch_assoc($chkQuery)){ 
									$qcls=mysqli_query($con,"select * from class where class_id='".$res['class_id']."'");
										$rcls=mysqli_fetch_assoc($qcls);
										$stuclass = $rcls['class_name'];	

									 ?>
									
									<tr>
										<td><?php echo $sr; ?></td>

										<td><?php echo $stuclass; ?></td>
										<td><?php echo $res['late_fee_amount']; ?></td>
										<td><?php echo $res['late_fee_date'] ?></td>
										<td><?php echo date('d-m-Y', strtotime($res['create_date'])) ?></td>
										<td><a href="dashboard.php?option=edit_assign_fees_to_class&classid=<?=$res['class_id']?>" target="_blank"  class="btn btn-success " >Edit</a>  
											<input type="hidden" value="<?=$res['id']?>" name="id">
											<!-- <button id="del_late_fee" type="button"  class="btn btn-danger" onclick="return confirm('Are you sure want to Delete ?')" >Delete </button> -->
										</td>
										<!-- btn-sm -->
									</tr>
                                    <?php
									$sr++; 
									}
									
									}else{
										echo "<tr><td colspan='5'>No Data Found </td></tr>";
										} 
									
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<!--
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->
		
		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php// include('bootstrap_datatable_javascript_library.php'); ?>
 <?php
 include('datatable_links.php'); ?>

	<script>
	 $(document).ready(function(){
			var dataTable = $("#table-grid").DataTable({
                    // "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // //'order':[7,'ASC'],
                    // dom: 'Blfrtip',
					"scrollX": true,
                    // "pageLength":25,
				});
			});
	</script>		
?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>

	$(document).ready(function(){	
  toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	
		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "3000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					});
	"use strict";
$(document).ready(function(){
$('#del_late_fee').on('click', function (e) {
	e.preventDefault();
  // var action = "delete_late_assign_fee";
	// $(this).append("<input type='hidden' name="+action+" >");
	var id=$("input[type='hidden']").val();  
	var data_string='id='+id+'&delete_late_assign_fee='+0;
	// var data_string=$(this).serialize()+'&delete_late_assign_fee=';
		// console.log(data_string);
	// var data_string=new FormData(this);
	// $("button[type='submit']").html("please wait...");  
	// $('button[type="submit"]').attr("disabled", true);
	$.ajax({
		url:"Controllers/ConfigurationControllers.php",
		type:"POST",
		data:data_string,
		// contentType:false,
		// cache:false,
		// processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			
			// console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				// window.location.href='dashboard.php?option=add_class&smid=1';
							// $('form')[0].reset(); 
					location.reload();
				},3000);
			
			}else{
				toastr.error(result.message);
			}
		// 	$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add Class');  
	      // $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
 
 