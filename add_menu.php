<?php	
	//error_reporting(1);
	if(isset($add))
	{		

		$sql=mysqli_query($con,"select * from menu where menu_name='$menu' && panel_id='$panel'");
		$res1=mysqli_num_rows($sql);
		if($res1)
		{
			$err="<style='color:red;font-weight:bold'>This Menu Is Already Exists.</style>";	
		}
		else
		{
			$query1=mysqli_query($con,"insert into menu(menu_name,panel_id) values('$menu','$panel')");	
			
			$err="<style='color:green;font-weight:bold'>Menu Added Successfully.</style>";
		}
		
	}
	
?>
<div class="card">
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
  <a class="breadcrumb-item" href="#">Activity History</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_menu">View Menu</a>
  <span class="breadcrumb-item active">Add Menu</span>
</nav>
<!-- breadcrumb -->
<form action="" method="post">
	<div class="card-header">
		<strong>Add</strong> Menu
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Panel</label>
			<select class="form-control" name="panel" required>
					<option value="" selected disabled>---Select Panel---</option>
					<?php
						$sql = "SELECT * FROM panel";
						$resultset = mysqli_query($con, $sql);
						while( $rows = mysqli_fetch_array($resultset) ) {
						?>
						<option value="<?php echo $rows['panel_id']; ?>"><?php echo $rows['panel_name']; ?>
						</option>
						<?php } ?>	
			</select>
			</div>
			<div class="form-group">
			<label for="nf-email" class="form-control-label">Enter Menu</label>
			<input type="text" name="menu" placeholder="Enter Menu" class="form-control" required>
			</div>
	</div>
	<div class="card-footer">
		<button type="submit" name="add" class="btn btn-primary btn-sm">
			<i class="fa fa-plus"></i> Add Menu
		</button>
		
		<a href="dashboard.php?option=view_menu" class="btn btn-info btn-sm"> 
		<i class='fa fa-arrow-left'> Back</i></a>
		
	</div>
</form>
</div>