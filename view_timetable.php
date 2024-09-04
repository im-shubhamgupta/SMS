<?php

error_reporting(1);

extract($_REQUEST);



?>



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

  <a class="breadcrumb-item" href="#">Time Table</a>

  <span class="breadcrumb-item active">View Time Table</span>

</nav>

<!-- breadcrumb -->

   <form method="post" id="devel-generate-content-form" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	

													

							<div class="col-md-2" style="margin-top:-8px;margin-left:50px;">Class : </div>

							<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

							<select style="width:150px;" name="class" id="class" class="form-control" 

							onchange="showtimetable(this.value);search_sec(this.value);" required autofocus>

							<option value="" selected="selected" disabled>Select Class</option>

							<?php

							$scls = mysqli_query($con,"select * from class");

							while( $rcls = mysqli_fetch_array($scls) ) {

							?>

							<option <?php if($class==$rcls['class_id']){echo "selected";}?> value="<?php echo $rcls['class_id']; ?>"><?php echo $rcls['class_name']; ?>

							</option>

							<?php } ?>							

							</select>

							</div>

							

							<script>

							function search_sec(str)

							{

							var xmlhttp= new XMLHttpRequest();	

							xmlhttp.open("get","search_ajax_section_withoutall.php?cls_id="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200  && xmlhttp.readyState==4)

							{

							document.getElementById("sectionid").innerHTML=xmlhttp.responseText;

							}

							} 

							}

							</script>



						<div class="col-md-2" style="margin-left:50px;">Section : </div>

						<div class="col-md-2" style="margin-top:-8px;margin-left:-60px;">

						<select style="width:150px;" name="sectionid" id="sectionid" class="form-control" 

						onchange="showtimetable(this.value);" required autofocus>

						<option value="" selected="selected" disabled>Select Section</option>							

						<?php

						$qsec=mysqli_query($con,"select * from section where class_id='$class'");

						while($rsec=mysqli_fetch_array($qsec))

						{

						?>

						<option <?php if($sectionid==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>

						</option>

						<?php 

						}

						?>	

						</select>

						</div>	



							

						</div><br>

                     

					</div><br>	

							

						<script>

						function showtimetable(str)

						{

							var clsid = $('#class').val();

							$.ajax({

								url:'get_ajax_timetable.php?clsid='+clsid+'&secid='+str,

								type:'get',

								success:function(data) {

									$('#showtimetable').html(data);

								}

								

							});

						}

						</script>

									

						<!--table starts from here-->

								

						<div id="showtimetable">

						

						</div>

							

                </div>

            </div>

        </div><!-- .animated -->

        

		

	</form>	

    </div>



 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 