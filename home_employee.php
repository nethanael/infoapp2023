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
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/test_borders.css">
		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container my_cont">

		<?php include 'includes/header.php'; ?>
		<?php include 'includes/navBar.php'; ?>
		
		<div class = "row justify-content-center my_row">
			<div class = "col-6 my_col">
				<!-- (row_!Centro!) -->
					<table class="table">
                        <h1>Employee</h1>
					</table>
			</div>
		</div>

		<div class = "row justify-content-center my_row">
			<div class="col-6 justify-content-center my_col bg-secondary text-white">
				<p class="text-center font-weight-light">Este es el men&uacute; principal del sistema creado para 
				la jefatura directa de un grupo de trabajo determinado. Permite la creaci&oacute;n, edici&oacute;n y
				asignaci&oacute;n de actividades. Tambi&eacute;n permite visualizar las cargar de trabajo y automatizar
				la creaci&oacute;n del informe mensual de un departamento.</p>
			
			</div>
		</div>

		<?php include 'includes/footer.php'; ?>

	</div>
</body>
</html>