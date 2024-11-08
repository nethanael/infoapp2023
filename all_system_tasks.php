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
    include 'includes/functions.php';

    $tasks_table="infoapp_tasks";
    $departments_table="infoapp_departments";
    $task_type_table="infoapp_task_type";
    $users_table="infoapp_users";
    $perf_goal_table="infoapp_performance_goals";

    $fields="infoapp_tasks.task_code, infoapp_tasks.task_title, infoapp_tasks.task_description, infoapp_users.last_name, infoapp_departments.dept_name, infoapp_task_type.task_type_title";

    $ONclause1="infoapp_tasks.dept_code=infoapp_departments.dept_code";
    $ONclause2="infoapp_tasks.task_type_code=infoapp_task_type.task_type_code";
    $ONclause3="infoapp_tasks.user_code_1=infoapp_users.user_code";

    $whereClause="infoapp_tasks.dept_code='$dept_code'";

    $result = db_select_3_inner_query($tasks_table, $departments_table, $task_type_table, $users_table, $fields, $ONclause1, $ONclause2, $ONclause3, $whereClause);

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/test_borders.css">

        <!-- jQuery -->
        <script src="includes/jquery-3.7.1.min.js"></script>
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <!-- DataTables JS -->
        <script src="includes/jquery.dataTables.min.js"></script>

		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container my_cont">

	<?php include 'includes/header.php'; ?>
	<?php include 'includes/navBar.php'; ?>
          
		<div class = "row justify-content-center my_row">
			<div class = "table-responsive">
				<!-- (row_!Centro!) -->
            
                <div class = "row justify-content-center my_row">
			    <div class = "col-12 my_col">
					<!--(row_!Titulo!)-->
					<p class="text-center">Actividades Totales Departamento:</p>
			    </div>
		    </div>

                <table id="myTable" class="table table-sm table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th><small>Codigo Actividad:</small></th>
                            <th><small>Titulo:</small></th>
                            <th><small>Descripcion:</small></th>
                            <th><small>Responsable:</small></th>
                            <th><small>Departamento:</small></th>
                            <th><small>Tipo de Actividad:</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                                                   //saca todos los valores de la base de datos y
                                                                                // los hace filas
                            while ($line =  $result->fetch_assoc()) 
                                {
                                    echo "<tr>";
                                    foreach ($line as $col_name => $col_value)
                                        {
                                            if ($col_name == 'task_code'){
                                                echo "<td class='my_td'><a class='btn btn-primary' href=task_detail.php?data=",$col_value,">$col_value</a></td>";
                                            }
                                            if ($col_name != 'task_code'){
                                                echo "<td><small>$col_value</small></td>";
                                            }
                                        }
                                    echo "</tr>";
                                }
                        ?>
                    </tbody>      
                </table>
            </div>
        <a class="btn btn-info" href="index.php">Volver</a>
		</div>

        <?php 
             mysqli_free_result($result);
            include 'includes/footer.php'; 
        ?>

	</div>

    <script>
        $('#myTable').DataTable({
            paging: true,
            searching: true,
            ordering:false,
            pageLength: 20, // Número de registros por página
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/Spanish.json' // Para traducir al español
            }
        });

        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

</body>
</html>