<script type="text/javascript">
// function del(x)
// {
// 	//alert(x);
// 	var datastring={"id":x};
// 		$.ajax({
// 		url:'delete_class.php',
// 		type:'post',
// 		data:datastring,
// 		success:function(str)
// 		{
// 			if(str=='true')
// 			{
// 				if(confirm('Cannot Delete Class. Students, Fees and Sections are linked with this Class.')==true)
// 				{
// 					$("#PTResults").load(location.href+" #PTResults>*","");
// 				}
// 			}
// 			else
// 			{
// 				if(confirm('Do you want to delete the Class and associated Sections?')==true)
// 				{
// 					delet(x,3);
// 				}
// 			}
          
// 		}
		
// 	});
// }
	
// function delet(id)
// {
// 	//alert(id);
// 	var datastring={"del_id":id};
// 	$.ajax({
// 	url:'delete_class.php',
// 	type:'post',
// 	data:datastring,
// 	success:function(str)
// 	{
// 		if(str=="deleted Successfully")
// 		{
// 			$("#PTResults").load(location.href+" #PTResults>*","");
// 		}
// 		//alert(str);
		
	  
// 	}
	
// });
// }
</script>

<form method="post">
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <a class="breadcrumb-item" href="#">Class</a>
  <span class="breadcrumb-item active">View Class</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_class&smid=<?php echo '1';?>" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Add Class</a>
            </div>
        </div>
		<?php
		}
		?>	
		<!-- style="width:900px" -->
        <div class="content mt-3" >
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Class</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Class</th>
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
									$query=mysqli_query($con,"select * from class where `deletion_indicator`='0' ");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['class_id'];
									$smid=3;
									$name=$res['class_name'];	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $name; ?></td>
				<!-- For Permission -->						
								<?php
								if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
								{
								?>
										
									<td>
									<?php echo "<a href='dashboard.php?option=updateclass&cid=$id&smid=2' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?>
										
									<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>
									</td>
										
								<?php
								}
								?>										
				<!-- For Permission -->	
				
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
	</form>
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <?php include('datatable_links.php')?>
 <script>
	"use strict";
 function del(x){
	// alert(x);
	if(confirm('Are you sure want to Delete???')===true){
		
		var datastring={"id":x,
			"ArchiveTable":'class',
			"Archive_dataidtype":'class_id',
			"status": '0' ,
			"ArchiveData":1	
		};
			$.ajax({
			url:'DeletionHandler.php',
			type:'post',
			data:datastring,
			success:function(str){
				if(str=='success'){
					toastr.success("Delete Sucessfully")
					setInterval(function(){
						location.reload();},4000
					);
					// $(element).closest('tr').fadeOut();
					
				}else{
					toastr.error(str);
				}
			}
		});
	}	
}


	// 			window.location.href='dashboard.php?option=add_class&smid=1';
	// 						// $('form')[0].reset(); 
	// 			},3000);
			
	// 		}else{
	// 			toastr.error(result.message);
	// 		}
	// 		$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add Class');  
	//       $('button[type="submit"]').attr("disabled", false);
	// 	}
	// })

</script>