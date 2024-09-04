<script type="text/javascript">
function del(x)
{
	//alert(x);
	var datastring={"id":x};
	$.ajax({
		url:'delete_class.php',
		type:'post',
		data:datastring,
		success:function(str)
		{
			if(str=='true')
			{
				if(confirm('Cannot Delete Class. Students, Fees and Sections are linked with this Class.')==true)
				{
					$("#PTResults").load(location.href+" #PTResults>*","");
				}
			}
			else
			{
				if(confirm('Do you want to delete the Class and associated Sections?')==true)
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
	url:'delete_class.php',
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

<form method="post">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">Activity History</a>
  <span class="breadcrumb-item active">View Menu</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_menu" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Add Menu</a>
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
                                <strong class="card-title">View Section</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Panel</th>
											 <th>Menu</th>
											 
								<!--		<?php
										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="developer")
										{
										?>	 
                                            <th>Action</th>
										<?php
										}
										?>	-->
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from menu");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['menu_id'];
									$name=$res['menu_name'];
									$panel_id=$res['panel_id'];									
									?>
									<tr>
										<td><?php echo $sr; ?></td>
									
									<?php 
									$re=mysqli_query($con,"select * from panel where panel_id='$panel_id'");
									$result=mysqli_fetch_array($re);
									?>	
										<td><?php echo $result['panel_name']; ?></td>
										<td><?php echo $name; ?></td>
										
										
							<!--	<?php
								if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="developer")
								{
								?>			
										<td>
										
										<?php echo "<a href='dashboard.php?option=update_section&sid=$id' class='btn btn-secondary btn-sm px-2'>Edit <i class='fa fa-edit' aria-hidden='true'></i></a>"?>
																			
										<a title="Delete Section" class="btn btn-danger btn-sm text-white" onclick="delet('<?php echo $id;?>')">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>
										
										</td>
								<?php
								}
								?>		-->
										
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