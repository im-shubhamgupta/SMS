<?php
//error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
    $class = $_POST['class'];
    $section = $_POST['section'];
	
	if($class!="" and $section=="All")
	{
    // search in all table columns
		$query = "SELECT * FROM `student_wise_fees` WHERE `class_id`='$class' and session='".$_SESSION['session']."'";
		$search_result = filterTable($query);
    }
	else if($class!="" and $section!="All")
	{
		$query = "SELECT * FROM `student_wise_fees` WHERE `class_id`='$class' and (section_id='$section' or section_id is NULL) AND session='".$_SESSION['session']."'";
		$search_result = filterTable($query);
	}	

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
	/* tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	} */

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
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <span class="breadcrumb-item active">Collect Fees</span>
</nav>


	<form method="post" action="dashboard.php?option=view_student_fees_detail" enctype="multipart/form-data">      
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
								<select name="class" class="form-select" onchange="search_sec(this.value)" autofocus required>
								<option value="" selected="selected" disabled >Select Class</option>
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
								<option value="" selected disabled>Select Section</option>
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
                                <!-- <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive"> -->
                                <table id="table-grid" class="table table-striped table-bordered " >	

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
											 <th>Roll no.</th>
											 <?php 
											
											 $qf = mysqli_query($con,"select * from assign_fee_class where class_id='$class'  && session='".$_SESSION['session']."' ");
											 $rf = mysqli_fetch_array($qf);
											 $fid = $rf['fee_header_id'];
											 $arr = explode(',',$fid);
											
											 foreach($arr as $k)
											 {
									
											 $qf1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
											 $rf1 = mysqli_fetch_array($qf1);
											 $rhname = $rf1['fee_header_name'];
					                         $rhtype = $rf1['type'];
							 
								              if($rhtype==0){
									            $rhtime="(Y)";
												}else{
													$rhtime="(M)";
												}
											 ?>
											 <th><?php echo $rhname.' '.$rhtime; ?></th>
											 
											 <?php
											 }
											 ?>
											 <th>Previous Due</th>
											 <th>Total Discount</th>
											 <th>Total Fee (Y)</th>
											 <th>Total Paid Amount</th>
											 <th> Due</th>
											 
											 
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
                                  
									if(isset($_POST['search']))
									{
										while($res=mysqli_fetch_array($search_result))
									{
									$stuid=$res['student_id'];
									$dueamt=$res['due_amount'];
								    $fsql="select `student_name`,`register_no`,`father_name`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`roll_no` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."' ";	
									
									$q1 = mysqli_query($con,$fsql);
									if(mysqli_num_rows($q1)>0){	
										$r1 = mysqli_fetch_array($q1);
										$stuname=$r1['student_name'];
										$regno=$r1['register_no'];
										$fathername=$r1['father_name'];
										$clsid=$r1['class_id'];
										$admission='5';
										$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");
										$r2 = mysqli_fetch_array($q2);
										$classname = $r2['class_name'];
										$secid=$r1['section_id'];
										$q3 = mysqli_query($con,"select * from section where section_id='$secid'");
										$r3 = mysqli_fetch_array($q3);
										$secname = $r3['section_name'];
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
											echo "<a href='dashboard.php?option=generate_bill&stuid=$stuid&smid=29' target='_blank' class='btn btn-outline-success btn-sm' title='Generate Bill'>Generate Bill</a>";
											}
											?>
											
											<?php
											?>
											</td>
											
											<td>
											<?php echo "<a href='dashboard.php?option=view_payment&stuid=$stuid'  target='_blank'  class='btn btn-outline-success btn-sm' title='View all Payment History'>Payment History</a>";?>
											</td>
											
											<td><?php echo $stuname; ?></td>
											<td><?php echo $regno; ?></td>
											<td><?php echo "Mr&nbsp;".$fathername; ?></td>
											<td><?php echo $classname; ?></td>
											<td><?php echo $secname; ?></td>
											<td><?= ($r1['roll_no']) ? $r1['roll_no'] : '0' ; ?></td>
											
											<?php 
											$fhid = $res['fee_header_id'];
											$fheadarr = explode(',',$fhid);
											// print_r($fheadarr);											
											$fhamt = $res['fee_amount'];
											$famtarr = explode(',',$fhamt);
											// print_r($famtarr);
											foreach($arr as $k)
											{
											  if(in_array($k,$fheadarr))
											   {
												  $pos = array_search($k,$fheadarr);
												  $val = $famtarr[$pos];
											?>	
											<td><?php echo $val; ?></td>										
											<?php
												
											   }
											}
											?>
											
											<?php
											$qf = mysqli_query($con,"select * from previous_fees where student_id='$stuid'  && session='".$_SESSION['session']."' ");
											$rf = mysqli_fetch_array($qf);
											$prefee = $rf['previous_fees'];
											if(isset($prefee))
											{
												$previousfee = $prefee;
											}
											else
											{
												$previousfee = 0;
											}
											?>
											<!--<td><?php echo $previousfee; ?></td>-->
											
											
										
											
											<?php
											$q4 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1')  && session='".$_SESSION['session']."' ");
											$transamt = 0 ;
											$pamt = 0;
											$totalpaidamt = 0;
											$due = 0;
											while($r4 = mysqli_fetch_array($q4))
											{
												$recdamt = $r4['received_amount'];
												$prevamt = $r4['previous_amount'];
												$late_fee = $r4['late_fee'];
												$ramtarr = explode(',',$recdamt);
												foreach($ramtarr as $a1)
												{
													$pamt = (int)$pamt+ (int)$a1;      //show error use intval()
												}
												
												
												
												$totalpaidamt = (int)$pamt + (int)$prevamt+$late_fee;
											
											}
											
											$totaldiscount = $res['discount_amount'];
											
											// $q5 = mysqli_query($con,"select * from students where student_id='$stuid'  && session='".$_SESSION['session']."' ");
											$q5 = mysqli_query($con,"select `due`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
											$r5 = mysqli_fetch_array($q5);
											$due = $r5['due'];
											
											
											$qtf = mysqli_query($con,"select * from assign_fee_class where class_id='$clsid'  && session='".$_SESSION['session']."' ");
											$rtf = mysqli_fetch_array($qtf);
											$totalfee = $rtf['total_amount'] + $previousfee - $totaldiscount;
											
											$due=(int)$totalfee-(int)$totalpaidamt;
											if($due<0){
												$due=0;	
											}
																					
											?>
											<td><?php echo $previousfee; ?></td>
											<td><?php echo $totaldiscount; ?></td>
											<td><?php echo $totalfee; ?></td>
											<td><?php echo $totalpaidamt; ?></td>
											<td><?php echo $due; ?></td>
											
											
											
										</tr>
	                                    <?php
										$sr++;
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
 	<script>
	 $(document).ready(function(){
 			// function custom_params() {
            //     let new_form_data = {
            //     classtype : $("#ClassType").val(),
            //     section : $("#search_sect").val(),
	        //     }	    
	        //     return new_form_data;
	        //     }  
        	
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 200,-1 ], [10, 25, 50, 200,'All'] ],	
                    // 'order':[4,'ASC'],
                    order: [[ 8, 'asc' ], [0 , 'asc' ]],
                    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
					$("td:first", nRow).html(iDisplayIndex +1);
					return nRow;
					},
                    
                    // dom: 'Blfrtip',

                    // "pageLength":25,
                    // buttons: [
                    // 'copy', 'csv', 'excel', 'print'
                    // ],
					// "processing": true,
					// "serverSide": true,
                    "scrollX": true,
                    // "columnDefs": [
				    //   { "targets": [0], "orderable": false }
				    // ]
				    // "columnDefs": [ { orderable: false, targets: [0] }]
				
			});
			// $('#ClassType').on( "change", function() {
			// $('#table-grid').DataTable().ajax.reload();
			// });
    });
</script> 

 
 