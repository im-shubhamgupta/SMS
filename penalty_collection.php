<?php

//error_reporting(1);

extract($_REQUEST);

// print_r($_REQUEST);

if(isset($_POST['search']))

{

    $class = $_POST['class'];

    $section = $_POST['section'];

    $student = $_POST['student'];

		

	if($class=="All" and $section=="All" and $student=="All")

	{

    // search in all table columns

		$query = "SELECT * FROM `issue_bookto_students` WHERE `return_status`='0'";

		$search_result = filterTable($query);

    }

	else if($class!="All" and $section=="All" and $student=="All")

	{

		$query = "SELECT * FROM `issue_bookto_students` WHERE `class_id`='$class' and return_status='0'";

		$search_result = filterTable($query);

	}	

	else if($class!="All" and $section!="All" and $student=="All")

	{

		$query = "SELECT * FROM `issue_bookto_students` WHERE `class_id`='$class' and `section_id`='$section' and return_status='0'";

		$search_result = filterTable($query);

	}	

	else if($class!="All" and $section!="All" and $student!="All")

	{

		$query = "SELECT * FROM `issue_bookto_students` WHERE `class_id`='$class' and `section_id`='$section' and `student_id`='$student' and return_status='0'";

		$search_result = filterTable($query);

	}

	// echo $query;

}





// function to connect and execute the query

function filterTable($query)

{

	include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}





?>



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

<div id="right-panel" class="right-panel">



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Library Management</a>

  <span class="breadcrumb-item active">Penalty Collection</span>

</nav>





   <form method="post" action="dashboard.php?option=penalty_collection" enctype="multipart/form-data">      

        <div class="content mt-3"  style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

							

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                              

								<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">Class</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select name="class" class="form-control" onchange="searchstudent(this.value);search_sec(this.value)" autofocus required>

								<option value="All" selected="selected">All</option>

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

								

								<div class="col-md-2" style="margin-left:50px;">Section</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select class="form-control" name="section" id="section" onchange="searchstudent(this.value);">

								<option value="All" selected>All</option>

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

								xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("section").innerHTML=xmlhttp.responseText;

								}

								} 

								}

								

								

								function searchstudent(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_student_withall.php?sec_id="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("student").innerHTML=xmlhttp.responseText;

								}

								}

								}

							

								</script>

								</div>

								</div>

							    </div><br>

								

								<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">Student Name</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select name="student" id="student" class="form-control" autofocus required>

								<option value="All" >All</option>

								<?php

								// $qstu = mysqli_query($con,"select * from students where class_id='$class'");
								$sql1="select `student_id`,student_name,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  sr.class_id='$class' and sr.session='".$_SESSION['session']."' ";
								$qstu=mysqli_query($con,$sql1);
								while($rstu = mysqli_fetch_array($qstu) ) {

								?>

								<option  <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								

								<div class="col-md-2" style="margin-left:50px">

								<div class="sorting-left">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

								</div>

				 

                            </div>

							

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Total Penalty</th>

											 <th>Total Paid</th>

											 <th>Total Due</th>

											 <th>Generate Bill</th>

											 <th>View Payments</th>

											 

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									if(isset($search))

									{

										while($res=mysqli_fetch_array($search_result))

									{

									$id=$res['issue_id'];

									$stuid=$res['student_id'];

									$q1 = mysqli_query($con,"select * from students where student_id='$stuid'");

									$r1 = mysqli_fetch_array($q1);

									$stuname=$r1['student_name'];

									

									$clsid=$res['class_id'];

									$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

									$r2 = mysqli_fetch_array($q2);

									$classname = $r2['class_name'];

									

									$secid=$res['section_id'];

									$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

									$r3 = mysqli_fetch_array($q3);

									$secname = $r3['section_name'];									

									

									$retdt = $res['return_date'];

									$curdate = date("Y-m-d");

									$date1=date_create($curdate);

									$date2=date_create($retdt);

									$diff=date_diff($date2,$date1);

									$tdays = $diff->format("%R%a days");

																			

									$rettypeid=$res['return_type_id'];

									$q3=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$rettypeid'");

									$r3=mysqli_fetch_array($q3);

									$amt=$r3['book_fine_per_day'];

									

									if($tdays > 0)

									{

										$tpenalty = $tdays * $amt;

									}

									else

									{

										$tpenalty = 0;

									}

									

									$q4 = mysqli_query($con,"select * from library_payment where issue_id='$id'");

									$tpaid = 0;

									while($r4 = mysqli_fetch_array($q4))

									{

										$tpaid += $r4['paid_amount']; 

									}

									$tdue = $tpenalty - $tpaid;

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $classname; ?></td>

										<td><?php echo $secname; ?></td>

										<td><?php echo $tpenalty; ?></td>

										<td><?php echo $tpaid; ?></td>

										<td><?php echo $tdue; ?></td>

										<td><?php

										echo "<a href='dashboard.php?option=library_payment&issueid=$id' class='btn btn-outline-success btn-sm' target='_blank' title='Generate Bill'>Generate Bill</a>";

										?></td>

										

										<td>

										<?php echo "<a href='dashboard.php?option=lib_payment_history&issueid=$id' class='btn btn-outline-success btn-sm' target='_blank' title='View all Payment History'>Payment History</a>";?>

										</td>

										

									</tr>

                                    <?php

									$sr++;

										}

									 } 

									

									?>

									

                                    </tbody>

                                </table>

                            </div>

							

							<div class="card-footer">

							<?php

							if(isset($search))

							{

							?>

								<a href="export_penalty_collection_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&student=<?php echo $student;?>" class="btn btn-success btn-sm">

								<i class="fa fa-download"></i> Download To Excel</a>

							<?php

							}

							?>

							</div>

							

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<div style="text-align:center">



		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 