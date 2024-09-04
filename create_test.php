<style>

</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".menu a").each(function() {
			if ($(this).hasClass("disabled")) {
				$(this).removeAttr("href");
			}
		});
	});
</script>
<!-- class="right-panel" -->
<div id="right-panel" class="right-panel">
	<!-- breadcrumb-->

	<nav class="breadcrumb">
		<a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
		<!-- <a class="breadcrumb-item" href="#"></a> -->
		<a class="breadcrumb-item" href="#">Exam & Result Panel</a>
		<a class="breadcrumb-item" href="#">Exam & Result </a>
		<span class="breadcrumb-item active">Create Test</span>
	</nav>
	<!-- breadcrumb -->


	<div class="tab">
		<button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Create Test</button>
	</div>



	<form method="post" id="devel-generate-content-form" enctype="multipart/form-data">
		<div class="content mt-3" style="width:100%">
			<div class="animated fadeIn">
				<div class="row">
					<div id="London" class="tabcontent" style="width:100%">
						<div class="col-md-12">
							<div class="row" style="margin-top:20px;">
								<div class="col-md-2" style="font-size:14px;margin-left:50px;">Class</div>
								<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
									<select name="class" class="form-select" onchange="search_sec(this.value)" style="width:175px;" autofocus>
										<option value="" selected="selected" disabled>Select Class</option>
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

								<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>
								<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
									<select class="form-select" name="section" id="search_sect" style="width:175px;" autofocus>
										<option value="" selected="selected" disabled>Select Section</option>
										<?php
										$qsec = mysqli_query($con, "select * from section where class_id='$class'");
										while ($rsec = mysqli_fetch_array($qsec)) {
											$secname = $rsec['section_name'];
										?>
											<option <?php if ($section == $rsec['section_id']) {
														echo "selected";
													} ?> value="<?php echo $rsec['section_id']; ?>">
												<?php echo $rsec['section_name']; ?>
											</option>
										<?php
										}
										?>
									</select>

									<script>
										function search_sec(str) {
											var xmlhttp = new XMLHttpRequest();
											xmlhttp.open("get", "search_ajax_section_report.php?cls_id=" + str, true);
											xmlhttp.send();
											xmlhttp.onreadystatechange = function() {
												if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
													document.getElementById("search_sect").innerHTML = xmlhttp.responseText;
												}
											}
										}
									</script>
								</div>
							</div><br>

							<div class="row" style="margin-top:20px;">
								<div class="col-md-2" style="font-size:14px;margin-left:50px;">Test Name </div>
								<div class="col-md-2" style="margin-left:-100px;margin-top:-10px;">
									<input type="text" name="testname" value="<?php echo $testname; ?>" class="form-control" style="width:175px;" autofocus required>
								</div>

								<div class="col-md-2" style="margin-left:90px;">
									<input id="LoadSubject" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:50px;" value="Load">
									<br><br>
								</div>

							</div><br>

						</div><br>

					</div>



					<!-- table starts from here bootstrap-data-table-export  table-responsive-->
					<div class="card" id="createtest_panel" style="display:none;">
						<div class="card-body">
							<div class="">
								<div class="col-md-12">
									<table id="table-grid" class="table table-striped table-bordered ">
										<thead>
											<tr>
												<!-- <th>Sl No.</th> -->
												<th>Selection</th>
												<th>Subject Name</th>
												<th>Min Marks</th>
												<th>Max Marks</th>
												<th>No Of Question </th>
												<th>Start Date</th>
												<th>Start Time</th>
												<th>End Time</th>
												<th>Room No</th>

											</tr>
										</thead>
										<tbody id="LoadSubjectdata">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div><br>




					<script>
						document.getElementById("defaultOpen").click();

						function openCity(evt, cityName) {
							// Declare all variables
							var i, tabcontent, tablinks;

							// Get all elements with class="tabcontent" and hide them
							tabcontent = document.getElementsByClassName("tabcontent");
							for (i = 0; i < tabcontent.length; i++) {
								tabcontent[i].style.display = "none";
							}

							// Get all elements with class="tablinks" and remove the class "active"
							tablinks = document.getElementsByClassName("tablinks");
							for (i = 0; i < tablinks.length; i++) {
								tablinks[i].className = tablinks[i].className.replace(" active", "");
							}

							// Show the current tab, and add an "active" class to the button that opened the tab
							document.getElementById(cityName).style.display = "block";
							evt.currentTarget.className += " active";

							$('#LoadSubjectdata').empty();
						}
					</script>





					<script>
						function checkmarks(x) {
							var number = x.match(/\d+/);

							var minid = ("minmark" + number);
							var maxid = ("maxmark" + number);

							var min = $('#' + minid).val();
							var max = $('#' + maxid).val();

							if ((min != '') && (max != '')) {
								minval = parseInt(min);
								maxval = parseInt(max);

								if (maxval < minval) {
									alert('Max Marks should be greater than Min Marks.');
									$('#' + x).val('');
									$('#' + x).focus();
								}
							}
						}
					</script>


					<script>
						function checktime(x) {
							var number = x.match(/\d+/);

							var stid = ("starttime" + number);
							var etid = ("endtime" + number);

							var start = $('#' + stid).val();
							var end = $('#' + etid).val();

							if ((start != '') && (end != '')) {
								if (end < start) {
									alert('End time should not be lesser than start time.');
									$('#' + x).val('');
									$('#' + x).focus();
								}
							}
						}
					</script>


					<script>
						$(document).ready(function() {
							$(".nonegative").keyup(function() {
								if ($(this).val() < 0) {
									$(this).val('');
									return false;
								}

							});
						});
					</script>


					<script>
						function savesub(x) {
							//alert(x);
							var minm = 'minmark' + x;
							var maxm = 'maxmark' + x;
							var tdate = 'testdate' + x;
							var stime = 'starttime' + x;
							var etime = 'endtime' + x;
							var room = 'roomno' + x;
							var no_of_question = 'no_of_question' + x;
							if ($("#" + x).prop('checked') == true) {
								$("#" + minm).prop('disabled', false);
								$("#" + maxm).prop('disabled', false);
								$("#" + tdate).prop('disabled', false);
								$("#" + stime).prop('disabled', false);
								$("#" + etime).prop('disabled', false);
								$("#" + room).prop('disabled', false);
								$("#" + no_of_question).prop('disabled', false);
							} else {
								//alert(minm);
								$("#" + minm).prop('disabled', true);
								$("#" + minm).val('');
								$("#" + maxm).prop('disabled', true);
								$("#" + maxm).val('');
								$("#" + tdate).prop('disabled', true);
								$("#" + tdate).val('');
								$("#" + stime).prop('disabled', true);
								$("#" + stime).val('');
								$("#" + etime).prop('disabled', true);
								$("#" + etime).val('');
								$("#" + room).prop('disabled', true);
								$("#" + room).val('');
								$("#" + no_of_question).prop('disabled', true);
								$("#" + no_of_question).val('');
							}
						}
					</script>



					<script>
						$(document).ready(function() {

							var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');

							$checkboxes.change(function() {

								var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
								//alert(countCheckedCheckboxes);
								$('#count-checked-checkboxes').val(countCheckedCheckboxes);
							});

						});
					</script>


				</div>
			</div>
		</div><!-- .animated -->
