<?php
error_reporting(1);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
include('connection.php');

$query = mysqli_query($con, "select * from setting ");
if (mysqli_num_rows($query) > 0) {
	$res = mysqli_fetch_array($query);
	$fontstyle = $res['font_style'];
	$company_name = $res['company_name'];
	$company_short_name = $res['company_short_name'];
	$company_address = $res['company_address'];
	$registration_number = $res['registration_number'];
	$affiliation_number = $res['affiliation_number'];
	$company_email = $res['company_email'];
	$show_email = $res['show_email'];
	$company_number = $res['company_number'];
	$show_number = $res['show_number'];
	$company_image = $res['company_image'];
	$watermark = $res['watermark'];

	$company_url = $res['company_url'];
	$show_email_checked = ($res['show_email'] == '1') ? 'checked' : '';
	$show_number_checked = ($res['show_number'] == '1') ? 'checked' : '';
	$show_url_checked = ($res['show_url'] == '1') ? 'checked' : '';
} else {
	$fontstyle = '';
	$company_name = '';
	$company_short_name = '';
	$company_address = '';
	$registration_number = '';
	$affiliation_number = '';
	$company_email = '';
	$show_email = '';
	$company_number = '';
	$show_number = '';
	$company_image = '';
	$company_url = '';
	$show_url = '';
	$watermark = '';
}

$Equery = mysqli_query($con, "select * from emergency_contact Limit 3 ");
if ($Equery && mysqli_num_rows($Equery) > 0) {
	$ECquery=$Equery;
} else {
	$ECquery='';
}

?>
<!-- breadcrumb-->

<style>
	
</style>

<nav class="breadcrumb">
	<a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
	<a class="breadcrumb-item" href="#">Configuration Panel</a>
	<a class="breadcrumb-item" href="#">Institute Settings</a>
	<span class="breadcrumb-item active">View & Update Settings</span>
</nav>
<div class="tab">
	<button class="tablinks" onclick="openTab(event, 'Profile')" id="defaultOpen">Update Profile</button>
	<button class="tablinks" onclick="openTab(event, 'EmengencyContact')">Emergency Contacts</button>
</div>

<div id="Profile" class="tabcontent">
	<!-- breadcrumb -->
	<div class="content mt-3">
		<div class="col-lg-12">
			<div class="card" >
				<div class="card-header">
					<strong>Update</strong> Profile
				</div>
				<div class="card-body card-block">
					<form method="post" enctype="multipart/form-data"  name="formElem" class="form-horizontal" id="formElem">

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Institute Name <span style="color:red;font-weight:bold">*</span></label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="email-input" name="cname" value="<?php echo $company_name; ?>" class="form-control Institute_name" required autofocus>
								<span id='Institute_error' style="color:red;"></span>
							</div>

						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Short Name </label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="email-input" name="short_name" value="<?php echo $company_short_name; ?>" class="form-control short_name " style="text-transform: uppercase;" maxlength='8'>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3"> <label for="email-input" class=" form-control-label">Registration Number<span style="color:red;font-weight:bold">*</span></label></div>
							<div class="col-12 col-md-9"> <input type="text" id="email-input" name="Rnumber" value="<?php echo $registration_number; ?>" class="form-control" required autofocus></div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3"> <label for="email-input" class=" form-control-label">Affiliation No. / UDISE Code<span style="color:red;font-weight:bold">*</span></label></div>
							<div class="col-12 col-md-9"> <input type="text" id="email-input" name="Anumber" value="<?php echo $affiliation_number; ?>" class="form-control" required autofocus></div>
						</div>

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class="form-control-label">Select Font </label>
							</div>
							<div class="col-12 col-md-9">
								<select class="form-control" name="nfont">
									<option <?php if ($fontstyle == "Times New Roman, Times, serif") {
												echo "selected";
											} ?> value="Times New Roman, Times, serif">Times New Roman</option>
									<option <?php if ($fontstyle == "Arial, Verdana, Helvetica") {
												echo "selected";
											} ?> value="Arial, Verdana, Helvetica">Arial</option>
									<option <?php if ($fontstyle == "Impact, fantasy") {
												echo "selected";
											} ?> value="Impact, fantasy">Impact</option>
									<option <?php if ($fontstyle == "Aachen, sans-serif") {
												echo "selected";
											} ?> value="Aachen, sans-serif">Aachen</option>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Address <span style="color:red;font-weight:bold">*</span></label>
							</div>
							<div class="col-12 col-md-9">
								<textarea id="email-input" name="caddress" class="form-control" required autofocus><?php echo $company_address; ?></textarea>
							</div>
						</div>

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Email Id <span style="color:red;font-weight:bold">*</span></label>
							</div>


							<div class="col-12 col-md-8">
								<input type="text" id="email-input" name="cmail" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="<?php echo $company_email; ?>" class="form-control" required autofocus>
							</div>
							<div class="col col-md-1" style="padding-left:0px;">
								<input class="toggle-one" name="show_email" data-toggle="toggle" data-onstyle="warning" data-offstyle="info" data-class="fast" <?= $show_email_checked ?> type="checkbox" value="1">
							</div>
						</div>

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Contact <span style="color:red;font-weight:bold">*</span></label>
							</div>

							<div class="col-12 col-md-8">
								<input type="text" id="contact1" name="cnumber" value="<?php echo $company_number; ?>" class="form-control" required autofocus>
							</div>
							<div class="col col-md-1" style="padding-left:0px;">
								<input class="toggle-one" name="show_number" data-toggle="toggle" data-onstyle="warning" data-offstyle="info" data-class="fast" <?= $show_number_checked ?> type="checkbox" value="1">
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">URL</label>
							</div>

							<div class="col-12 col-md-8">
								<input type="text" id="company_url" name="company_url" value="<?php echo $company_url; ?>" class="form-control" autofocus>
							</div>
							<div class="col col-md-1" style="padding-left:0px;">
								<input class="toggle-one" name="show_url" data-toggle="toggle" data-onstyle="warning" data-offstyle="info" data-class="fast" <?= $show_url_checked ?> type="checkbox" value="1">
							</div>
						</div>

						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Watermark</label>
							</div>

							<div class="col-12 col-md-8">
								<input type="text" id="watermark" name="watermark" value="<?php echo $watermark; ?>" class="form-control" autofocus>
							</div>

						</div>


						<div class="row form-group">
							<div class="col col-md-3">
								<label for="file-input" class=" form-control-label">Update Logo <span style="color:red;font-weight:bold">*</span><br>
									<font color="red">Size must be 250x250 Pixel</font>
								</label>
							</div>
							<div class="col-12 col-md-9"><input type="file" name="file" class="form-control-file"></div>

							
						</div>
						<img src="images/profile/<?php echo $company_image; ?>" width="200px" height="200px" style="margin-left:260px;margin-top:15px;border-radius:50%;border:5px solid #5194ff" />
						<div class="row"><span><b>Note</b>: ON/OFF button is used for show & hide fields. </span></div>


						<!--- hidden field----------------------------------------->

						<input type="hidden" value="<?= $_SESSION['registration_no']; ?>" name="registration_no">
						<input type="hidden"  name="view_edit_inst_setting" value="1" required >					
				</div>

				<?php
				if ($_SESSION['user_roles'] == "superadmin" or $_SESSION['user_roles'] == "admin") {
				?>
					<div class="card-footer">
						<button type="submit" name="view_edit_inst_setting" id="update_school" class="btn btn-secondary btn-sm">
							<i class="fa fa-edit"></i> Update
						</button>

					</div>
				<?php
				}
				?>


			</div>
			</form>
		</div>
	</div>
