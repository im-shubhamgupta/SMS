<script type="text/javascript">
function del(x)
{
	//alert(x);
	var datastring={"id":x};
	$.ajax({
		url:'delete_fees.php',
		type:'post',
		data:datastring,
		success:function(str)
		{
			if(str=='true')
			{
				if(confirm('The fees associated to Class cannot be deleted, as it is associated to Student and bill is generated.')==true)
				{
					delet(x);
				}
			}
			else
			{
				if(confirm('Do You want to delete this Fee Detail?')==true)
				{
					delet(x);
				}
			}
          
		}
		
	});
}
	function delet(id)
	{
		//alert(id);
		var datastring={"del_id":id};
	    $.ajax({
		url:'delete_fees.php',
		type:'post',
		data:datastring,
		success:function(str)
		{
			if(str=="deleted Successfully")
			{
				$("#PTResults").load(location.href+" #PTResults>*","");
			}
			//alert(str);
			
          
		}
		
	});
	}
</script>

<div id="right-panel" class="right-panel">
        
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>		
		<div class="breadcrumbs" style="width:1020px">
            <div class="col-sm-4" style="padding:10px;">  
                          <a href="dashboard.php?option=add_fees" class="btn btn-outline-primary">Add Fee</a>
            </div>
        </div>
		<?php
		}
		?>
		
        <div class="content mt-3" style="width:1020px">
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
                                            <th>Class Name</th>
											<th>Admission Fees</th>
											<th>Tuition Fees</th>
											<th>Misc Fees</th>
											
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
									$query=mysqli_query($con,"select * from fees");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['fees_id'];
									$cid=$res['class_id'];
																			
									?>
										<td><?php echo $sr; ?></td>
									
									<?php 
									$re=mysqli_query($con,"select * from class where class_id='$cid'");
									$result=mysqli_fetch_array($re);
									?>	
										<td><?php echo $result['class_name']; ?></td>
										<td>Rs <?php echo $res['admissionfees']; ?></td>
									
										
										<td><?php echo $res['tutionfees']; ?></td>
										<td><?php echo $res['misfees']; ?></td>
										
									<?php
									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
									{
									?>	
										<td>
										<?php echo "<a href='dashboard.php?option=update_fees&fid=$id' class='btn btn-outline-primary btn-sm'>Edit</a>";
											?>
										
										<a title="Deleted" class="btn btn-outline-danger btn-sm" onclick="del('<?php echo $id;?>')">Delete </a>
										
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