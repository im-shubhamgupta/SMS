<script type="text/javascript">
function del(x)
{
	//alert(x);
	var datastring={"id":x};
	$.ajax({
		url:'delete_expense.php',
		type:'post',
		data:datastring,
		success:function(str)
		{
			if(str!='')
			{
				if(confirm('Cannot Delete '+str+' as expense is already created.')==true)
				{
					$("#PTResults").load(location.href+" #PTResults>*","");
				}
			}
			else
			{
				if(confirm('Do you want to delete?')==true)
				{
					delet(x,3);
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
	url:'delete_expense.php',
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
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <a class="breadcrumb-item" href="#">Expense Type</a>
  <span class="breadcrumb-item active">View Expense Type</span>
</nav>
<!-- breadcrumb -->
<form method="post">
<div id="right-panel" class="right-panel">
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_expense_type&smid=<?php echo '11';?>" class="btn btn-primary btn-sm">
					  <i class="fa fa-plus"></i> Add Expense Type</a>
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
                                <strong class="card-title">View Expense Type</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Expense Name</th>
                                          
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
									$query=mysqli_query($con,"select * from expense_type");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['expense_type_id'];
									$name=$res['expense_type_name'];	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $name; ?></td>
										
									<?php
									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
									{
									?>
										<td>
										<?php echo "<a href='dashboard.php?option=update_expense&eid=$id&smid=12' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";
											?>
										
																
										<a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Expense" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete</a>
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
	</form>
 <?php include('bootstrap_datatable_javascript_library.php'); ?>