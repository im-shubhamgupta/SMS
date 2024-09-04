<?php

//error_reporting(1);

extract($_REQUEST);

$issid = $_REQUEST['issueid'];



$q = mysqli_query($con,"select * from issue_bookto_students where issue_id='$issid'");

$r = mysqli_fetch_array($q);

$stuid = $r['student_id'];

// $q1 = mysqli_query($con,"select * from students where student_id='$stuid'");
$sql1="select `student_id`,student_name,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$stuid' ";//and sr.session='".$_SESSION['session']."'
$q1=mysqli_query($con,$sql1);
$r1 = mysqli_fetch_array($q1);

$stuname = $r1['student_name'];

$fathername = $r['father_name'];

$regno = $r['register_no'];

$mob = $r['mobile'];

$clsid = $r['class_id'];

$qc2 = mysqli_query($con,"select * from class where class_id='$clsid'");

$rc2 = mysqli_fetch_array($qc2);

$clsname = $rc2['class_name'];



$secid = $r['section_id'];

$qs3 = mysqli_query($con,"select * from section where section_id='$secid'");

$rs3 = mysqli_fetch_array($qs3);

$secname = $rs3['section_name'];



$retdt = $r['return_date'];

$curdate = date("Y-m-d");

$date1=date_create($curdate);

$date2=date_create($retdt);

$diff=date_diff($date2,$date1);

$tdays = $diff->format("%R%a days");

										

$rettypeid=$r['return_type_id'];

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



$q4 = mysqli_query($con,"select * from library_payment where issue_id='$issid'");

$tpaid = 0;

while($r4 = mysqli_fetch_array($q4))

{

	$tpaid += $r4['paid_amount']; 

}



$tdue = $tpenalty - $tpaid;









if(isset($cancel))

{

	echo "<script>window.location='dashboard.php?option=penalty_collection'</script>";

}





?>



	

	



<div id="right-panel" class="right-panel">



<style>

.breadcrumb {

    display: -ms-flexbox;

    display: flex;

    -ms-flex-wrap: wrap;

    flex-wrap: wrap;

    padding: .75rem 1rem;

    margin-bottom: 1rem;

    list-style: none;

	margin-left:-18px;

	margin-top:-17px;

    background-color: #237791;

    border-radius: .25rem;

	font-size:19px;

}

.breadcrumb-item{

	color:#fff;

}

.breadcrumb-item .fa fa-home{

	color:#fff;

}

.breadcrumb-item.active {

    color: #eff7ff;

}

.breadcrumb-item+.breadcrumb-item::before {

    display: inline-block;

    padding-right: .5rem;

    color: #eff4f9;

    content: "/";

} 



</style>

<nav class="breadcrumb" style="width:1000px">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Library Management</a>

  <span class="breadcrumb-item active">Payment</span>

</nav>





   <form method="post" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

							

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">

                            <div class="row" style="margin-top:20px;">

							<div class="col-md-12" style="margin-left:20px;">

							<h5>Student Details</h5>

							</div>

							</div><br>

														 

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">Name : </div>

								<div class="col-md-2"><?php echo $stuname; ?></div>

								

								<div class="col-md-2" style="margin-left:50px;">Father Name :</div>

								<div class="col-md-2"><?php echo $fathername; ?></div>

							</div><br>

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">Class : </div>

								<div class="col-md-2"><?php echo $clsname; ?></div>

								

								<div class="col-md-2" style="margin-left:50px;">Section :</div>

								<div class="col-md-2"><?php echo $secname; ?></div>

							</div><br>	

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">Register No : </div>

								<div class="col-md-2"><?php echo $regno; ?></div>

								

								<div class="col-md-2" style="margin-left:50px;">Mobile :</div>

								<div class="col-md-2"><?php echo $mob; ?></div>

							</div><br>

							<hr>

							

                            <div class="card-body">

                            <div class="row" style="margin-top:20px;">

								<div class="col-md-12" style="margin-left:20px;">

								<h5>Generate Bill</h5>

								</div>

							</div><br>

								

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="margin-left:20px;">Penalty Amount : </div>

								<div class="col-md-2">

								<input type="number" name="penaltyamt" id="penaltyamt" value="<?php echo $tdue; ?>" class="form-control" readonly>

								</div>

							</div><br>

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="margin-left:20px;">Paid Amount : </div>

								<div class="col-md-2">

								<input type="number" name="paidamt" id="paidamt" class="form-control">

								</div>

							</div><br>	

							<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="margin-left:20px;">Due Amount : </div>

								<div class="col-md-2">

								<input type="number" name="dueamt" id="dueamt" value="<?php echo $tdue; ?>" class="form-control" readonly>
								<input type="hidden" name="stuid" value="<?=$stuid?>">
								<input type="hidden" name="issid" value="<?=$issid?>">
								</div>

							</div><br>

							<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:20px;">

								<input type="submit" name="save" value="Save Bill" class="btn btn-primary btn-sm">

								</div>

								<div class="col-md-2" style="margin-left:20px;">

								<button type='button' onclick="history.back()"  class="btn btn-primary btn-sm" >Cancel</button>

								</div>

							</div><br>	

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

        </div><!-- .content -->

		

		<div style="text-align:center">

		<!--

		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>

		

		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->

		

		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>



<script>

$(document).ready(function(){

	$("#paidamt").blur(function(){

	var penalty = $("#penaltyamt").val();

	var paid = $("#paidamt").val();

	var tbal = parseInt(penalty) - parseInt(paid);

	 $("#dueamt").val(tbal);

	

	});

});

</script> 
<?php include('datatable_links.php')?>
<script>

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "library_payment";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/LibraryControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setInterval(function(){ 
				window.location.href='dashboard.php?option=penalty_collection';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
				$('form')[0].reset(); 
			}
			$('input[type="submit"]').val('Save bill');  
	      $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

 