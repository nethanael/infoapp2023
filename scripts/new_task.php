<?php
    session_start();

    include'../includes/functions.php';

    $user = $_SESSION['USER'];
    $name = $_SESSION['NAME'];
    $dept_code = $_SESSION['DEPT_CODE'];
    $task_type_code = $_POST["task_type"];
    $perf_code_1 = $_POST["perf_goal_1"];
	$perf_code_2 = $_POST["perf_goal_2"];
	$perf_code_3 = $_POST["perf_goal_3"];
    $supervisor_code = $_SESSION['USER_CODE'];
    $task_title = $_POST["task_title"];
    $task_description = $_POST["task_description"];
    $user_code_1 = $_POST["user_1"];
    $user_code_2 = $_POST["user_2"];
    $user_code_3 = $_POST["user_3"];
    $creation_date = $_POST["creation_date"];
	$req_date = $_POST["req_date"];
    $month = date("m");
	$year = date("y");
    $today = date("d/m/y H:i a");
    	
	if ($task_type_code == '' || $perf_code_1 == '' || $perf_code_2 == '' || $task_title == '' 
	|| $task_description == '' || $user_code_1 == '' || $req_date == '')

	{
		$_SESSION['NEW_TASK_ERROR'] = "¡Todos los campos con asterisco son obligatorios!";
		$_SESSION['TASK_TITLE_TEMP'] = $task_title;
		$_SESSION['TASK_DESCRIPTION_TEMP'] = $task_description;
		header("Location: ../new_task.php");
	}
	else
	{		

        $table='infoapp_tasks';

        $fields='(dept_code, task_type_code, perf_code_1, perf_code_2, perf_code_3, supervisor_code, task_title, task_description, user_code_1, 
        user_code_2, user_code_3, month, year, creation_date, req_date )';
        
        $values="('$dept_code','$task_type_code', '$perf_code_1', '$perf_code_2', '$perf_code_3', '$supervisor_code', '$task_title', '$task_description', '$user_code_1', 
		'$user_code_2', '$user_code_3', '$month', '$year', '$creation_date', '$req_date')";

        db_insert_query($table, $fields, $values);
    
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/test_borders.css">
		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container my_cont">
		
		<?php include '../includes/header.php'; ?>

    	<div class = "row justify-content-center my_row">
			<div class = "col-4 my_col">
				<!-- (row_!Centro!) -->
				<span class="text-center"><h3>Creaci&oacute;n de Actividades</h3></span>
				<table class="table table-bordered">
					<tr>
						<td></td>
						<td class="my_td"><img src="../imgs/new_task.png"></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Actividad creada con &eacute;xito por <?php echo $_SESSION['NAME'];?></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td class="my_td"><a class="btn btn-info" href="../index.php">Volver</a></td>
						<td></td>
					</tr>
				</table>
			</div>
    	</div>

		<?php include '../includes/footer.php'; ?>

	</div>

	<?php 
	
	$_SESSION['TASK_TITLE_TEMP'] = '';
	$_SESSION['TASK_DESCRIPTION_TEMP'] = '';
	$_SESSION['NEW_TASK_ERROR'] = '';
	
	}?>

</body>
</html>