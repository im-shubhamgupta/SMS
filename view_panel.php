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
  <span class="breadcrumb-item active">View Panel</span>
</nav>
<!-- breadcrumb -->
<div id="right-panel" class="right-panel">
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="developer")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_panel" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Add Panel</a>
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
                                <strong class="card-title">View Panel</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Panel</th>
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
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from panel");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['panel_id'];
									$smid=3;
									$name=$res['panel_name'];	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $name; ?></td>
				<!-- For Permission -->						
						<!--		<?php
								if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="developer")
								{
								?>
										
									<td>
									<?php echo "<a href='dashboard.php?option=updateclass&cid=$id&smid=2' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit </a>";?>
										
									<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete </a>
 </a>
									</td>
										
								<?php
								}
								?>	-->									
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