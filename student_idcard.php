<?php

error_reporting(1);

extract($_REQUEST);

include('connection.php');



$sr=1;

if(isset($_POST['search']))

{

	$cond = '';

	

	if($_POST['class']!='') 

	{

		$cond.=" && sr.class_id='$_REQUEST[class]'";

	}

	if($_POST['section']!='') 

	{

		$cond.=" && sr.section_id='$_REQUEST[section]'";

	}

	
 $ssql="SELECT `student_id`,register_no,student_name,father_name,`parent_no`,`msg_type_id`,sr.class_id,sr.section_id   FROM students as s join student_records as sr on `s`.`student_id`=`sr`.`stu_id` WHERE stu_status='0' and sr.session='".$_SESSION['session']."' $cond ";
$query =mysqli_query($con,$ssql);



}



?>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{

	.col-md-3{

		width:400px;

		

	}

	

}



</style>





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">ID Card</a>

  <span class="breadcrumb-item active">Student IDCard</span>

</nav>



	<form method="post" enctype="multipart/form-data">

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                                 

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-5" style="margin-left:50px;">Class</div>

								<div class="col-md-5" style="margin-left:-30px;">

								<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:180px">

								<option value="">All</option>

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

								</div>

								

								<script>

								function search_sec(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_section_withall_report.php?cls_id="+str,true);

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

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-3" style="margin-left:80px;">Section</div>

								<div class="col-md-6" style="margin-left:0px;">

								<select class="form-control" name="section" id="search_sect" style="width:180px">

								<option value="" >All</option>

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

								</div>

								</div>

							</div><br>

							

							

							<br>

							

							<div class="row">

								<div class="col-md-2" style="margin-left:280px">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

								<div class="col-md-2">

								<input type="reset" class="btn btn-primary btn-sm" value="Cancel"><br><br>

								</div>

							</div>

														

							<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

											<th>Register No</th>

											<th>Name</th>

											<th>Class</th>

											<th>Section</th>

											<th>Father Name</th>

											<th>Select All

											<span><input type="checkbox" name="selectall" id="selectall" style="width:40px"></span>

											</th>

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									

									while($res=mysqli_fetch_array($query))

									{

										$stuid = $res['student_id'];

										$regno = $res['register_no'];

										$stuname = $res['student_name'];

										$clsid = $res['class_id'];

										$q1 = mysqli_query($con,"select * from class where class_id='$clsid'");

										$r1 = mysqli_fetch_array($q1);

										$clsname = $r1['class_name'];

										$secid = $res['section_id'];

										$q2 = mysqli_query($con,"select * from section where section_id='$secid'");

										$r2 = mysqli_fetch_array($q2);

										$secname = $r2['section_name'];

										$fname = $res['father_name'];

										

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $clsname; ?></td>

										<td><?php echo $secname; ?></td>

										<td><?php echo $fname; ?></td>

										<td><input type="checkbox" class="checkboxall" name="chk[]" value="<?php echo $stuid;?>" style="margin-left:30px;"></td>

									</tr>

                                    <?php $sr++; 

									}

									

									?>

                                    </tbody>

                                </table>

                            </div>

							</div>

							

							<div>

							<input type="submit" name="save" id="checkBtn"  value="Generate IDCard" class="btn btn-warning btn-md" style="margin-left:320px">

						

							</div>

							<br> 

														

                    </div>

                    </div>

                </div>

            </div><!-- .animated -->

			

</form>

 		

		<?php

		if(isset($save))

		{

			$stuid = implode(',',$chk); ?>
			<script>
				
			var Turl='print_student_idcard.php?stuid=<?=$stuid?>';

			var w=window.open(Turl, "_blank");
			if(!w) { 
			   alert('oops..seems like a pop-up blocker is enabled. Please disable it');
			}
			</script>
		<?php 	

			// echo "<script>window.location='print_student_idcard.php?stuid=$stuid'</script>";

						

		}

		?>



	

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 <script>

 $(document).ready(function()

 {

	$("#selectall").click(function(){

		if(this.checked)

		{

			$('.checkboxall').each(function(){

				$(".checkboxall").prop('checked', true);				

			})

		}

		else

		{

			$('.checkboxall').each(function(){

				$(".checkboxall").prop('checked', false);

			})

		}

		

	});

 }); 

 </script>

 

 <script type="text/javascript">

$(document).ready(function () {

    $('#checkBtn').click(function() {

      checked = $("input[type=checkbox]:checked").length;



      if(!checked) {

        alert("You must check at least one checkbox.");

        return false;

      }



    });

});



</script>