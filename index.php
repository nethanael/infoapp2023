<?php
	$ts = gmdate("D, d M Y H:i:s") . " GMT";
	header("Expires: $ts");
	header("Last-Modified: $ts");
	header("Pragma: no-cache");
	header("Cache-Control: no-cache, must-revalidate");
	
	session_start();
	
	if ($_SESSION['LOGIN_INFOAPP'] == TRUE)
		{
            include('includes/roles_redirection.php');
		}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/test_borders.css">
		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container mi_cont">

		<div class = "row justify-content-center mi_row">
			<div class = "col-6 mi_col">
					<!--(row_!Titulo!)-->
					<p class="text-center"><img src="imgs/logo_1.png"></p>
			</div>
		</div>

		<div class = "row justify-content-center mi_row">
			<div class = "col-6 mi_col">
				<!--(row_!nav!)-->
			</div>
		</div>
		
		<div class = "row justify-content-center mi_row">
			<div class = "col-6 justify-content-center mi_col">
				<!--(row_!Centro!)-->
				<form name="form1" method="post" action="scripts/user_check.php">
					<table class="table">
						<tr>
							<th colspan="2"><p class="text-center h5">Ingrese sus datos:</p></th>
						</tr>
						<tr>
							<td><p class="text-right">Usuario:</p></td>
							<td><input name="user" type="text" id="user" value="<?php echo $_SESSION['USER_TEMP']; ?>" size="10" maxlength="20"></td>
						</tr>
						<tr>
							<td><p class="text-right">Contrase&ntilde;a:</p></td>
							<td><input name="pass" type="password" id="pass" size="10" maxlength="20"></td>
						</tr>      
						<tr>
							<td></td>
							<td><input type="submit" name="Submit" value="Ingresar"></td>
						</tr>
						<tr>
							<th colspan="2"><p class="text-center font-italic text-danger"><?php echo $_SESSION['LOGIN_ERROR']; ?></p></th>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class = "row justify-content-center mi_row">
			<div class="col-6 justify-content-center mi_col bg-secondary text-white">
				<p class="text-center font-weight-light">Utilizar el sistema responsablemente. No se permite 
				el prestamo de usuarios y contrase&ntilde;as. Consultas y sugerencias a: phidalgoa@ice.go.cr </p>
			</div>
		</div>

        <?php include_once('includes/footer.php');?>

	</div>
</body>
</html>