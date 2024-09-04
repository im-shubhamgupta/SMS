<?php
error_reporting(1);

?>

<script type="text/javascript">
function del(x)
{
	//alert(x);
	var datastring={"id":x};
	$.ajax({
		url:'delete_assign_fee_class.php',
		type:'post',
		data:datastring,
		success:function(str)
		{
			
			if(str=='true')
			{
				if(confirm('The fees associated to Class cannot be deleted, as it is associated to Student.')==true)
				{
					//$("#PTResults").load(location.href+" #PTResults>*","");
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
		url:'delete_assign_fee_class.php',
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
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <span class="breadcrumb-item active">View Assign Fees to Classes</span>
</nav>
<!-- breadcrumb -->       
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>		
		<div class="breadcrumbs" style="width:1020px">
            <div class="col-sm-4" style="padding:10px;">  
                <a href="dashboard.php?option=assign_fees_to_class&smid=<?php echo '6';?>" class="btn btn-primary btn-sm">
				<i class="fa fa-plus"></i> Assign Fees to Class</a>
            </div>
        </div>
		<?php
		}
		?>
	
<form method="post" action="dashboard.php?option=view_assign_fees_to_class" id="devel-generate-content-form" enctype="multipart/form-data">      	
        <div class="content mt-3" style="width:1020px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
					
						<script>
							function view_fees(str)
							{
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_fee_amount.php?r_id="+str,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200  && xmlhttp.readyState==4)
							{
							document.getElementById("fee").innerHTML=xmlhttp.responseText;
							}
							} 
							}
						</script>
					
					
						<div class="row" style="margin-top:20px;">	
							<div class="col-md-2" style="font-size:14px;margin-left:180px;">Class</div>
							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
							<select name="class" class="form-control" style="width:175px;" onchange="view_fees(this.value)"
							autofocus required>
							<option value="" selected="selected" disabled>Select Class</option>
							<?php
							$scls = "select * from class";
							$rcls = mysqli_query($con, $scls);
							while( $rescls = mysqli_fetch_array($rcls) ) {
							?>
							<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
							</option>
							<?php } ?>							
							</select>
							</div>
						</div><br>
					
                        <div class="card">
                            <div class="card-body" id="fee">
							
							
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
</form>
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>