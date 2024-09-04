<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
	
?>
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<div id="right-panel" class="right-panel">
   <form method="post" action="dashboard.php?option=view_assign_classteacher" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
								<h3 align="center">Assign Class Teachers Report </h3>
								<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Teacher</th>	
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from assign_clsteacher");		
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['assign_clst_id'];
																		
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									$clsname=$resc['class_name']; 
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									$secname=$rsec['section_name'];
									
									$stid=$res['st_id'];
									$qst=mysqli_query($con,"select * from staff where st_id='$stid'");
									$rst=mysqli_fetch_array($qst);
									$staffname=$rst['staff_name'];								
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $clsname;?></td>
										<td><?php echo $secname;?></td>
										<td><?php echo $staffname;?></td>	
									</tr>
                                    <?php $sr++;
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
		<style>
			
		@media print{
		#printbtn{
		display: none;
				}
			}
		</style>
		
		
		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>
		
		
		<a href="dashboard.php?option=view_assign_classteacher" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->

 