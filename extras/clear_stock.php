<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

if(isset($clear))
	{
		
		
		$q1 = mysqli_query($con,"TRUNCATE table stock_type");
		$q2 = mysqli_query($con,"TRUNCATE table stock_vendor");
		$q3 = mysqli_query($con,"TRUNCATE table purchase_order");
		$q4 = mysqli_query($con,"TRUNCATE table issue_order");
		$q5 = mysqli_query($con,"TRUNCATE table return_stock");
		
		echo "<script>alert('Database Cleared Successfully');window.location='dashboard.php?option=clear_stock'</script>";
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
  <span class="breadcrumb-item active">Clear Stock
</span>
</nav>
<!-- breadcrumb -->	
		
		  <div class="content mt-3">	
		 <div class="col-lg-6">
                <div class="card"  style="width:500px;">
					<div class="card-header">
					<strong>Clear Stock</strong>	
					</div>
					<div class="card-body card-block">
					<form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
											
						<div class="row form-group">
						<div class="col-md-12">
						<input type="submit" name="clear" value="CLICK" class="btn btn-danger" style="width:100px;border-radius:20px;margin-left:10px;"/>
						<span style="color:red;font-weight:bold;margin-left:10px">Click To Clear Stock</span>
						</div>
												
						</div><br>
					</form>				  
					</div>
						
                </div>
	     </div>
		 </div>
