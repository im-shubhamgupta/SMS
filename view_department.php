<script type="text/javascript">
function del(id)
{
	if(confirm("Do You want to Delete"))
	{
		window.location.href='delete_department.php?x='+id;
	}
}
	
</script>
<form method="post">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Staff Panel</a>
  <a class="breadcrumb-item" href="#">Staff Management</a>
  <span class="breadcrumb-item active">View Department</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
        <div class="breadcrumbs" style="width:800px">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=create_department&smid=<?php echo '22';?>" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Create Department</a>
            </div>
        </div>
		<?php
		}
		?>	

        <div class="content mt-3" style="width:800px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Department</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Department</th>
											<th>Action</th>
											
                                        </tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from department");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['dept_id'];
									$name=$res['dept_name'];	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $name; ?></td>
										
									<td>
									<?php echo "<a href='dashboard.php?option=updatedepartment&id=$id&smid=23' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?>
										
									<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>
									</td>
										
									</tr>
                                    <?php 
									$sr++; 
									} ?>
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