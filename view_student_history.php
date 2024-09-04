<link href="datejquery/jquery.datepicker2.css" rel="stylesheet">
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>      
<div class="card">

<form action="dashboard.php?option=student_history" method="post" enctype="multipart/form-data">
	<div class="card-header">
		<strong>View</strong> Student History
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block" style="height:350px;width:500px;">
		<div class="row">
		<div class="col-md-12">	
			<label for="nf-email" class=" form-control-label" style="font-weight:bold">Search By</label>
		</div>
		
		</div><br/>
		
		
		<div class="row">
		<div class="col-md-6">
			<select class="form-control" name="search" onchange="chk(this.value)" required>
					<option value="">---Select---</option>
					<option value="1">Name</option>
					<option value="2">Register Number</option>
					<option value="3">Phone No</option>
					
			</select>
		</div>
		
		<div class="col-md-6" id="test123">
		</div>
		
		
		</div><br/><br/>
		
		<div class="row">
		<div class="col-md-12">
		<input type="submit" name="submit" value="submit"/>
		</div>
		</div>
		
	</div>
	
	
</form>
</div>

<script>
					function chk(str)
					{
					var xmlhttp= new XMLHttpRequest();	
					xmlhttp.open("get","view_ajax_search.php?searchid="+str,true);
					xmlhttp.send();
					xmlhttp.onreadystatechange=function()
					{
					if(xmlhttp.status==200  && xmlhttp.readyState==4)
					{
					document.getElementById("test123").innerHTML=xmlhttp.responseText;
					}
					} 
					}
				</script>

