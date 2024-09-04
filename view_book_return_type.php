<script type="text/javascript">
	function delet(id)
	{
		if(confirm("Do You want to delete this Book Return Type???"))
		{
			window.location.href='delete_book_returntype.php?x='+id;
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
  <span class="breadcrumb-item active">View Book Return Type</span>
</nav>
<!-- breadcrumb -->
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="library")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_book_return_type" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Add Book Return Type</a>
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
                                <strong class="card-title">View Publisher</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Book Return Type</th>
                                            <th>Return Days</th>
                                            <th>Book Fine (Per Day)</th>
                                            <th>Remarks</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$qu=mysqli_query($con,"select * from book_return_type");
									while($res=mysqli_fetch_array($qu))
									{
									$id=$res['book_return_type_id'];
									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['book_return_type_name']; ?></td>
										<td><?php echo $res['return_type_days']; ?></td>
										<td><?php echo $res['book_fine_per_day']; ?></td>
										<td><?php echo $res['remarks']; ?></td>
										<td><?php echo "<a href='dashboard.php?option=update_book_return_type&eid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?></td>
										<td><a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Books" onclick="delet('<?php echo $id;?>')"><i class="fa fa-trash"></i> Delete</a></td>
																
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