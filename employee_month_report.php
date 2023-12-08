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
	$user_code = $_SESSION['USER_CODE'];
        
    $month = date("m");
    $year = date("y");

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
                <form name="" method="post" action="scripts/employee_month_report.php"> 
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="my_td" colspan="2">Crear informe Mensual:</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="my_td" colspan="2">
                                <img src="imgs/crear_info.png"><br>
                                    <span class="text-danger">
                                        <?php echo $_SESSION['INFO_ERROR'];?>
                                    </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Importante:</td>
                            <td>      
                                Para generar el informe el sistema tomar&aacute; todas las actividades asignadas 
                                y que usted o sus compa&ntilde;eros marcaron como "Listas" para informe.
                            </td>
                        </tr>
                        <tr>
                            <td>Mes:</td>
                            <td>      
								<?php                                  
                                    echo monthName($month);                         //funcion de mes
								?> 
                            </td>
                        </tr>
                        <tr>
                            <td>Año:</td>
                            <td>    
                            <?php echo $ano;?>   
                            </td>
                        </tr>
                        <tr>
                                <td class="my_td" colspan="2"><input class="btn btn-warning" type="submit" name="Submit" value="Crear"></td>
                                <td class="my_td"><?php echo $_SESSION['ERROR'];?></td>
                        </tr>
                        <tr>
                            <td class="my_td" colspan="2"><a class="btn btn-info" href="index.php">Volver</a></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        
        <?php include 'includes/footer.php'; ?>

	</div>
</body>
</html>