<?php
    session_start();

    include'../includes/functions.php';

    $user = $_SESSION['USER'];
    $name = $_SESSION['NAME'];
    $dept_code = $_SESSION['DEPT_CODE'];

    $task_code= $_POST["task_code"];

    $progress_1 = $_POST["progress_1"];
    $progress_2 = $_POST["progress_2"];
    $progress_3 = $_POST["progress_3"];
    $progress_4 = $_POST["progress_4"];

	$task_status = $_POST["task_status"];
	$task_report = $_POST["task_report"];

	$right_now = $_POST["right_now"];
	$performance = $_POST["performance"];

    	
	if (false) 
	{
		$_SESSION['UPDATE_TASK_ERROR'] = "Avance 1 no puede estar vacio";
		header("Location: ../index.php");
	}
	else
	{		

        include '../includes/connection.php';
        
        $query = "UPDATE infoapp_tasks set progress_1 = '$progress_1', progress_2 = '$progress_2', 
        progress_3 = '$progress_3', progress_4 = '$progress_4', delivery_date = '$right_now', 
        performance = '$performance', task_status = '$task_status', task_report = '$task_report'
         WHERE task_code LIKE '$task_code'";
        echo $query;
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
				<span class="text-center"><h3>Avance de Actividades</h3></span>
				<table class="table table-bordered">
					<tr>
						<td></td>
						<td class="my_td"><img src="../imgs/update_task.png"></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Actividad actualizada con exito por <?php echo $_SESSION['NAME'];?></td>
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

	<?php $_SESSION['UPDATE_TASK_ERROR'] = '';}?>
</body>
</html>