</div><!-- .content -->
<br />

<div class="row" id="create_test_btn" style="display:none;">
	<div class="col-md-3">
	</div>
	<div class="col-md-2" id="check">
		<input type="checkbox" name="check" style="width:20px;height:20px;" / checked>
		<span style="margin-left:5px;">Send SMS</span>
	</div>
	<div class="col-md-2" style="margin-bottom: 25px;">
		<input type="submit" id="createtest" value="Create Test" class="btn btn-primary btn-md" / disabled>
	</div>
</div>



</form>






</div><!-- /#right-panel -->

<!-- <?php
		 include('bootstrap_datatable_javascript_library.php'); 
		?> -->
<?php include('datatable_links.php'); ?>

 <script>
		// var dataTable = $("#table-gri           d").DataTable({
        //             // "lengthMenu": [ [10, 25, 50, 100, 500, 999999999], [10, 25, 50, 100, 500, 'All'] ],	
        //             // 'order':[4,'DESC'],
        //             dom: 'Blfrtip',
		// 			"ordering":false,
        //             // "pageLength":25,
		// 			"scrollX": true,
        //             // buttons: [
        //             // 'copy', 'csv', 'excel', 'pdf', 'print'
        //             // ],
        //         });


</script>
<script>
	// $('#bootstrap-data-table-export').DataTable({
	// 	"ordering": false
	// });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-bottom-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
		$('#devel-generate-content-form')[0].reset();
	});

	$('#LoadSubject').on('click', function(e) {

		$("#createtest_panel").show();
		$("#create_test_btn").show();


		$("input[type='hidden']").removeAttr('name');
		var action = 'LoadSubject';
		$(this).append('<input type="hidden" name="' + action + '"/>');
		var formData = new FormData($('#devel-generate-content-form')[0]);
		$.ajax({
			type: "POST",
			url: 'AjaxHandler.php',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			success: function(responce) {
				$('#LoadSubjectdata').html(responce);
				if(!$( "table#table-grid" ).hasClass("dataTable")){
					var dataTable = $("#table-grid").DataTable({
						dom: 'Blfrtip',
						"pageLength":25,
						"ordering":false,
						"searching":false,
						"scrollX": true,
						"paging": false,
						"info": false,
					});
			    }	
				$("#createtest").prop('disabled', false);
			}
		});
	});





	$('form').on('submit', function(e) {
		if (!confirm('Do you want to create a Exam')) {
			e.preventDefault();
		} else {
			$("input[type='hidden']").removeAttr('name');
			var action = 'CreateTest';
			$(this).append('<input type="hidden" name="' + action + '"/>');
			$("input[type='submit']").attr("value", "Sending, please wait...");
			$("input[type='submit']").attr("disabled", true);
			$.ajax({
				type: "POST",
				url: 'AjaxHandler.php',
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(responce) {
					var response = JSON.parse(responce);
					if (response.status == 'success') {
						toastr.success("Test Created Successfuly!");
						// setInterval(function(){ 
						//     window.location.href='dashboard.php?option=update_test';
						// },3000);
						setTimeout(function() {
							$('#devel-generate-content-form')[0].reset();
							$("#createtest_panel").hide();
							$("#create_test_btn").hide();
							$("input[type='submit']").attr("disabled", false);
							$("input[type='submit']").attr('value', 'Submit');
						}, 3000);

					} else if (response.status == 'already') {
						toastr.error("Test Already Created");
						$("input[type='submit']").attr("disabled", false);
						$("input[type='submit']").attr('value', 'Submit');
					} else {
						toastr.error("Ops Somethings is Wrong!");
						$("input[type='submit']").attr("disabled", false);
						$("input[type='submit']").attr('value', 'Submit');
					}
				}
			});
			e.preventDefault();
			return false;
		}
	});
</script>
