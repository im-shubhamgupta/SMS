<?php



if(isset($update))

{

	$q = mysqli_query($con,"select * from allocate_budget where allocate_budget_id ='$update' and session='".$_SESSION['session']."'");

	$r = mysqli_fetch_array($q);

	$hid = $r['budget_header_id'];

	

	$q1 = mysqli_query($con,"select * from allocate_budget_expense where budget_header_id ='$hid' and session='".$_SESSION['session']."'");

	$row = mysqli_num_rows($q1);

	if($row)

	{

		echo "<script>alert('Cannot able to Edit.')</script>";

	}

	else

	{

		echo "<script>window.location='dashboard.php?option=update_allocate_budget&id=$update'</script>";

	}

}



if(isset($delete))

{

	$q = mysqli_query($con,"select * from allocate_budget where allocate_budget_id ='$delete' and session='".$_SESSION['session']."'");

	$r = mysqli_fetch_array($q);

	$hid = $r['budget_header_id'];

	

	$q1 = mysqli_query($con,"select * from allocate_budget_expense where budget_header_id='$hid' and session='".$_SESSION['session']."'");

	$row = mysqli_num_rows($q1);

	if($row)

	{

		echo "<script>alert('Cannot able to Delete.')</script>";

	}

	else

	{

		mysqli_query($con,"delete from allocate_budget where allocate_budget_id ='$delete' and session='".$_SESSION['session']."'");

	}

}



?>

<!-- breadcrumb-->

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

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Management</a>

  <span class="breadcrumb-item active">View Allocate Budget</span>

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

                     <a href="dashboard.php?option=allocate_budget" class="btn btn-primary btn-sm">

					  <i class="fa fa-plus"></i> Allocate Budget</a>

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

                                <strong class="card-title">View Allocate Budget</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Budget Header</th>

                                            <th>Allocated Budget</th>

                                          

										<?php

										if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

										{

										?>

											<th>Edit</th>

											<th>Delete</th>

										<?php

										}

										?>	

											

                                        </tr>

                                    </thead>

                                    <tbody id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from allocate_budget where 1 and session='".$_SESSION['session']."'");
									if(mysqli_num_rows($query)>0){
									while($res=mysqli_fetch_array($query))

									{

									$id=$res['allocate_budget_id'];

									$header_id=$res['budget_header_id'];

									$q1 = mysqli_query($con,"select * from budget_header where budget_header_id='$header_id'");

									$r1 = mysqli_fetch_array($q1);

									$headername = $r1['budget_header_name'];

									$budget_amount=$res['allocate_amount'];	

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $headername; ?></td>

										<td><?php echo $budget_amount; ?></td>

										

									<?php

									if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

									{

									?>

										<td><button type="submit" name="update" class="btn btn-secondary btn-sm" value="<?php echo $id;?>"><i class='fa fa-edit'></i> Edit</button></td>

										<td><button type="submit" name="delete" class="btn btn-danger btn-sm" value="<?php echo $id;?>"><i class='fa fa-trash'></i> Delete</button></td>

										

									<?php

									}

									?>

								

									</tr>

                                    <?php $sr++; } } ?>

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

 <?php include('bootstrap_datatable_javascript_library.php'); ?>