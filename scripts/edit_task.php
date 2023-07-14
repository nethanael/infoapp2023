<?php
    session_start();

    $user = $_SESSION['USER'];
    $supervisor_code = $_SESSION['USER_CODE'];

    $task_code = $_POST["task_code"];
    $task_title = $_POST["task_title"];
    $task_description = $_POST["task_description"];

	$progress_1 = $_POST["progress_1"];
    $progress_2 = $_POST["progress_2"];
    $progress_3 = $_POST["progress_3"];
    $progress_4 = $_POST["progress_4"];

    $change_users = $_POST["change_users"];
    $user_code_1 = $_POST["user_1"];
    $user_code_2 = $_POST["user_2"];
    $user_code_3 = $_POST["user_3"];
    
    $change_task_type = $_POST["change_task_type"];
	$task_type_code = $_POST["task_type"];

    $change_perf_goal = $_POST["change_perf_goal"];
    $perf_code_1 = $_POST["perf_goal_1"];
    $perf_code_2 = $_POST["perf_goal_2"];
    $perf_code_3 = $_POST["perf_goal_3"];

	$req_date = $_POST["req_date"];

    	
	if ($task_title == '' || $task_description == '' || $req_date == '') 
	{
		$_SESSION['EDIT_TASK_ERROR'] = "Nunca puede estar vac&iacute;o el t&iacute;tulo ni la descripci&oacute;n ni la fecha de entrega";
		$myheader = "Location: ../edit_task_2.php?data=".$task_code; 
		header($myheader);
	}
	else
	{		

        if ($change_users) 
        {
            include '../includes/connection.php';
            $query2 = "UPDATE infoapp_tasks set user_code_1 = '$user_code_1', user_code_2 = '$user_code_2', user_code_3 = '$user_code_3' WHERE task_code LIKE '$task_code'";
            $resul2 = mysqli_query($conn, $query2);
		}
		
		if ($change_task_type) 
        {
            include '../includes/connection.php';
            $query3 = "UPDATE infoapp_tasks set task_type_code = '$task_type_code' WHERE task_code LIKE '$task_code'";
            $resul3 = mysqli_query($conn, $query3);
        }

        if ($change_perf_goal) 
        {
            include '../includes/connection.php';
            $query4 = "UPDATE infoapp_tasks set perf_code_1 = '$perf_code_1', perf_code_2 = '$perf_code_2', 
            perf_code_3 = '$perf_code_3' WHERE task_code LIKE '$task_code'";
            $resul4 = mysqli_query($conn, $query4);
        }
        
        include '../includes/connection.php';
        
        $query = "UPDATE infoapp_tasks set supervisor_code = '$supervisor_code', task_title = '$task_title', 
        task_description = '$task_description', progress_1 = '$progress_1', progress_2 = '$progress_2', 
        progress_3 = '$progress_3', progress_4 = '$progress_4', req_date = '$req_date' WHERE task_code LIKE '$task_code'";
        $resul = mysqli_query($conn, $query);
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
				<span class="text-center"><h3>Edici&oacute;n de Actividades</h3></span>
					<table class="table table-bordered">
						<tr>
							<td></td>
							<td  class="my_td"><img src="../imgs/edit_task.png"></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>Actividad editada con &eacute;xito por <?php echo $_SESSION['NAME'];?></td>
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
		$_SESSION['EDIT_TASK_ERROR'] = '';}
	?>
</body>
</html>