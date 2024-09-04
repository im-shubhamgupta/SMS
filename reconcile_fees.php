<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{

	$fromdt1 = $_POST['fromdt'];

	$chg_fdate = date("d-m-Y", strtotime($fromdt1));

	

    $todt1 = $_POST['todt'];

	$chg_tdate = date("d-m-Y", strtotime($todt1));

	

	$ptypeid = $_POST['paidby']; 

	

    $class = $_POST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls)

	{

		$clsn=$cls;

	}else

	{

		$clsn='Class All';

	}

	

    $section = $_POST['section'];

    $s=mysqli_query($con,"select * from section where section_id='$section'");

	$rs=mysqli_fetch_array($s);

	$se=$rs['section_name'];

	if($se)

	{

		$sec=$se;

	}else

	{

		$sec='All';

	}

	

	if($class!="" and $section!="")

	{

	$query="select a.student_due_fee_id, a.student_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.payment_type_id, 

	a.payment_detail, a.bank_name, a.remarks, a.issue_date, b.student_id from student_due_fees as a join students as b ON  a.student_id = b.student_id  join student_records as sr ON b.student_id=sr.stu_id

			where 1  and b.stu_status='0' and sr.class_id='$class' and sr.section_id='$section'  and status='0'  ";	

	// $search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select a.student_due_fee_id, a.student_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.payment_type_id, a.payment_detail, a.bank_name, a.remarks, a.issue_date, b.student_id from student_due_fees as a join students as b ON  a.student_id = b.student_id  join student_records as sr ON b.student_id=sr.stu_id
	 where 1  and b.stu_status='0' and sr.class_id='$class' and status='0' ";					


	// student_due_fees a, students b
	// $search_result = filterTable($query);

    }else if($class=="" and $section==""){

	$query="select a.student_due_fee_id, a.student_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.payment_type_id, a.payment_detail, a.bank_name, a.remarks, a.issue_date, b.student_id 

			from  student_due_fees as a join students as b ON  a.student_id = b.student_id  join student_records as sr ON b.student_id=sr.stu_id
		

			where 1 and b.stu_status='0'  and status='0' ";					



    }

    if(!empty($fromdt) && !empty($todt)){

    	$query.=" and date between '$fromdt' AND '$todt'  ";

    }
    if(!empty($ptypeid)){
    	$query.=" and payment_type_id='$ptypeid'   ";
    }
    // echo $query;
    	$query.="  and sr.session='".$_SESSION['session']."'   ";

    	$query.="  order by a.modify_date desc   ";
	$search_result = filterTable($query);

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

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Accounts Panel</a>

  <span class="breadcrumb-item active">Reconcile Fees</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=reconcile_fees" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

                    	<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-60px;margin-top:-10px">

							

							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;">

							<option value="" selected="selected">All</option>

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

							

							<div class="col-md-2" style="margin-left:50px;">Section </div>

							<div class="col-md-2" style="margin-left:-70px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" style="width:175px;">

							<option value="" selected="selected">All</option>

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

							

							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:150px;margin-left:50px;" value="Submit"><br><br>

							</div>

							

						</div>
						<span><small><u>(Optional filters)</u></small></span>

						

                        <div class="row" style="margin-top:20px;">

								

								<div class="col-md-2" style="margin-left:20px;">From Date</div>

								<div class="col-md-2" style="margin-left:-60px;margin-top:-10px;">

								<input type="date" name="fromdt" class="form-control" style="width:175px;" value="<?php echo $fromdt; ?>" autofocus >

								</div>

								

								<div class="col-md-2" style="margin-left:50px;">To Date</div>

								<div class="col-md-2" style="margin-left:-70px;margin-top:-10px">

								<input type="date" name="todt" class="form-control" style="width:175px;" value="<?php echo $todt; ?>" autofocus >

								</div>

								

								<div class="col-md-2" style="margin-left:50px;">Payment Mode</div>

								<div class="col-md-2" style="margin-left:-30px;margin-top:-10px">

								<select class="form-control" name="paidby" autofocus > 

									<option value="" selected="selected" >All</option>

									<?php

									$qpt = mysqli_query($con,"SELECT * FROM payment_type where payment_type_id!=1");

									while( $rpt = mysqli_fetch_array($qpt) ) {

									?>

									<option <?php if($paidby==$rpt['payment_type_id']){echo "selected";}?> value="<?php echo $rpt['payment_type_id']; ?>"><?php echo $rpt['payment_type_name']; ?>

									</option>

									<?php } ?>	

								</select>

								</div>

							

						</div><br>

						

						

						

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <!-- <table id="bootstrap-data-table-export" class="table table-striped table-bordered"> -->
                                <table id="table-grid" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Name</th>

											 <th>Reg No</th>

											 <th>Father Name</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Roll No.</th>

											 <th>Total Paid</th>

											 <th>Payment Mode</th>

											 <th>Cheque / DD / Txn No</th>

											 <th>Bank Name</th>

											 <th>Remarks</th>

											 <th>Approve</th>

											 <th>Decline</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									if(isset($search))

									{

									$sr=1;

									while($res1=mysqli_fetch_array($search_result))

										{									

									$id = $res1['student_due_fee_id'];	

										

									$stuid=$res1['student_id'];

									

									// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0' and session='".$_SESSION['session']."'");
									$que2=mysqli_query($con,"select `student_name`,`register_no`,`father_name`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`roll_no` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
									if(mysqli_num_rows($que2)>0){

									while($res2=mysqli_fetch_array($que2)){

									

									$cid=$res2['class_id'];

									$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

									$rcls=mysqli_fetch_array($qcls);

									

									$sectid=$res2['section_id'];

									$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

									$rsec=mysqli_fetch_array($qsec);

									

										$sfee=$res1['received_amount'];

										$sfeearr = explode(',',$sfee);	



										$prevfeepaid=$res1['previous_amount'];

										$transfeepaid=$res1['transport_amount'];

										$ptid=$res1['payment_type_id'];

										$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");

										$rptid=mysqli_fetch_array($qptid);

										$paidby=$rptid['payment_type_name'];

										

										$pdetail=$res1['payment_detail'];

										$bankname=$res1['bank_name'];

										$remarks=$res1['remarks'];	

											

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res2['student_name']; ?></td>

										<td><?php echo $res2['register_no']; ?></td>

										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>
										<td><?= ($res2['roll_no']) ? $res2['roll_no'] : '0' ; ?></td>

										

										<?php

										$tfee1 = 0;

										$tfee2 = 0;

										foreach($sfeearr as $v)

										{

											$tfee1 = $tfee1 + intval($v);

										

										}

										$tfee2 = $tfee1 + $transfeepaid + $prevfeepaid;

										?>

										<td><?php echo $tfee2; ?></td>

										<td><?php echo $paidby;?></td>										

										<td><?php echo $pdetail;?></td>										

										<td><?php echo $bankname;?></td>										

										<td><?php echo $remarks;?></td>

										<td><a onclick="Approve(<?=trim($id,0)?>)"  class="btn btn-success" style="width:80px;border-radius:20px">Approve</a></td>
										<!-- return confirm('Do you want to Approve the Transaction')" href="dashboard.php?option=approve_reconcile_fees&id=<?php// echo $id;?>&smid=33" -->

										<td><a onclick="return decline(<?=trim($id,0)?>)" href="javascript:void(0)" class="btn btn-danger" style="width:80px;border-radius:20px">Decline</a></td>

										<!-- dashboard.php?option=decline_reconcile_fees&id=<?php echo $id;?>&smid=33" -->



									</tr>

									

                                    <?php

									$sr++;									

										}

										$gtotal = $gtotal + $tfee2;

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

		

		<div style="text-align:center">

		

		<script>

		// function decline()

		// {			

		// 	var result = prompt("Please enter the reason to declined the transaction");

			

		// 	if (result == "")

		// 	{

		// 		alert("Please Enter Reason");

		// 		return false;

		// 	}

		// 	else if (result === null) {

		// 		return false;

		// 	}

		// 	else 

		// 	{

		// 		return true;
		// 		// return result;

		// 	}

					

		// }		

		

		</script>

		

		<style>


			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

		

			

		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <!-- <?php //include('bootstrap_datatable_javascript_library.php'); ?> -->
 <?php include('datatable_links.php'); ?>
  <script>
	 $(document).ready(function(){
 			
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 200, 500, 1000, 2000, 5000], [10, 25, 50, 100, 200, 500, 1000, 2000, 5000] ],	
                    // 'order':[4,'DESC'],
                     "scrollX": true,
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'print'
                    ],
                });
                });
