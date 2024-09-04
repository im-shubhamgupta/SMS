

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



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <a class="breadcrumb-item active" href="#">Assign Late Fees to Class</a>


</nav>

<!-- breadcrumb -->
<?php
if(isset($_GET['id']) && !empty($_GET['id'])){
	$sql="SELECT * FROM `textsms_templates` where `id`='".$_GET['id']."' ";
	$con->set_charset('utf8');
	$query=$con->query($sql);
	$row=$query->fetch_assoc();

	?>

	<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">


		<div class="col-md-2">Choose Language: </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" name="language" id="language" class="form-control" 
		 required autofocus>

		<option value="English"<?=($row['lang_type']=='English') ? 'selected' : ''?> >English </option>
		<option value="Hindi" <?=($row['lang_type']=='Hindi') ? 'selected' : ''?> >Hindi</option>

		</select>

		</div>


	<div class="col-md-2"  style=" margin-left: 87px;">Title: </div>

	<div class="col-md-3" style="margin-top:-8px; ">
		<input type="text" name="title"  class="form-control" value='<?=$row['title']?>' required>

	</div>


	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">make slug: </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<input type="text" name="msg_type"  class="form-control" value='<?=$row['msg_type']?>' required>

	</div>
	<div class="col-md-2">Template Id: </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<input type="text" name="temp_id"  class="form-control" value='<?=$row['temp_id']?>' required>

	</div>

	</div>

	<div class="row" style="margin-left:20px;margin-top:50px;">
	</div>
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">SMS Content </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<textarea type="text" rows="5" cols="70" name="text_sms"   required><?=$row['description']?></textarea>

	</div>
	</div>
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Sample SMS </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<textarea type="text" rows="5" cols="70" name="sample_sms" required><?=$row['dummy_sms']?></textarea>

	</div>
	</div>
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Status: </div>

		<div class="col-md-5" >

		<select style="width:170px;" name="status" id="status" class="form-control" 
		 required autofocus>

		<option value="1"<?=($row['status']=='1') ? 'selected' : ''?> >Active </option>
		<option value="0" <?=($row['status']=='0') ? 'selected' : ''?> >Deactive</option>

		</select>

		</div>
	</div>	
	<br/><br/>

	<div>
		<input type="hidden" name='id' value="<?=$_GET['id']?>">
	<input type="submit" name="save" value="Update" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

		<a href="dashboard.php?option=view_late_fee_assign_to_class" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>
	</div>
</form>

<?php

}else{?>
	<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">


		<div class="col-md-2">Choose Language: </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:170px;" name="language" id="language" class="form-control" 
		 required autofocus>

		<option value="English" >English </option>
		<option value="Hindi" >Hindi</option>

		</select>

		</div>


	<div class="col-md-2"  style=" margin-left: 87px;">Title: </div>

	<div class="col-md-3" style="margin-top:-8px; ">
		<input type="text" name="title"  class="form-control" required>

	</div>


	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">make slug: </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<input type="text" name="msg_type"  class="form-control" required>

	</div>
	<div class="col-md-2">Template Id: </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<input type="text" name="temp_id"  class="form-control" required>

	</div>

	</div>

	<div class="row" style="margin-left:20px;margin-top:50px;">
	</div>
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">SMS Content </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<textarea type="text" rows="5" cols="70" name="text_sms"   required></textarea>

	</div>
	</div>
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Sample SMS </div>

	<div class="col-md-3" style="margin-top:-8px;">
		<textarea type="text" rows="5" cols="70" name="sample_sms" required></textarea>

	</div>
	</div>
	<div class="row" style="margin-left:20px;margin-top:50px;">
	<div class="col-md-2">Status: </div>

		<div class="col-md-5" >

		<select style="width:170px;" name="status" id="status" class="form-control" 
		 required autofocus>

		<option value="1" >Active </option>
		<option value="0" >Deactive</option>

		</select>

		</div>
	</div>
	<br/><br/>

	<div>

	<input type="submit" name="save" value="Add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

		<a href="dashboard.php?option=view_late_fee_assign_to_class" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>
	</div>
</form>

<?php
}

?>



<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	var id="<?=$_GET['id']?>";
	if(id!=''){
		var btn="Update";
		 var action = "Update_text_sms_templates";
	}else{
		var btn="Add";
		var action = "Add_text_sms_templates";
	}
 
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/ConfigurationControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				// setInterval(function(){ 
				// window.location.href='dashboard.php?option=';
				// 			// $('form')[0].reset(); 
				// },3000);
				if(id!=''){
					 setInterval(function(){ 
					window.location.href='dashboard.php?option=text_sms_templates';
				    },2000);
						
				}else{
					setTimeout(function(){ 
									$('form')[0].reset(); 
						},2000);
				}		
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val(btn);  
	$('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

