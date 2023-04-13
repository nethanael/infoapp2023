<?php
	$ts = gmdate("D, d M Y H:i:s") . " GMT";
	header("Expires: $ts");
	header("Last-Modified: $ts");
	header("Pragma: no-cache");
	header("Cache-Control: no-cache, must-revalidate");
	
	session_start();

	if ($_SESSION['LOGIN_INFOAPP'] == FALSE ){header("Location: index.php");}

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

		<div class="row justify-content-center my_row">

            <div class="col my_col"></div>

            <div class="col my_col">
                <!-- (row_!Centro!) -->

                <div class="card" style="width: 18rem;">
                    <img src="imgs/logo_1.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Este es un sistema automatizado para la confecci&oacute;n de 
            informes mensuales y medici&oacute;n del desempe&ntilde;o.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Desarrollado por: <b>Ing. Pablo Hidalgo Acu&ntildea</b></li>
                    </ul>
                </div>
			</div>

            <div class="col my_td"></div>

			</div>

			<div class = "row justify-content-center my_row">
				<div class = "col my_td"><a class="btn btn-info" href="index.php">Volver</a></div>
			</div>

		<?php include 'includes/footer.php'; ?>

	</div>
</body>
</html>