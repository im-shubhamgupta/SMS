<script type="text/javascript">

function del(x)

{

	//alert(x);

	var datastring={"id":x};

	$.ajax({

		url:'delete_trans_expense_type.php',

		type:'post',

		data:datastring,

		success:function(str)

		{

			if(str!='')

			{

				if(confirm('Cannot Delete '+str+' as Transport Expense is already created.')==true)

				{

					$("#PTResults").load(location.href+" #PTResults>*","");

				}

			}

			else

			{

				if(confirm('Do you want to delete?')==true)

				{

					delet(x,3);

				}

			}

          

		}

		

	});

}

	

function delet(id)

{

	//alert(id);

	var datastring={"del_id":id};

	$.ajax({

	url:'delete_trans_expense_type.php',

	type:'post',

	data:datastring,

	success:function(str)

	{

		if(str=="deleted Successfully")

		{

			$("#PTResults").load(location.href+" #PTResults>*","");

		}

		//alert(str);

		

	  

	}

	

});

}

</script>

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport Expense</a>

  <span class="breadcrumb-item active">View Transport Expense Type</span>

</nav>

<!-- breadcrumb -->

<form method="post">

<div id="right-panel" class="right-panel">

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

        <div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                     <a href="dashboard.php?option=add_transport_expense_type" class="btn btn-primary btn-sm">

					  <i class="fa fa-plus"></i> Add Transport Expense Type</a>

            </div>

        </div>

		<?php

		}

		?>	





        <div class="content mt-3" style="width:900px">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">View Transport Expense Type</strong>

                            </div>

                            <div class="card-body">

                                <table id="table-grid" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Expense Name</th>

                                          

										<?php

										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

										{

										?>

											<th>Action</th>

										<?php

										}

										?>	

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from transport_expense_type where session='".$_SESSION['session']."'");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['trans_expense_type_id'];

									$name=$res['trans_expense_type_name'];	

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $name; ?></td>

										

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>

										<td>

										<?php echo "<a href='dashboard.php?option=update_trans_expense_type&eid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";

											?>

										

																

										<!-- <a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Expense" onclick="del('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete</a> -->

										</td>

									<?php

									}

									?>

								

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
   <?php include('datatable_links.php'); ?>
 <script>

 var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 500, 999999999], [10, 25, 50, 100, 500, 'All'] ],	
                    // 'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });
</script>