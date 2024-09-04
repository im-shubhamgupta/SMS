<script type="text/javascript">
	function delet(id)
	{
		if(confirm("Do You want to delete this Book???"))
		{
			window.location.href='delete_book.php?x='+id;
		}
	}
</script>
<form method="post">
<div id="right-panel" class="right-panel">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Library Management</a>
  <a class="breadcrumb-item" href="#">Configuration</a>
  <span class="breadcrumb-item active">View Books</span>
</nav>
<!-- breadcrumb -->
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="library")
		{
		?>
        <div class="breadcrumbs">
            <div class="col-sm-4" style="padding:10px;">  
                     <a href="dashboard.php?option=add_books" class="btn btn-primary btn-sm">
					 <i class="fa fa-plus"></i> Add Books</a>
            </div>
        </div>
		<?php
		}
		?>	

        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">View Books</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Book Name</th>
                                            <th>Book ISBN</th>
                                            <th>Author</th>
                                            <th>Publisher</th>
                                            <th>Book Type</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Vendor</th>
                                            <th>Branch</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									$query=mysqli_query($con,"select * from books");
									while($res=mysqli_fetch_array($query))
									{
									$id=$res['book_id'];
									$pubid=$res['publisher_id'];
									$qpub = mysqli_query($con,"select * from publisher where publisher_id='$pubid'");
									$rpub = mysqli_fetch_array($qpub);
									$publishername = $rpub['publisher_name'];
									
									$booktypeid=$res['book_type_id'];
									$qbk = mysqli_query($con,"select * from book_type where book_type_id='$booktypeid'");
									$rbk = mysqli_fetch_array($qbk);
									$booktypename = $rbk['book_type_name'];
									
									$vendorid=$res['vendor_id'];
									$qvn = mysqli_query($con,"select * from vendor where vendor_id='$vendorid'");
									$rvn = mysqli_fetch_array($qvn);
									$vendorname = $rvn['vendor_name'];
									
									$brid=$res['branch_id'];
									$qbr = mysqli_query($con,"select * from branch where branch_id='$brid'");
									$rbr = mysqli_fetch_array($qbr);
									$branchname = $rbr['branch_name'];
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['book_name']; ?></td>
										<td><?php echo $res['book_isbn']; ?></td>
										<td><?php echo $res['author']; ?></td>
										<td><?php echo $publishername; ?></td>
										<td><?php echo $booktypename; ?></td>
										<td><?php echo $res['quantity']; ?></td>
										<td><?php echo $res['price']; ?></td>
										<td><?php echo $vendorname; ?></td>
										<td><?php echo $branchname; ?></td>
										<td><?php echo "<a href='dashboard.php?option=update_books&eid=$id' class='btn btn-secondary btn-sm'> <i class='fa fa-edit'></i> Edit</a>";?></td>
										<td><a href="#"	class="btn btn-danger btn-sm text-white" title="Delete Books" onclick="delet('<?php echo $id;?>')"> <i class="fa fa-trash"></i> Delete</a></td>
																
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
 <?php include('bootstrap_datatable_javascript_library.php'); ?>