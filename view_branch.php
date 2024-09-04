<script type="text/javascript">
	function delet(id)
	{
		if(confirm("Do You want to delete this Book Type???"))
		{
			window.location.href='delete_branch.php?x='+id;
		}
	}
</script>
<form method="post">
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Library Management</a>
   <a class="breadcrumb-item" href="#">Configuration</a>
  <span class="breadcrumb-item active">View Branch</span>
</nav>
<!-- breadcrumb -->
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="library")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_branch" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Add Branch</a>
            </div>
        </div>
		<?php
		}
		?>	

        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Branch</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Book Type</th>
											<th style="width:300px"> Action</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from branch");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['branch_id'];
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['branch_name']; ?></td>
										<td>
										<?php echo "<a href='dashboard.php?option=update_branch&eid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";
											?>
										
										<a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Expense" onclick="delet('<?php echo $id;?>')"><i class="fa fa-trash"></i> Delete</a>
										</td>
																
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