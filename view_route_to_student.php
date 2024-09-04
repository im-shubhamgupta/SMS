<script type="text/javascript">
	function del(x)

	{

		//alert(x);

		var datastring = {
			"id": x
		};

		$.ajax({

			url: 'delete_student_route.php',

			type: 'post',

			data: datastring,

			success: function(str)

			{

				if (str == 'true')

				{

					if (confirm('Cannot Delete Route.') == true)

					{

						$("#PTResults").load(location.href + " #PTResults>*", "");

					}

				} else

				{

					if (confirm('Do you want to delete') == true)

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

		var datastring = {
			"del_id": id
		};

		$.ajax({

			url: 'delete_student_route.php',

			type: 'post',

			data: datastring,

			success: function(str)

			{

				if (str == 1)

				{

					$("#PTResults").load(location.href + " #PTResults>*", "");

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

		<a class="breadcrumb-item" href="#">Transport</a>

		<span class="breadcrumb-item active">View Route to Student</span>

	</nav>

	<!-- breadcrumb -->

	<?php

	if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {

	?>

		<div class="breadcrumbs" style="width:1020px">

			<div class="col-sm-4" style="padding:10px;">

				<a href="dashboard.php?option=assign_route_to_student" class="btn btn-primary btn-sm">

					<i class="fa fa-plus"></i> Assign Route to Student</a>

			</div>

		</div>

	<?php

	}

	?>



	<div class="content mt-3" style="width:1020px">

		<div class="animated fadeIn">

			<div class="row">



				<div class="col-md-12">
					<div class="row" style="margin-top:20px;">

					<form action="" method="POST">

						<div class="col-md-2" style="margin-left:20px;">Class</div>

						<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">



							<select name="class" class="form-select" onchange="search_sec(this.value)" style="width:170px;" autofocus>

								<option value="" selected="selected">All</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while ($rescls = mysqli_fetch_array($rcls)) {

								?>

									<option <?php if ($class == $rescls['class_id']) {
												echo "selected";
											} ?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

									</option>

								<?php } ?>

							</select>

						</div>



						<div class="col-md-1"></div>



						<div class="col-md-2" style="font-size:14px; margin-left:20px;">Section </div>

						<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

							<select class="form-select" name="section" id="search_sect" style="width:170px;">

								<option value="" selected="selected">All</option>

								<?php

								$qsec = mysqli_query($con, "select * from section where class_id='$class'");

								while ($rsec = mysqli_fetch_array($qsec)) {

									$secname = $rsec['section_name'];

								?>

									<option <?php if ($section == $rsec['section_id']) {
												echo "selected";
											} ?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name']; ?>

									</option>

								<?php

								}

								?>

							</select>





							<script>
								function search_sec(str)

								{

									var xmlhttp = new XMLHttpRequest();

									xmlhttp.open("get", "search_ajax_section_withall_report.php?cls_id=" + str, true);

									xmlhttp.send();

									xmlhttp.onreadystatechange = function()

									{

										if (xmlhttp.status == 200 && xmlhttp.readyState == 4)

										{

											document.getElementById("search_sect").innerHTML = xmlhttp.responseText;

										}

									}

								}
							</script>

						</div>



						<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:50px;" value="Submit"><br><br>

						</div>


					</form>			
					</div>

					<div class="card">

						<div class="card-header">

							<strong class="card-title">View Student Route</strong>

						</div>

						<div class="card-body">

							<table id="table-grid" class="table table-striped table-bordered">

								<thead>

									<tr>

										<th>Sr. No</th>

										<th>Name</th>

										<th>Class</th>

										<th>Section</th>

										<th>Route</th>

										<th>Transport</th>

										<th>Mode</th>
										<th>Date</th>



										<?php

										if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {



											$qa = mysqli_query($con, "select * from superadmin_authority where id='2'");

											$ra = mysqli_fetch_array($qa);

											$status = $ra['status'];



											if ($status == 1) {

										?>



												<th>Edit</th>

												<!-- <th>Delete</th> -->

										<?php

											}
										}

										?>



									</tr>

								</thead>

								<tbody id="PTResults"> 

									<?php

									$sr = 1;
									$session = $_SESSION['session'];
									if(isset($_POST['class']) && isset($_POST['section']) ){
										$class=!empty($_POST['class']) ? " AND `class_id`='".$_POST['class']."'  " : '' ;
										$section=!empty($_POST['section']) ? " AND `section_id`='".$_POST['section']."'  " : '' ;
									}else{
										$class=$section='';
									}

									$query = mysqli_query($con, "select * from student_route WHERE `session`='$session' $class $section ORDER BY `modify_date` DESC");
									if (mysqli_num_rows($query) > 0) {

										while ($res = mysqli_fetch_array($query)) {

											$id = $res['sturoute_id'];

											$stuid = $res['student_id'];
											$modify_at = $res['modify_date'];

											$ssql = "select student_id,student_name,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id  where student_id='$stuid' AND `sr`.`session`='$session' ";
											$q1 = mysqli_query($con, $ssql);
											if (mysqli_num_rows($q1) > 0) {

												$r1 = mysqli_fetch_array($q1);

												$stuname = $r1['student_name'];



												$clsid = $r1['class_id'];

												$q2 = mysqli_query($con, "select * from class where class_id='$clsid'");

												$r2 = mysqli_fetch_array($q2);

												$clsname = $r2['class_name'];



												$secid = $r1['section_id'];

												$q3 = mysqli_query($con, "select * from section where section_id='$secid'");

												$r3 = mysqli_fetch_array($q3);

												$secname = $r3['section_name'];



												$tranid = $res['trans_id'];

												$q4 = mysqli_query($con, "select * from transports where trans_id='$tranid'");

												$r4 = mysqli_fetch_array($q4);

												$transname = $r4['route_name'];

												$transprice = $r4['price'];



												$feemodeid = $res['fee_mode_id'];

												$q5 = mysqli_query($con, "select * from fee_mode where fee_mode_id='$feemodeid'");

												$r5 = mysqli_fetch_array($q5);

												$mode = $r5['fee_mode_name'];



												$stuidtransprice = $res['price'];

												$discount = 0;

												$extra = 0;

												if ($transprice > $stuidtransprice) {

													$discount = $transprice - $stuidtransprice;
												} else {

													$extra = $transprice - $stuidtransprice;
												}



												$reason = $res['reason'];

									?>

												<tr>

													<td><?php echo $sr; ?></td>

													<td><?php echo $stuname; ?></td>

													<td><?php echo $clsname; ?></td>

													<td><?php echo $secname; ?></td>

													<td><?php echo $transname; ?></td>

													<td><?php echo $stuidtransprice; ?></td>

													<td><?php echo $mode; ?></td>

													<td><?php echo date('d-m-Y h:i A', strtotime($modify_at))  ?></td>



													<?php

													if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {



														if ($status == 1) {

													?>

															<td>

																<?php echo "<a href='dashboard.php?option=edit_assign_route_to_student&id=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

																?>

															</td>


<!-- 
															<td>

																<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id; ?>')"> <i class="fa fa-trash"></i> Delete </a>

															</td> -->

											<?php
														}
													}
												}

												$sr++;
											}

											?>



												</tr>

											<?php  } ?>

								</tbody>

							</table>

						</div>



						<div class="card-footer" style="display:none;">

							<a href="export_assign_route_student_excel.php" class="btn btn-success btn-sm">

								<i class="fa fa-download"></i> Download To Excel</a>

						</div>



					</div>

				</div>

			</div>

		</div><!-- .animated -->

	</div><!-- .content -->

</div><!-- /#right-panel -->

<?php //include('bootstrap_datatable_javascript_library.php'); 
?>
<?php include('datatable_links.php'); ?>
<script>
	var dataTable = $("#table-grid").DataTable({
		"lengthMenu": [
			[10, 25, 50, 100, 500, 999999999],
			[10, 25, 50, 100, 500, 'All']
		],
		// 'order':[4,'DESC'],
		dom: 'Blfrtip',

		"pageLength": 25,
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
	});
</script>