</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
	toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		// "positionClass": "toast-bottom-right",	
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
		};	});

	function decline(id){
		var reason=prompt("Enter Reason for Decline.");

		if(reason==""){

		    alert("Please Enter Reason ???");

		}else if(reason){	
			 
			var	datastring='id='+ id +'&reason='+ reason +'&Decline_Reconcile_fees='+ 1 ; 
	           
	        $.ajax({              	
	 		    type: "POST",    
	 		    url : 'Controllers/AccountFeesController.php', 
	 		    data : datastring,
	 		    // contentType: false,   
		    	// cache: false,    
		    	// processData:false, 
		    	success: function (responce) {  
			    	var responce = JSON.parse(responce);	
	 		    	    if(responce.status=='success') { 
	 		    	        toastr.success(responce.msg);	 
	 		    	    	setInterval(function(){
	 		    	    	
	 		    	    
	 		    	    	window.location.reload();
	 		    	    		},4000);		
	 		    	    	
	 		    	    }else{      
	 		    	    	// $('#registration_btn').attr('disabled',false);
	 		    	    	// $('#error').html(responce.msg);
	 		    	    	toastr.error("Somethings is Wrong, Please try Again");			
	 		    	    }
	 		  	    }	
	 		  	});
	 	
	 		
		
			    // window.location.href="update_admission_ref_decline.php?x=" + id + "& rea=" +reason;

			return true;

		}else{	

		return false;

		}

	}
	function Approve(id){
		if(confirm("Do you want to Approve")){
		// var id=id;	
		 
		var	datastring='id='+ id +'&Approve_Reconcile_Fees='+ 1 ; 
		// alert(datastring);
           
        $.ajax({              	
 		    type: "POST",    
 		    url : 'Controllers/AccountFeesController.php', 
 		    data : datastring,
 		    // contentType: false,   
	    	cache: false,    
	    	// processData:false, 
	    	success: function (responce) {  
		    	var responce = JSON.parse(responce);	
 		    	    if(responce.status=='success') {  
 		    	    	 // $('#registration_btn').attr('disabled',false);
 		     		  	 // $('#error').html(""); 
 		    	    	toastr.success(responce.msg);		
 		    	    	setInterval(function(){
	 		    	    	
	 		    	    
	 		    	    	window.location.reload();
	 		    	    		},4000);
 		    	    }else{      
 		    	    	// $('#registration_btn').attr('disabled',false);
 		    	    	// $('#error').html(responce.msg);
 		    	    	toastr.error("Somethings is Wrong, Please try Again");			
 		    	    }
 		  	    }	
 		  	});
 	
 		
		}else{
			return false;
		}

	}

		

</script>
 

 