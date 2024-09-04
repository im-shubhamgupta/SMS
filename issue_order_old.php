<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

if(isset($save))
{
	$img = $_FILES['file']['name'];
	
	if($img=="")
	{
	$q1 = mysqli_query($con,"insert into issue_order (issued_date,issued_department,issued_to_id,stock_type_id,
	Identification_no,quantity,amount,description,vendor_add,item_incharge) 
	values('$issueddate','$issueddept','$issuedto','$stockid','$identno','$qty','$amount','$description','$address',
	'$incharge')");
	}
	else
	{
	$q1 = mysqli_query($con,"insert into issue_order (issued_date,issued_department,issued_to_id,stock_type_id,
	Identification_no,quantity,amount,description,vendor_add,item_incharge,image) 
	values('$issueddate','$issueddept','$issuedto','$stockid','$identno','$qty','$amount','$description','$address',
	'$incharge','$img')");
	move_uploaded_file($_FILES['file']['tmp_name'],"gallery/issuedorder/".$_FILES['file']['name']);
	}
	
}
?>

<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  
<script src="multi.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

	</style>
	
<script type="text/javascript">
$(document).ready(function(){
    $(".menu a").each(function(){
        if($(this).hasClass("disabled")){
            $(this).removeAttr("href");
        }
    });
});
</script>
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

input[type=checkbox] {
    zoom: 1.8;
	margin-top:5px;
}
</style>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#"> Stock Management</a>
  <span class="breadcrumb-item active"> Issue Order</span>
</nav>
<!-- breadcrumb -->

<form method="post" enctype="multipart/form-data"> 
	<div class="row" style="margin-top:50px;margin-left:20px;">
		<div class="col-md-2">Issued Date : </div>
		<div class="col-md-2" style="margin-top:-8px;">
		<input type="date" name="issueddate" class="form-control" style="width:175px;" required autofocus>
		</div>
		
		<div class="col-md-2" style="margin-left:80px;">Issued Department : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">
		<select style="width:175px;" name="issueddept" onchange="show_issuedto(this.value)" class="form-control" required autofocus>
		<option value="" selected="selected" disabled>Select Stock Type</option>
		<option value="department">Department</option>
		<option value="individual">Individual</option>
		</select>
		</div>
	</div>
	
	<script>
	function show_issuedto(str)
	{
		var xmlhttp= new XMLHttpRequest();	
		xmlhttp.open("get","view_issuedto.php?issueddept="+str,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange=function()
		{
		if(xmlhttp.status==200  && xmlhttp.readyState==4)
		{
		document.getElementById("issuedto").innerHTML=xmlhttp.responseText;
		}
		} 
	}
	</script>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
		<div class="col-md-2" style="margin-top:-10px;">Issued To: </div>
		<div class="col-md-2" style="margin-top:-8px;">
		<select style="width:175px;" name="issuedto" id="issuedto" class="form-control" required autofocus>
		<option value="" selected="selected" disabled>Select</option>						
		</select>
		</div>
		
		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Stock Type : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">
		<select style="width:175px;" name="stockid" class="form-control" required autofocus>
		<option value="" selected="selected" disabled>Select Stock Type</option>
		<?php
		$scls = mysqli_query($con,"select * from stock_type");
		while( $rcls = mysqli_fetch_array($scls) ) {
		?>
		<option <?php if($class==$rcls['stock_type_id']){echo "selected";}?> value="<?php echo $rcls['stock_type_id']; ?>"><?php echo $rcls['stock_type_name']; ?>
		</option>
		<?php } ?>							
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
		<div class="col-md-2" style="margin-top:-10px;">Identification Number : </div>
		<div class="col-md-2" style="margin-top:-8px;">
		<input type="text" name="identno" class="form-control" style="width:175px;" required autofocus>
		</div>
		
		<div class="col-md-2" style="margin-left:80px;">Quantity : </div>
		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">
		<input type="number" name="qty" class="form-control" style="width:175px;" required autofocus>
		</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
		<div class="col-md-2">Amount : </div>
		<div class="col-md-2" style="margin-top:-8px;">
		<input type="number" name="amount" class="form-control" style="width:175px;" required autofocus>
		</div>
	</div>
	
		
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Description : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<textarea name="description" class="form-control" style="width:580px;height:100px;" required autofocus></textarea>
	</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2" style="margin-top:-10px;">Vendor Name & Address : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<textarea name="address" class="form-control" style="width:580px;height:50px;" required autofocus></textarea>
	</div>
	</div>

	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Item In-Charge : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<input type="text" name="incharge" class="form-control" style="width:580px;" required autofocus>
	</div>
	</div>
	
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2" style="font-size:16px;">Attachment : </div>
	<div class="col-md-2" style="margin-top:-8px;">
	<input type="file" name="file" class="form-control" style="width:250px;">
	</div>
	</div>
		
	<br><br>
	
	<div>
	<input type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-md"/>
	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-md"/>
	</div>

</form>
