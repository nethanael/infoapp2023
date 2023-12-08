<?php
	$ts = gmdate("D, d M Y H:i:s") . " GMT";
	header("Expires: $ts");
	header("Last-Modified: $ts");
	header("Pragma: no-cache");
	header("Cache-Control: no-cache, must-revalidate");
	
	session_start();

	if ($_SESSION['LOGIN_INFOAPP'] == FALSE ){header("Location: index.php");}
    else
       {
        if ($_SESSION['ROLE_NAME'] == "administrator") header("Location: home_admin.php");
        if ($_SESSION['ROLE_NAME'] == "supervisor") header("Location: home_supervisor.php");
        //if ($_SESSION['ROLE_NAME'] == "employee") header("Location: home_employee.php");
        }

    include 'includes/functions.php';
    include 'includes/connection.php';   
    
    $today = date("Y-m-d H:i");
    $user_code = $_SESSION['USER_CODE'];
    
    $tasks_table="infoapp_tasks";
    $task_type_table="infoapp_task_type";
    $fields="task_code, task_type_title, task_title, task_description, req_date";
    $ONclause1="infoapp_tasks.task_type_code=infoapp_task_type.task_type_code";
    $whereClause="( user_code_1 LIKE '$user_code' OR user_code_2 LIKE '$user_code' OR user_code_3 LIKE '$user_code') AND task_report = 0";
    $result = db_select_1_inner_query($tasks_table, $task_type_table, $fields, $ONclause1, $whereClause);
    
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
        <meta http-equiv="refresh" content="60" />
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/test_borders.css">
		<title>Sistema de Informes</title>
	</head>
<body>
    <div class = "container my_cont">

	<?php include 'includes/header.php'; ?>
	<?php include 'includes/navBar.php'; ?>
          
		<div class = "row justify-content-center my_row my_scrollable_div">
            <?php
                foreach ($result as $row) {

					$time_left = dateDifference($today,$row["req_date"]);
				
					if ($time_left == "N/A")
					{
						$custom_class = "";
						}else{
							if ($time_left <= 0){
								$custom_class = "text-danger";
							}else {
								if ($time_left <= 2){
									$custom_class = "text-warning";
								}else{
									$custom_class = "text-primary";
							}
						}
					};

					echo '<div class = "col-sm-6 my_col">';
						echo '<div class="card bg-light mb-3">';
							echo '<div class="card-header">';
								echo $row['task_type_title'];
							echo '</div>';
							echo '<div class="card-body '.$custom_class.'">';
								echo '<h5 class="card-title">'.$row["task_title"].'</h5>';
								echo '<h6 class="card-subtitle mb-2 text-muted">Codigo: '.$row["task_code"].'</h6>';
								echo '<p class="card-text">'.$row["task_description"].'</p>';
								echo '<h6 class="card-subtitle mb-2 text-muted">Entrega: '.$row["req_date"].'</h6>';
								echo '<h6 class="card-subtitle mb-2 text-muted">Dias: '.$time_left.'</h6>';
								echo '<a href="update_task.php?data='.$row['task_code'].'" class="btn btn-primary">Avances</a>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
                }
            ?>
            </div>
            <div class = "row justify-content-center my_row">
				<div class = "col-4 my_td"><a class="btn btn-info" href="index.php">Volver</a></div>
			</div>
        </div> 
        
		<?php
            mysqli_free_result($result); 
            include 'includes/footer.php'; 
        ?>

	</div>
</body>
</html>