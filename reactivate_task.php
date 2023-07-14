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
        //if ($_SESSION['ROLE_NAME'] == "supervisor") header("Location: home_supervisor.php");
        if ($_SESSION['ROLE_NAME'] == "employee") header("Location: home_employee.php");
        }

    include 'includes/functions.php';
    
    $dept_code = $_SESSION['DEPT_CODE'];
    $month = monthFix();
    $year = yearFix($month);

    $fields="infoapp_tasks.task_code, infoapp_tasks.task_title,
     infoapp_tasks.task_description, infoapp_tasks.task_status, infoapp_tasks.task_report, 
     infoapp_tasks.month, infoapp_tasks.year, infoapp_tasks.req_date, infoapp_tasks.delivery_date";
    $table1="infoapp_tasks";
    $whereClause="infoapp_tasks.task_status=0 AND infoapp_tasks.task_report=1 
                AND infoapp_tasks.month=$month AND infoapp_tasks.year=$year
                AND infoapp_tasks.dept_code=$dept_code";

    $result = db_select_simple($table1, $fields, $whereClause);
    
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
			<div class = "table-responsive">
				<!-- (row_!Centro!) -->
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="my_td" colspan="9">Actividades Reactivables:</th>
                        </tr>
                        <tr>
                        <td colspan="9">
                                <span class="">
                                    Puede hacer clic en el c&oacute;digo de la actividad para reactivarla, esto permite que el personal asignado pueda hacer nuevos avances.
                                </span>
                            </td>
                        </tr>
                        <tr>
                                <td colspan="3">
                                    <span class="lead text-danger">
                                        <?php echo $_SESSION[''];?>
                                    </span>
                                </td>
                        </tr>
                    </thead>
                    <tr>
                        <th><small>C&oacute;digo Actividad:</small></th>
                        <th><small>T&iacute;tulo:</small></th>
                        <th><small>Descripci&oacute;n:</small></th>
                        <th><small>Estado:</small></th>
                        <th><small>Informe:</small></th>
                        <th><small>Mes:</small></th>		
                        <th><small>Ano:</small></th>
                        <th><small>Fecha Solicitud:</small></th>	
                        <th><small>Fecha Entrega:</small></th>
                    </tr>
                        <?php                                                   //saca todos los valores de la base de datos y
                                                                                // los hace filas
                            while ($line = $result->fetch_assoc()) 
                                {
                                    echo "<tr>";
                                    foreach ($line as $col_name => $col_value)
                                        {
                                            switch ($col_name) {
                                                case "task_code":
                                                    echo "<td class='my_td'><a class='btn btn-primary' href=reactivate_task_2.php?data=",$col_value,">$col_value</a></td>";
                                                break;
                                                case "task_status":
                                                    echo "<td><small class='badge badge-success'>";
                                                    echo ($task_status == 0) ? "Abierta" : "Cerrada";
                                                    echo "</small></td>";
                                                break;
                                                case "task_report":
                                                    echo "<td><small class='badge badge-secondary'>";
                                                        echo ($task_report == 0) ? "Listo" : "Pendiente";
                                                    echo "</small></td>";
                                                    break;
                                                default:
                                                    echo "<td><small>$col_value</small></td>"; 
                                            }
                                        }
                                    echo "</tr>";
                                }
                        ?>
                </table>
            </div>
            <a class="btn btn-info" href="index.php">Volver</a>
		</div>

        <?php
            mysqli_free_result($result); 
            include 'includes/footer.php'; 
        ?>

	</div>
</body>
</html>