<?php 

include('connection.php');

// extract($_REQUEST);?>
<div id="right-panel"  style="width:100%">

         

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Exam & Result</a>

  <span class="breadcrumb-item active">Import CSV Marks</span>

</nav>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	





        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">Upload Marks<br/></strong>

                            </div>

							<form method="post" action="import-questions.php" enctype="multipart/form-data">

										

                            <div class="card-body">

                                

							<div class="row" style="margin-top:20px;">	

							<div class="col-md-2" style="margin-left:20px">Class</div>

							<div class="col-md-2" style="margin-top:-10px;margin-left:-50px">

							<select name="class" id="class" class="form-control" onchange="searchtest(this.value);search_sec(this.value)" autofocus required>

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

							

							<div class="col-md-2" style="margin-left:20px">Section </div>

							<div class="col-md-2" style="margin-top:-10px;margin-left:-50px">

							<select class="form-control" name="section" id="search_sect" style="width:150px;" onchange="searchtest(this.value)" autofocus required>

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

							</div><br>	

								

							<div class="row" style="margin-top:20px;">		

							<div class="col-md-2" style="margin-left:20px">Test Name </div>

							<div class="col-md-2" style="margin-top:-10px;margin-left:-50px">

							<select class="form-control" name="test" id="search_test" onchange="searchsub(this.value)"

							autofocus required>				

							<option value="" selected="selected" disabled>Select Test</option>

							<?php

							$quet = mysqli_query($con,"select distinct(test_name) from test where class_id='$class' && section_id='$section' AND session='".$_SESSION['session']."'");

							while( $rtest= mysqli_fetch_array($quet) ) {
							?>

							<option <?php if($test==$rtest['test_name']){echo "selected";}?> value="<?php echo $rtest['test_name']; ?>"><?php echo $rtest['test_name']; ?>

							</option>

							<?php } ?>	

							</select>

							</div>



							<script>

							function searchsub(str)

							{

							var clsid = $('#class').val();

							var secid = $('#search_sect').val();

							//alert(secid);

							var xmlhttp = new XMLHttpRequest();

							xmlhttp.open("get","search_ajax_testsub.php?clsid="+clsid+"&secid="+secid+"&testname="+str,true);

							xmlhttp.send();

							xmlhttp.onreadystatechange=function()

							{

							if(xmlhttp.status==200 && xmlhttp.readyState==4)

							{

							document.getElementById("search_sub").innerHTML=xmlhttp.responseText;	

							}									

							}

							}

							</script>

							

							<div class="col-md-2" style="margin-left:20px;">Subject </div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">

							<select class="form-control" name="subject" id="search_sub" style="width:150px;" autofocus required>				

							<option value="" selected="selected" disabled>Select Subject</option>

							<?php

							$qsub = mysqli_query($con,"select test.subject_id, subject.subject_name from test INNER JOIN subject ON test.subject_id = subject.subject_id where test.class_id='$class' && test.section_id='$section' && test.test_name='$test' AND AND test.session='".$_SESSION['session']."'");

							while( $rsub= mysqli_fetch_array($qsub) ) {

							?>

							<option <?php if($subject==$rsub['subject_id']){echo "selected";}?> value="<?php echo $rsub['subject_id']; ?>"><?php echo $rsub['subject_name']; ?>

							</option>

							<?php } ?>	

							</select>

							</div>

							</div>	

							

<br/>							

								

							<div class="row">

								<div class="col-md-12">

									<div class="panel-group">

									<div class="panel panel-default">

											

										<?php echo @$err; ?>	



									<div class="row">

										<div class="col-md-5" style="margin-left:20px">

											<div class="panel-body">

											<label>Upload Marks</label>

							<input class="form-control" type="file" required name="csvfile">

										

											</div>

										</div>

									</div><br>

										

									</div> <!-- End of section 1 row-->

									</div>

								</div>

							</div>

							</div>



							<div class="card-footer">

								<button type="submit" value="Upload" class="btn btn-info btn-sm" name="upload">

								<i class="fa fa-upload"></i> Upload

								</button>

							</div>

							</form>				

	                    </section>			

								

                        </div>
                        <div >

						    <strong ><h5>Instructions for uploading Csv file:-</h5></strong>
							<span>
							
							<!--<ol style="margin-left:20px;margin-top:10px;">
								
								<li>At first Download the CSV format of particular subject. <a href='dashboard.php?option=create_download_format'><u>Click Here</u></a></li>
								<!-- <li>Choose the same.</li> 
							</ol>-->
							<div class="form-group col-md-12 col-sm-12 col-xs-12" id="csv" style="display: block;">


											<label class="control-label requiredField" for="attachment">CSV Format Download</label>

											<a href="questions/csv/questions.csv" target="_blank" title="Click here for download">Click here</a>
											


										</div>
							
							
							
							
						    </span>

						</div>

                    </div>

                </div>

			</div><!-- .animated -->

        </div><!-- .content -->

</div><!-- /#right-panel -->

