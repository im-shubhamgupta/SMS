<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

    $class = $_POST['class'];

    $section = $_POST['section'];
	$session=$_SESSION['session'];
	

	if($class!="" and $section=="All"){
		$query = "SELECT * FROM `student_route` WHERE `class_id`='$class' and session='$session' ";

		// $search_result = filterTable($query);

    }elseif($class!="" and $section!="All"){

		$query = "SELECT * FROM `student_route` WHERE `class_id`='$class' and section_id='$section' and session='$session' ";

		// $search_result = filterTable($query);

	}elseif(empty($class)){

		$query = "SELECT * FROM `student_route` WHERE 1  and session='$session' ";
	}	
// echo $query;

	$search_result = filterTable($query);

}




function filterTable($query)

{

	include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}





?>



	<style>

	tr th{

		

		font-size:14px;

	}



	tr td{

		

		font-size:14px;

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

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Fees</a>

  <a class="breadcrumb-item" href="#">Collect Transport Fees</a>

  <span class="breadcrumb-item active">View Transport Fees</span>

</nav>





	<form method="post" action="dashboard.php?option=view_transport_fee_detail" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

							

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                              

								<div class="row" style="margin-top:20px;">

								<div class="col-md-2" style="margin-left:10px;">Class</div>

								<div class="col-md-2">

								<div class="sorting-left">

								<select name="class" class="form-select" onchange="search_sec(this.value)" autofocus >

								<option value="" selected="selected"  >All Class</option>

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

								<select class="form-select" name="section" id="search_sect">

								<option value="" selected disabled>All</option>

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

								document.getElementById("search_sect").innerHTML=xmlhttp.responseText;

								}

								} 

								}

								</script>

								

								</div>

								</div>

								

								<div class="col-md-1" style="margin-left:50px;">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

							    </div>

 

                            </div>

							

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>
                                             <th>Generate Bill</th>

											 <th>View Payments</th>

											 <th>Name</th>

											 <th>Reg No</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>

											 <th>Contact No</th>

											 <th>Transport Fees</th>

											 <th>Previous Transport Fees</th>

											 <th>Total Discount</th>

											 <th>Total Amount</th>

											 <th>Paid Fees</th>

											 <th>Due Fees</th>

											 

											 

                                        </tr>

                                    </thead>

                                    <tbody >
                                    										<?php 

									$sr=1;

									if(isset($search_result))

									{

									if(mysqli_num_rows($search_result)>0){

										while($res=mysqli_fetch_array($search_result))

									{

									$stuid=$res['student_id'];

									$dueamt=$res['due_amount'];
									$trans_id=$res['trans_id'];
									$no_of_months =$res['no_of_months'];
									$trans_amt =$res['price'];

									

									// $q1 = mysqli_query($con,"select * from students where student_id='$stuid'  and session='".$_SESSION['session']."' ");
									$q1=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'") ;

									if(mysqli_num_rows($q1)>0){

									$r1 = mysqli_fetch_array($q1);

									$stuname=$r1['student_name'];

									$regno=$r1['register_no'];

									$fathername=$r1['father_name'];

									$contact=$r1['parent_no'];

																

									$clsid=$r1['class_id'];

									$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

									$r2 = mysqli_fetch_array($q2);

									$classname = $r2['class_name'];

									

									$secid=$r1['section_id'];

									$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

									$r3 = mysqli_fetch_array($q3);

									$secname = $r3['section_name'];

									

									$transid = $res['trans_id'];

									$q4 = mysqli_query($con,"select * from transports where trans_id='$transid'");

									$r4 = mysqli_fetch_array($q4);

									// $trans_amt = $r4['price'];

									

									$trans_disc = $res['discount'];

									

									$q5 = mysqli_query($con,"select * from previous_transport_fees where student_id='$stuid' and session='".$_SESSION['session']."' ");

									$r5 = mysqli_fetch_array($q5);

									if(mysqli_num_rows($q5))

										{

										$pretransfee = $r5['previous_transport_fees'];

										}

										else

										{

											$pretransfee = 0;

										}

										
									$trans_amount_paid=	$trans_amt*$no_of_months;	
									$total_amount = ($trans_amt*$no_of_months) + $pretransfee ; //- $trans_disc

									

									$qfee2 = mysqli_query($con,"select * from student_transport_due_fees where student_id='$stuid' && (status='0' || status='1')  and session='".$_SESSION['session']."' and `trans_id`='$trans_id'   order by modify_date desc ");
// 
									$tramt = 0;

									$ptramt = 0;

									$total_amt_paid = 0;
									$only_trans_paid=0;

									while($rfee2 = mysqli_fetch_array($qfee2))

									{

										$rectransamt = $rfee2['trans_amount'];

										$tramt = $tramt + $rectransamt;
									

										$prevtransamt = $rfee2['previous_trans_amount'];

										$ptramt = $ptramt + $prevtransamt;

									}	

										

										$total_amt_paid += $tramt + $ptramt;
										$only_trans_paid +=$tramt; 

							

									// $duefee = $trans_amt + $pretransfee - $trans_disc - $total_amt_paid;
									$duefee = $trans_amount_paid- $only_trans_paid;

									?>

									<tr>

										<td><?php echo $sr; ?></td>
										<td>

										<?php 

										if($dueamt==0)

										{										

										?>

										<button type="button" class="btn btn-outline-success btn-sm" disabled>Generate Bill</button>

										<?php

										}

										else

										{

										echo "<a href='dashboard.php?option=generate_transport_bill&stuid=$stuid&smid=29' class='btn btn-outline-success btn-sm' target='_blank' title='Generate Bill'>Generate Bill</a>";

										}

										?>

										

										<?php

										?>

										</td>

										

										<td>

										<?php echo "<a href='dashboard.php?option=view_transport_payment&stuid=$stuid' class='btn btn-outline-success btn-sm'  target='_blank' title='View all Payment History'>Payment History</a>";?>

										</td>


										<td><?php echo $stuname; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo "Mr&nbsp;".$fathername; ?></td>

										<td><?php echo $classname; ?></td>

										<td><?php echo $secname; ?></td>

										<td><?php echo $contact; ?></td>

										<td><?php echo $trans_amt; ?></td>

										<td><?php echo $pretransfee; ?></td>

										<td><?php echo $trans_disc; ?></td>

										<td><?php echo $total_amount; ?></td>

										<td><?php echo $total_amt_paid; ?></td>

										<td><?php echo $duefee; ?></td>

										

										
										

									</tr>

                                    <?php

									$sr++;

										}
									  }
									}

									 } 

									

									?>


									

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('datatable_links.php'); ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){	
  toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
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
		};					}); 

 var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // 'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
					"scrollX": true,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });
</script>


 