</div>
<!-- -----------------------------------------------------Tab 2------------------------------------------------------------- -->
<div id="EmengencyContact" class="tabcontent">
	<div class="content mt-3">
		<div class="col-lg-12">
		<!-- style="width:900px;" -->
			<div class="card" >
				<div class="card-header">
					<strong>Emergency</strong> Contacts
				</div>
				<div class="card-body card-block">
					<form method="post" name="formEmergency" enctype="multipart/form-data" class="form-horizontal" id="formEmergency">

					<?php
					if(!empty($ECquery)){
					foreach($ECquery as $m){?>
					
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="email-input" class=" form-control-label">Contact No. : </label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="email-input" name="mobile[]" maxlength="10" value="<?php echo $m['mobile']; ?>" class="form-control Institute_name"  autofocus>
								<span id='Institute_error' style="color:red;"></span>
							</div>

						</div>
						
					<?php } } ?>	
 					<input type="hidden"  name="UpdateEmergencyContacts" value="1" required >
					<div class="card-footer">
						<button type="submit" name="submit" id="update_contact"  class="btn btn-secondary btn-sm">
							<i class="fa fa-edit"></i> Update
						</button>

					</div>
					</form>
				</div>
			</div>
		</div>
	</div>


</div>








</div>

<script>
	$(document).ready(function() {

		$('.Institute_name').keypress(function(e) {

			var regex = new RegExp(/^[a-zA-Z0-9\s]+$/);
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				$('#Institute_error').html('');
				return true;
			} else {
				$('#Institute_error').html('*Please do not enter any special character');

				e.preventDefault();
				return false;
			}
		});
	});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
	$(function() {
		$('.toggle-one').bootstrapToggle();
	})
</script>
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
			"timeOut": "3000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
	});
	"use strict";
	$(document).ready(function() {
		$('form').on('submit', function(e) {
			e.preventDefault();
			// console.log(this);
			// var action = "view_edit_inst_setting";
			// var name=$(this).closest('form').find("button[type='submit']").attr('name');
			// var name=$(this).find("button[type='submit']").attr('name');
			// $(this).append("<input type='hidden' name=" + action + " >");
			var data_string = new FormData(this);
			$("button[type='submit']").html("please wait...");
			$('button[type="submit"]').attr("disabled", true);

			// alert(name);

			$.ajax({
				url: "Controllers/ConfigurationControllers.php",
				type: "POST",
				data: data_string,
				contentType: false,
				cache: false,
				processData: false,
				success: function(responce) {
					var result = JSON.parse(responce);
					// alert(responce);
					console.log(responce);
					if (result.status == "success") {
						// alert('success');
						toastr.success(result.message);
						setInterval(function() {
							window.location.href = 'dashboard.php?option=view_edit_inst_setting&smid=9';
							// $('form')[0].reset(); 
						}, 3000);

					} else {
						toastr.error(result.message);
					}
					$('button[type="submit"]').html('<i class="fa fa-edit"></i> Update ');
					$('button[type="submit"]').attr("disabled", false);
				}
			})
		});

	});
</script>
<!-- nav bar settings------------------------------------------ -->
<script>
	document.getElementById("defaultOpen").click();

	function openTab(evt, cityName) {
		// Declare all variables
		var i, tabcontent, tablinks;

		// Get all elements with class="tabcontent" and hide them
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		// Get all elements with class="tablinks" and remove the class "active"
		tablinks = document.getElementsByClassName("tablinks");
		// console.log(tablinks);
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		// Show the current tab, and add an "active" class to the button that opened the tab
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
</script>