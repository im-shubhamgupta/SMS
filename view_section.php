<script type="text/javascript">

// function del(x)

// {

// 	//alert(x);

// 	var datastring={"id":x};

// 	$.ajax({

// 		url:'delete_section.php',

// 		type:'post',

// 		data:datastring,

// 		success:function(str)

// 		{

// 			if(str!="")

// 			{

// 				if(confirm('Students already added to the '+ str +' section. Cannot be deleted.')==true)

// 				{

// 					$("#PTResults").load(location.href+" #PTResults>*","");

// 				}

// 			}

// 			else

// 			{

// 				if(confirm('Do you want to delete the Section?')==true)

// 				{

// 					delet(x,3);

// 				}

// 			}

          

// 		}

		

// 	});

// }

	

// function delet(id)

// {

// 	//alert(id);

// 	var datastring={"del_id":id};

// 	$.ajax({

// 	url:'delete_section.php',

// 	type:'post',

// 	data:datastring,

// 	success:function(str)

// 	{

// 		if(str=="deleted Successfully")

// 		{

// 			$("#PTResults").load(location.href+" #PTResults>*","");

// 		}

// 		//alert(str);

		

	  

// 	}

	

// });

// }

</script>

<form method="post">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Configuration Panel</a>

  <a class="breadcrumb-item" href="#">Section</a>

  <span class="breadcrumb-item active">View Section</span>

</nav>

<!-- breadcrumb -->

<div id="right-panel" class="right-panel">

		<?php

		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

		{

		?>

        <div class="breadcrumbs">

            <div class="col-sm-4" style="padding:10px;">  

                <a href="dashboard.php?option=add_section&smid=<?php echo '4';?>" class="btn btn-primary btn-sm">

				<i class="fa fa-plus"></i> Add Section</a>

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

                                <strong class="card-title">View Section</strong>

                            </div>

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>

                                        <tr>

                                            <th>Sr. No</th>

                                            <th>Class</th>

											 <th>Section</th>

											 

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

                                    <tbody  id="PTResults">

									<?php 

									$sr=1;

									$query=mysqli_query($con,"select * from section where `deletion_indicator`='0'");

									while($res=mysqli_fetch_array($query))

									{

									$id=$res['section_id'];

									$name=$res['section_name'];

									$class_id=$res['class_id'];									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

									

									<?php 

									$re=mysqli_query($con,"select * from class where class_id='$class_id'");

									$result=mysqli_fetch_array($re);

									?>	

										<td><?php echo $result['class_name']; ?></td>

										<td><?php echo $name; ?></td>

										

										

								<?php

								if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")

								{

								?>			

										<td>

										

										<?php echo "<a href='dashboard.php?option=update_section&sid=$id' class='btn btn-secondary btn-sm px-2'>Edit <i class='fa fa-edit' aria-hidden='true'></i></a>"?>

																			

										<a title="Delete Section" class="btn btn-danger btn-sm text-white" onclick="del('<?php echo $id;?>')">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>

										

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

 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 <?php include('datatable_links.php')?>
 <script>
	"use strict";
 function del(x){
	// alert(x);
	if(confirm('Are you sure want to Delete???')===true){
		var datastring={"id":x,
			"ArchiveTable":'section',
			"Archive_dataidtype":'section_id',
			"status": '0' ,
			"ArchiveData":1	
		};
			$.ajax({
			url:'DeletionHandler.php',
			type:'post',
			data:datastring,
			success:function(str){
				if(str=='success'){
					toastr.success("Delete Sucessfully");
					setInterval(function(){
						location.reload();},4000
					);
				}else{
					toastr.error(str);
				}
			}
		});
	}	
}
</script>