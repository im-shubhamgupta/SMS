<script type="text/javascript">
	function delet(id)
	{
		if(confirm("Do You want to delete???"))
		{
			window.location.href='delete_staff_idcardimage.php?x='+id;
		}
	}
</script>
<form method="post">
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">ID Card</a>
  <span class="breadcrumb-item active">View & Upload Faculty Image</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                <a href="dashboard.php?option=upload_faculty_image" class="btn btn-primary btn-sm">
				<i class="fa fa-plus"></i> Upload Image</a>
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
                                <strong class="card-title">View uploaded Image</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Staff Id</th>
											<th>Image</th>
											 
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
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from staff_idcard");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['id'];
									$sid=$res['staff_id'];									
									$pic=$res['pic'];									
									?>
									<tr>
										<td><?php echo $sr; ?></td>	
										<td><?php echo $sid; ?></td>
										<td><a href="gallery/staffidcard/<?php echo $pic;?>"><img src="gallery/staffidcard/<?php echo $pic;?>" width='90px' height='90px' style="border-radius:50%"/></td>
															
								<?php
								if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
								{
								?>			
										<td>
										
										<?php echo "<a href='dashboard.php?option=update_upload_faculty_image&id=$id' class='btn btn-secondary btn-sm px-2'>Edit <i class='fa fa-edit' aria-hidden='true'></i></a>"?>
																			
										<a title="Delete Section" class="btn btn-danger btn-sm text-white" onclick="delet('<?php echo $id;?>')">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>
										
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