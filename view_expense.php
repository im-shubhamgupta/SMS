<script type="text/javascript">
	function delet(id)
	{
		var reason=prompt("Do you want to Delete this Expense??");
		if(reason=="") 
		{
		alert("Please Enter Reason ???");
		}
		else if(reason)
		{	
		window.location.href="deleteexpense.php?x=" + id + "& rea=" +reason;
		return true;
		}
		else
		{	
		return false;
		}
	}
</script>
<form method="post">
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Expense</a>
  <span class="breadcrumb-item active">View Expense</span>
</nav>
<!-- breadcrumb -->
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_expense&smid=<?php echo '26';?>" class="btn btn-primary btn-sm">
					  <i class="fa fa-plus"></i> Add Expense</a>
            </div>
        </div>
		<?php
		}
		?>	
<!-- style="width:1100px" -->
        <div class="content mt-3" >
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Expenses</strong>
                            </div>
                            <div class="card-body">
							<!-- table-responsive -->
                                <table id="table-grid" class="table table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Expense Receipt No</th>
                                            <th>Expense Type</th>
											<th>Expense Details</th>
											<th>Amount</th>
											<th>Point of Contact</th>
											<th>Expensed Datetime</th>
											<th>Proof</th>
											<th style="width:300px"> Action</th>
										</tr>
                                    </thead>
                                    <tbody id="PTResults">
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from expense where status='0' and session='".$_SESSION['session']."'");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['expense_id'];
									$exp_typeid=$res['expense_type_id'];
									$proof=$res['proofs'];
									$expdt = $res['expensed_datetime'];
									$chgexdt = date("d-m-Y h:i:s A", strtotime($expdt));
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $id; ?></td>
										<?php 
									$re=mysqli_query($con,"select * from expense_type where expense_type_id='$exp_typeid'");
									$result=mysqli_fetch_array($re);
									?>
										<td><?php echo $result['expense_type_name']; ?></td>
										<td><?php echo $res['expense_details']; ?></td>
										<td><?php echo $res['amount']; ?></td>
										<td><?php echo $res['point_of_contact']; ?></td>
										<td><?php echo $chgexdt;?></td>
										<td><img src="images/proof/<?php echo $proof; ?>" height="70px" width="70px"></td>
				<!-- For Permission -->						
								
										
										<td>
										<?php echo "<a href='dashboard.php?option=updateexpense&eid=$id&smid=27' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";
											?>
										
										<a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Expense" onclick="delet('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete</a>
										</td>
																
				<!-- For Permission -->	
				
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
	</form>
 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
 <?php
 include('datatable_links.php'); ?>

	<script>
	 $(document).ready(function(){
			var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 500,-1], [10, 25, 50, 100, 500, 'All'] ],	
                    //'order':[7,'ASC'],
                    dom: 'Blfrtip',
					"scrollX": true,
					buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    "pageLength":25,
					iDisplayLength:3,
					aLengthMenu:[
						menulengths,menulengths
					],
				});
			});
	</script>	