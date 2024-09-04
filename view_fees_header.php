<script type="text/javascript">
// function del(x)
// {
// 	//alert(x);
// 	var datastring={"id":x};
// 	$.ajax({
// 		url:'delete_fees_header.php',
// 		type:'post',
// 		data:datastring,
// 		success:function(str)
// 		{
// 			if(str!="")
// 			{
// 				if(confirm('The fees header '+str+' cannot be deleted. Contact Administrator.')==true)
// 				{
// 					$("#PTResults").load(location.href+" #PTResults>*","");
// 				}
// 			}
// 			else
// 			{
// 				if(confirm('Do You want to delete this Fee Header?')==true)
// 				{
// 					delet(x);
// 				}
// 			}
          
// 		}
		
// 	});
// }
// 	function delet(id)
// 	{
// 		//alert(id);
// 		var datastring={"del_id":id};
// 	    $.ajax({
// 		url:'delete_fees_header.php',
// 		type:'post',
// 		data:datastring,
// 		success:function(str)
// 		{
// 			if(str=="deleted Successfully")
// 			{
// 				$("#PTResults").load(location.href+" #PTResults>*","");
// 			}
// 			//alert(str);
			
          
// 		}
		
// 	});
// 	}
</script>


 <!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <span class="breadcrumb-item active">View Fees Header</span>
</nav>
<!-- breadcrumb -->  
<div id="right-panel" class="right-panel">     
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>		
		<div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                         <a href="dashboard.php?option=add_fees_header&smid=<?php echo '5';?>" class="btn btn-primary btn-sm">
						 <i class="fa fa-plus"></i>  Add Fee Header</a>
            </div>
        </div>
		<?php
		}
		?>
		
        <div class="content mt-3" style="width:900px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Fees Section</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Fee Heading Name</th>
											
										<?php
										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
										{
										?>		
                                            <th>Action</th>
										<?php
										}
										?>	
											
                                        </tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from fee_header where `deletion_indicator`='0'");
									while($res=mysqli_fetch_array($query))
									{
									$feeid=$res['fee_header_id'];
									$feename=$res['fee_header_name'];                                    									$Type = $res['type'];									if($Type=='1'){										$TypeTex="Monthly";									}else{																					$TypeTex="Yearly";										}
																			
									?>
									
									<td><?php echo $sr; ?></td>
									<td><?php echo $feename.' (<b>'.$TypeTex.'</b>)'; ?></td>
										
									<?php
									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
									{
									?>	
										<td>
										<?php echo "<a href='dashboard.php?option=update_fees_header&fid=$feeid' class='btn btn-secondary btn-sm'> <i class='fa fa-edit' aria-hidden='true'></i> Edit</a>";
											?>
										
										<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $feeid;?>')"> <i class="fa fa-trash" aria-hidden="true"></i> Delete </a>
										
										</td>
									<?php
									}
									?>	
										
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <?php include('datatable_links.php')?>
 <script>
	"use strict";
 function del(x){
	// alert(x);
	if(confirm('Are you sure want to Delete???')===true){
		var datastring={"id":x,
			"ArchiveTable":'fee_header',
			"Archive_dataidtype":'fee_header_id',
			"status": '0' ,
			"ArchiveData":1	
		};
			$.ajax({
			url:'DeletionHandler.php',
			type:'post',
			data:datastring,
			success:function(str){
				if(str=='success'){
					toastr.success("Delete Sucessfully");
					setInterval(function(){
						location.reload();},4000
					);
				}else{
					toastr.error(str);
				}
			}
		});
	}	
}
</script>