<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
$fromdt = $_REQUEST['fromdt'];
$chg_fdate = date("d-m-Y", strtotime($fromdt));
	
$todt = $_REQUEST['todt'];
$chg_tdate = date("d-m-Y", strtotime($todt));

	$class = $_REQUEST['class'];
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
	
	$section = $_REQUEST['section'];
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
	
	if($fromdt=="" and $todt=="" and $class=="" and $section=="")
	{
	$query="select * from bill";
    $search_result = filterTable($query);
	}
	
	else if($class!="" and $section!="")
	{
	$query="select a.student_id, a.admfeepaid, a.tutionfeepaid, a.miscfeepaid, a.transfeepaid, a.paidby, a.challan_no, a.issued_by, a.issued_date, a.date, b.student_id 
			from bill a, students b
			where date between '$fromdt' AND '$todt' and
			a.student_id = b.student_id and b.stu_status='0' and b.class_id='$class' and b.section_id='$section'";	
	
	$search_result = filterTable($query);
    }
	
	else if($class!="" and $section=="")
	{
	$query="select a.student_id, a.admfeepaid, a.tutionfeepaid, a.miscfeepaid, a.transfeepaid, a.paidby, a.challan_no, a.issued_by, a.issued_date, b.student_id 
			from bill a, students b
			where date between '$fromdt' AND '$todt' and
			a.student_id = b.student_id and b.stu_status='0' and b.class_id='$class'";					
	$search_result = filterTable($query);
    }
	
	else if($class=="" and $section=="")
	{
    $query="select a.student_id, a.admfeepaid, a.tutionfeepaid, a.miscfeepaid, a.transfeepaid, a.paidby, a.challan_no, a.issued_by, a.issued_date, b.student_id 
			from bill a, students b
			where date between '$fromdt' AND '$todt' and
			a.student_id = b.student_id and b.stu_status='0'";
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
		
		font-size:12px;
	}

	tr td{
		
		font-size:12px;
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<div id="right-panel" class="right-panel">
   <form method="post" action="dashboard.php?option=view_discount_students" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
								<h3 align="center">Discounted Student Details</h3>
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Student Name</th>
											 <th>Register No</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Tution Fees Discount</th>
											 <th>Tution Fees Discount Reason</th>
											 <th>Transport Fees Discount</th>
											 <th>Transport Fees Discount Reason</th>
                                             <th>Total Discount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								<?php 
								$sr=1;
								$gdtotal=0;
								$query=mysqli_query($con,"select * from students where stu_status='0' and tutionfee_disc!='' or transfee_disc!=''");
								
								$counts=mysqli_num_rows($query);			
								while($res=mysqli_fetch_array($query))
								{
								$id=$res['student_id'];
								$clid=$res['class_id'];
								$quec=mysqli_query($con,"select * from class where class_id='$clid'");
								$resc=mysqli_fetch_array($quec);

								$seid=$res['section_id'];
								$qse=mysqli_query($con,"select * from section where section_id='$seid'");
								$rsec=mysqli_fetch_array($qse);

								$tution_disc=$res['tutionfee_disc'];
								$trans_disc=$res['transfee_disc'];
								$total_amount=$tution_disc+$trans_disc;						
								?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $resc['class_name']; ?></td>
										<td><?php echo $rsec['section_name']; ?></td>
										<td><?php echo $res['tutionfee_disc']; ?></td>
										<td><?php echo $res['tutionfeedisc_reason']; ?></td>
										<td><?php echo $res['transfee_disc']; ?></td>
										<td><?php echo $res['transfeedisc_reason']; ?></td>
										<td><?php echo $total_amount; ?></td>
																		
									</tr>
									
                                    <?php
									$sr++;			
									$gdtotal=$gdtotal+$total_amount;									
									}
									
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div>
						
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<?php 
						
						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> Total Discount from the School to $counts Students  : Rs $gdtotal </h5>" ;	
						
						?>
						</div>						
						</div><br>
						
						
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<style>
			
		@media print{
		#printbtn{
		display: none;
				}
			}
		</style>
		
		
		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>
		
		
		<a href="dashboard.php?option=view_discount_students" class="btn btn-primary" style="margin-left:20px;margin-top:18px" id="printbtn">Back</a>
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->

 