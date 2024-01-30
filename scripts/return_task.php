<?php
    session_start();

    $user = $_SESSION['USER'];
    $supervisor_code = $_SESSION['USER_CODE'];

    $task_code = $_POST["task_code"];

    include '../includes/connection.php';
        
    $query = "UPDATE infoapp_tasks set task_report = 0 WHERE task_code LIKE $task_code";
    echo $query;
    $result = mysqli_query($conn, $query);
    //echo $result;
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
				<span class="text-center"><h3>Devoluci&oacute;n de Actividades</h3></span>
					<table class="table table-bordered">
						<tr>
							<td></td>
							<td  class="my_td"><img src="../imgs/edit_task.png"></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>Actividad devuelta con &eacute;xito por <?php echo $_SESSION['NAME'];?></td>
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
		$_SESSION['RETURN_TASK_ERROR'] = '';
	?>
</body>
</html>