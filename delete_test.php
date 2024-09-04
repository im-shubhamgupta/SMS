<?php

error_reporting(1);

extract($_REQUEST);





?>



<script>

function del()

{

//alert('Hi');

var cls = $('#class').val();

var sect = $('#search_sect').val();

var tes = $('#search_test').val();



// var reason = prompt("Do you want to Delete the Test.");
var reason = confirm("Are you sure want to Delete this Test.");

	if(reason){

	// 	alert('Please Enter the Reason');

	// }

	// else if(reason)

	// {

		window.location.href="del_test.php?cls="+cls + "&sect=" +sect+ "&tes=" +tes ;

		return true;

	}

	else 

	{

		return false;

	}

}

</script>



	<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}



	</style>

	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb" style="width:1000px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">Delete Test</span>

</nav>

<!-- breadcrumb -->

   <form method="post" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Class</div>

							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">

							<select name="class" id="class" class="form-control" onchange="searchtest(this.value);search_sec(this.value)" style="width:175px;" autofocus required>

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

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);

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

							

							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>

							<div class="col-md-2" style="margin-left:-110px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" onchange="searchtest(this.value)"   style="width:175px;" autofocus required>

							<option value="" selected="selected" disabled>Select Section</option>

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

							</div>

							<script>

							function searchtest(str)

							{

							var clsid = $('#class').val();

							//alert(clsid);

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_test.php?sec_id="+str+"&cls_id="+clsid,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("search_test").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>



							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Select Test </div>

							<div class="col-md-2" style="margin-left:-60px;margin-top:-10px;">

							<select class="form-control" name="test" id="search_test" style="width:175px;" 	autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

								

							</select>

							</div>

						</div><br><br>

                     

						<!--table starts from here-->

											

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<div style="text-align:center">

		<a href="#" title="Delete" class="btn btn-danger btn-sm text-white" onclick="del()">

		<i class="fa fa-trash"></i> Delete </a>

		</div>

		

		

		

	</form>	

    </div><!-- /#right-panel -->

	<script>

	$('#saveForm').on('click', function() {

		$formdata = new FormData();

		$formdata = $('#devel-generate-content-form').serialize();

		

		

		$.ajax({

			url: 'dashboard.php?option=create_test',

			data: $formdata,

			method:"post",

			success:function(data) {

				alert(data);

			}				

		});

		

	});

	

	</script>



 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 