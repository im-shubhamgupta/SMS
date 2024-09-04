
<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $valueToSearch1 = $_POST['valueToSearch1'];
	
	if($valueToSearch!="" and $valueToSearch1!="")
	{
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `students` WHERE `class_id`='$valueToSearch' and section_id='$valueToSearch1'";
    $search_result = filterTable($query);
    }
	else
	{
	$query = "SELECT * FROM `students`";
    $search_result = filterTable($query);
	}
}
 else {
    $query = "SELECT * FROM `students`";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "school_billing");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP HTML TABLE DATA SEARCH</title>
        <style>
            table,tr,th,td
            {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        
        <form action="filter.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
            <input type="text" name="valueToSearch1" placeholder="Value To Search1"><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['register_no'];?></td>
                    <td><?php echo $row['student_name'];?></td>
                    <td><?php echo $row['class_id'];?></td>
                    <td><?php echo $row['section_id'];?></td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
        
    </body>
</html>

