<?php
    session_start();

    $user = $_SESSION['USER'];
    $supervisor_code = $_SESSION['USER_CODE'];

    $task_code = $_POST["task_code"];
	$creation_date = $_POST["creation_date"];
    $req_date = $_POST["req_date"];

	$month = date("m");
	$year = date("y");
    	
	if ($req_date == '') 
	{
		$_SESSION['REACTIVATE_TASK_ERROR'] = "Error: falta nueva fecha de entrega";
		$myheader = "Location: ../reactivate_task_2.php?data=".$task_code; 
		header($myheader);
	}
	else
	{		

        include '../includes/connection.php';
        
        $query = "UPDATE infoapp_tasks set supervisor_code = '$supervisor_code', 
        progress_1 = null, progress_2 = null, progress_3 = null, progress_4 = null, 
        creation_date = '$creation_date', req_date = '$req_date', month = $month, 
        year = '$year', task_status = 0, task_report = 0, delivery_date = null, performance = 0
        WHERE task_code LIKE '$task_code'";
        $result = mysqli_query($conn, $query);
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
				<span class="text-center"><h3>Reapertura de Actividades</h3></span>
				<table class="table table-bordered">
					<tr>
						<td></td>
						<td class="my_td"><img src="../imgs/reactivate_task.png"></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Actividad reactivada con &eacute;xito por <?php echo $_SESSION['NAME'];?></td>
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

	<?php $_SESSION['REACTIVATE_TASK_ERROR'] = '';}?>
</body>
</html>