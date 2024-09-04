<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

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
   <form method="post" action="dashboard.php?option=view_transport_availed" enctype="multipart/form-data">      
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
											 <th>Register No</th>
											 <th>Student Name</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Route</th>
											 <th>Transport Fees</th>
											 <th>Paid</th>
											 <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								<?php 
								$sr=1;
								$query=mysqli_query($con,"select * from students where stu_status='0' and trans_id!=''");
								while($res=mysqli_fetch_array($query))
								{
								$stuid=$res['student_id'];
								$clid=$res['class_id'];
								$quec=mysqli_query($con,"select * from class where class_id='$clid'");
								$resc=mysqli_fetch_array($quec);
								
								$seid=$res['section_id'];
								$qse=mysqli_query($con,"select * from section where section_id='$seid'");
								$rsec=mysqli_fetch_array($qse);
								
								$transid=$res['trans_id'];
								$qtr=mysqli_query($con,"select * from transports where trans_id='$transid'");
								$rtr=mysqli_fetch_array($qtr);
								$transfee=$rtr['price']-$res['transfee_disc'];
								
								$qbil=mysqli_query($con,"select * from bill where student_id='$stuid'");
								$tpaid=0;
								while($rbill=mysqli_fetch_array($qbil))
								{
								$tpaid=$tpaid+$rbill['transfeepaid'];
								
								}
								$bal=$transfee-$tpaid;					
								?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $rsec['section_name'];?></td>
										<td><?php echo $rtr['route_name']; ?></td>
										<td><?php echo $transfee; ?></td>
										<td><?php echo $tpaid; ?></td>
										<td><?php echo $bal; ?></td>
																		
									</tr>
									
                                    <?php
									$sr++;			
									}
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div>
						
						<div class="row">
						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
						<?php 
						
						//echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> Total Discount from the School to $counts Students  : Rs $gdtotal </h5>" ;	
						
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
		
		
		<a href="dashboard.php?option=view_transport_availed" class="btn btn-primary" style="margin-left:20px;margin-top:18px" id="printbtn">Back</a>
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->

 