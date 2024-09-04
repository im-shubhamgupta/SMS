<?php


	extract($_REQUEST);

	if(isset($add))

	{		

		

		$q2 = mysqli_query($con,"select * from class where class_id='$class'");

		$r2 = mysqli_fetch_array($q2);

		$clsname = $r2['class_name'];

		

			$fhead = implode(',',$feehead);

			$famt = implode(',',$feeamt);

		

			$query="insert into assign_fee_class(class_id,fee_header_id,fee_header_amount,total_amount,session)

			values('$class','$fhead','$famt','$tamount','".$_SESSION['session']."')";
			
			
			$stuQuery = mysqli_query($con,"select * from students where  class_id='$class'");

			 while($stude_data=mysqli_fetch_array($stuQuery)){

             $query2="insert into student_wise_fees(student_id,class_id,fee_header_id,fee_amount,due_amount)

			  values('".$stude_data['student_id']."','$class','$fhead','$famt','$tamount')";
			  mysqli_query($con,$query2);

			
			}
			
			

			if(mysqli_query($con,$query))

			{

				

				$qc = mysqli_query($con,"select * from class where class_id='$class'");

				$rc = mysqli_fetch_array($qc);

				$clsname = $rc['class_name'];				

				$action = "For Class ".$clsname." Fee is assigned"; 

				$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

				machine_name,browser,date) 

				values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			}

			

			$err="<span id='err_successful'>[ Fees Assign Successfully ]</span>";



	}

	

?>





<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Fees</a>


  <span class="breadcrumb-item active">Assign Fees to Class Student</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Assign</strong> Fees

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			
                            <div class="card-header">

                              

								<div class="row" style="margin-top:20px;">

								<div class="col-md-1" style="margin-left:10px;">Class</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>

								<option value="" selected="selected" disabled>Select Class</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while( $rescls = mysqli_fetch_array($rcls) ) {

								?>

								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								

								<div class="col-md-1" style="margin-left:50px;">Section</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select class="form-control" name="section" id="search_sect">

								<option value="" selected="selected" disabled>All</option>

								<?php

								$qsec=mysqli_query($con,"select * from section where class_id='$class'");

								while($rsec=mysqli_fetch_array($qsec))

								{

								$secname=$rsec['section_name'];

								?>

								<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

								</option>

								<?php 

								}

								?>	

								</select>

								<script>

								function search_sec(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_section_without_all.php?cls_id="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

								}

								} 

								}

								</script>

								

								</div>

								</div>

								

								<div class="col-md-1" style="margin-left:50px;">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

							    </div>

 

                            </div>
			

			


			

	</div>

	

	</form>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>



<script>

function check_assign_feeto_class(str){

	$.ajax({

		url : 'check_assign_feeto_class.php?clsid='+str,

		type : 'get',

		success : function(data)

		{

			if(data==1)

			{

				alert("Already Fees is Assigned.");

				window.location = "dashboard.php?option=view_assign_fees_to_class";

			}

		}

		

	})

}

</script>



<script>

function saveheader(x)

{

	if($('#fid'+x).is(':checked')) {

		$('#feeamt'+x).removeAttr('disabled');

		$('#feeamt'+x).prop('required',true);

	} else {

		$('#feeamt'+x).prop('disabled', 'disabled');

	}

	



}



</script>	



<script>

$(document).ready(function(){

	$(".amount").blur(function(){

	

	var sum = 0;

	$(".amount").each(function(){

	

	if($(this).val()=='')

		$a=0;

		else

		$a=$(this).val();

		

	sum = parseInt(sum) + parseInt($a);



	});

	

	$("#tamount").val(sum);

	

	});

});



</script>



