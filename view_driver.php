<script type="text/javascript">
	function del(x)

	{

		//alert(x);

		var datastring = {
			"id": x
		};

		$.ajax({

			url: 'delete_driver.php',

			type: 'post',

			data: datastring,

			success: function(str)

			{

				if (str == 'true')

				{

					if (confirm('Cannot Delete Driver. Routes are linked with this Driver.') == true)

					{

						$("#PTResults").load(location.href + " #PTResults>*", "");

					}

				} else

				{

					if (confirm('Do you want to delete?') == true)

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

			url: 'delete_driver.php',

			type: 'post',

			data: datastring,

			success: function(str)

			{

				if (str == "deleted Successfully")

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

		<a class="breadcrumb-item" href="#">Transport Panel</a>

		<a class="breadcrumb-item" href="#">Transport</a>

		<span class="breadcrumb-item active">View Driver & Cleaner</span>

	</nav>

	<!-- breadcrumb -->

	<?php

	if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {

	?>

		<div class="breadcrumbs">

			<div class="col-sm-4" style="padding:10px;">

				<a href="dashboard.php?option=add_driver" class="btn btn-primary btn-sm">

					<i class="fa fa-plus"></i> Add Driver & Cleaner</a>

			</div>

		</div>

	<?php

	}

	?>


	<!--class="content mt-3"  style="width:1030px" -->
	<div class="content mt-3"  >

		<div class="animated fadeIn">

			<div class="row">



				<div class="col-md-12">

					<div class="card">

						<div class="card-header">

							<strong class="card-title">View Driver & Cleaner</strong>

						</div>

						<div class="card-body"  style="width:1030px">

							<table id="table-grid" class="table table-striped table-bordered table-responsive">

								<thead>

									<tr>

										<th>Sr. No</th>

										<th>Name</th>

										<th>Father Name</th>

										<th>Gender</th>

										<th>Mobile No.</th>

										<th>Alternate No.</th>

										<th>City</th>

										<th>Address</th>

										<th>Designation</th>
										<th>Join Date</th>


										<th>Experience</th>

										<th>DL Number</th>

										<th>Aadhar Number</th>

										<th>Previous Experience</th>

										<th>About Him/Her</th>
										<th>Status</th>

										<?php

										if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {

										?>

											<th width="160">Edit</th>

											<th width="160">Delete</th>

										<?php

										}

										?>



									</tr>

								</thead>

								<tbody id="PTResults">

									<?php

									$sr = 1;

									$query = mysqli_query($con, "select * from driver where  session='" . $_SESSION['session'] . "' ORDER BY `modify_date` DESC "); //session='".$_SESSION['session']."'

									while ($res = mysqli_fetch_array($query)) {

										$id = $res['id'];

									?>

										<tr>

											<td><?php echo $sr; ?></td>

											<td><?php echo $res['name']; ?></td>

											<td><?php echo $res['father_name']; ?></td>

											<td><?php echo $res['gender']; ?></td>

											<td><?php echo $res['mobile']; ?></td>

											<td><?php echo $res['alternate_no']; ?></td>

											<td><?php echo $res['address']; ?></td>

											<td><?php echo $res['city']; ?></td>

											<td><?php echo $res['designation']; ?></td>

											<td><?php echo date('d-m-Y h:i A', strtotime($res['date'])); ?></td>

											<td><?php echo $res['experience']; ?></td>

											<td><?php echo $res['dlno']; ?></td>

											<td><?php echo $res['aadhar_no']; ?></td>

											<td><?php echo $res['previous_exp']; ?></td>

											<td><?php echo $res['description']; ?></td>
											<td><?php if ($res['status'] == 0) {
													echo 'Active';
												} else {
													echo 'Deactive';
												} ?></td>



											<?php

											if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {

											?>

												<td>

													<?php echo "<a href='dashboard.php?option=update_driver&did=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

													?>

												</td>



												<td>

													<a title="Deleted" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id; ?>')"> <i class="fa fa-trash"></i> Delete </a>

												</td>

											<?php

											}

											?>



										</tr>

									<?php $sr++;
									} ?>

								</tbody>

							</table>

						</div>



						<div class="card-footer">

							<a href="export_viewdriver_excel.php" class="btn btn-success btn-sm">

								<i class="fa fa-download"></i> Download To Excel</a>

						</div>



					</div>

				</div>

			</div>

		</div><!-- .animated -->

	</div><!-- .content -->

</div><!-- /#right-panel -->

<?php // include('bootstrap_datatable_javascript_library.php'); 
?>
<?php include('datatable_links.php'); ?>
<script>
// 	 var w = $(window).width();
// 	 console.log(w);
//  $('.content').css('width', w);



	var dataTable = $("#table-grid").DataTable({
		"lengthMenu": [
			[10, 25, 50, 100, 500, 999999999],
			[10, 25, 50, 100, 500, 'All']
		],
		// 'order':[4,'DESC'],
		dom: 'Blfrtip',

		"pageLength": 25,
		"scrollX": true,
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],

	});
</script>
<!-- iDisplayLength:3,
					aLengthMenu:[
						menulengths,menulengths
					], -->