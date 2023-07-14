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

    $dept_code=$_SESSION['DEPT_CODE'];
    $month = date("m");
    $year = date("y");
    include 'includes/functions.php';

    $tasks_table="infoapp_tasks";
    $departments_table="infoapp_departments";
    $fields="infoapp_tasks.task_code, infoapp_tasks.task_title, infoapp_tasks.task_description, infoapp_departments.dept_name";
    $ONclause1="infoapp_tasks.dept_code=infoapp_departments.dept_code";          
    $whereClause="infoapp_tasks.dept_code='$dept_code' AND infoapp_tasks.month ='$month' AND infoapp_tasks.year ='$year'";
    $result = db_select_1_inner_query($tasks_table, $departments_table, $fields, $ONclause1, $whereClause);

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
                            <th class="my_td" colspan="5">Actividades Editables:</th>
                        </tr>
                        <tr>
                            <td colspan="5"><small>Puede hacer clic en el c&oacute;digo de la actividad para editar detalles.</small></td>
                        </tr>
                    </thead>
                    <tr>
                        <th><small>C&oacute;digo Actividad:</small></th>
                        <th><small>T&iacute;tulo:</small></th>
                        <th><small>Descripci&oacute;n:</small></th>
                        <th><small>Departamento:</small></th>
                    </tr>
                        <?php                                                   //saca todos los valores de la base de datos y
                                                                                // los hace filas
                            while ($line = $result->fetch_assoc()) 
                                {
                                    echo "<tr>";
                                    foreach ($line as $col_name => $col_value)
                                        {
                                             if ($col_name== 'task_code'){
                                                 echo "<td class='my_td'><a class='btn btn-primary' href=edit_task_2.php?data=",$col_value,">$col_value</a></td>";
                                             }else{
                                                echo "<td><small>$col_value</small></td>";
                                             }
                                        }
                                    echo "</tr>";
                                }
                        ?> 
                        <tr><td><?php echo  $_SESSION[''];?></td></tr>   
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