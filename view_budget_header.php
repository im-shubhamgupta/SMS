<?php
//extract($_REQUEST);
if(isset($update))
{
	$q1 = mysqli_query($con,"select * from allocate_budget where budget_header_id ='$update'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		echo "<script>alert('This Budget Header is Allocated. Cannot able to Edit.')</script>";
	}
	else
	{
		echo "<script>window.location='dashboard.php?option=update_budget_header&id=$update'</script>";
	}
}

if(isset($delete))
{
	$q1 = mysqli_query($con,"select * from allocate_budget where budget_header_id='$delete'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		echo "<script>alert('This Budget Header is Allocated. Cannot able to Delete.')</script>";
	}
	else
	{
		mysqli_query($con,"delete from budget_header where budget_header_id ='$delete'");
	}
}
	

?>


<!-- breadcrumb-->
<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

</style>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">Budget Management</a>
  <span class="breadcrumb-item active">View Budget Header</span>
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
                     <a href="dashboard.php?option=add_budget_header" class="btn btn-primary btn-sm">
					  <i class="fa fa-plus"></i> Add Budget Header</a>
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
                                <strong class="card-title">View Budget Header</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Budget Header</th>
                                          
										<?php
										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
										{
										?>
											<th>Edit</th>
											<th>Delete</th>
										<?php
										}
										?>	
											
                                        </tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from budget_header");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['budget_header_id'];
									$name=$res['budget_header_name'];	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $name; ?></td>
										
									<?php
									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
									{
									?>
										<td><button type="submit" name="update" class="btn btn-secondary btn-sm" value="<?php echo $id;?>"><i class='fa fa-edit'></i> Edit</button></td>
										<td><button type="submit" name="delete" class="btn btn-danger btn-sm" value="<?php echo $id;?>"><i class='fa fa-trash'></i> Delete</button></td>
										
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