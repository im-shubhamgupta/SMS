<script type="text/javascript">
	function delet(id)
	{
		if(confirm("Deleting Route will delete all associated Transport Routes. Do you want to delete the Selected Route???"))
		{
			window.location.href='delete_route.php?x='+id;
		}
	}
</script>
<div id="right-panel" class="right-panel">
         <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                          <a href="dashboard.php?option=add_route" class="btn btn-outline-primary">Add Route</a>
            </div>
        </div>
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Route</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
											 <th>Route Name</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from route");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['route_id'];
									$routename=$res['route_name'];
																		
									?>
									<tr>
										<td><?php echo $sr; ?></td>
																		
										<td><?php echo $routename; ?></td>
									
										
										<td>
										<?php echo "<a href='dashboard.php?option=update_route&rid=$id' class='btn btn-outline-primary btn-sm'>Edit</a>";
											?>
										
										<a href="#" class="btn btn-outline-danger btn-sm" onclick="delet('<?php echo $id;?>')">Delete </a>
										</td>
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