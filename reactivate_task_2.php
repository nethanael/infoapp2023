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
    $task_code = $_GET['data']; 
    $today = date("Y-m-d H:i");

    $DB_data = db_select_simple_fetch("infoapp_tasks", "*", "task_code=$task_code AND infoapp_tasks.dept_code=$dept_code");
    
    $dept_code= $DB_data["dept_code"];
    $user_code_1 = $DB_data["user_code_1"];
    $user_code_2 = $DB_data["user_code_2"];
    $user_code_3= $DB_data["user_code_3"];
    $task_type_code = $DB_data["task_type_code"];
    $perf_code_1 = $DB_data["perf_code_1"];
    $perf_code_2 = $DB_data["perf_code_2"];
    $perf_code_3 = $DB_data["perf_code_3"];
    $task_title = $DB_data["task_title"];
    $task_description = $DB_data["task_description"];
    $task_status = $DB_data["task_status"];
    $task_report = $DB_data["task_report"];
    $progress_1 = $DB_data["progress_1"];
    $progress_2 = $DB_data["progress_2"];
    $progress_3 = $DB_data["progress_3"];
    $progress_4 = $DB_data["progress_4"];

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
                <form name="" method="post" action="scripts/reactivate_task.php"> 
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="my_td" colspan="2">Detalles de actividad:</th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <span class="text-danger">
                                        <?php echo $_SESSION['REACTIVATE_TASK_ERROR']; ?>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tr>
                            <td>C&oacute;digo de Actividad:</td>  
                                <td><input name="task_code" id="task_code" size="1" value="<?php echo $task_code;?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Tipo de Actividad:</td> 
                            <td>
                            <?php 
                                $DB_data = db_select_simple_fetch("infoapp_task_type", "task_type_title", "task_type_code=$task_type_code");
                                $task_type_title = ($DB_data["task_type_title"]) ? ($DB_data["task_type_title"]) : ("error");
                                echo "<span class='badge badge-secondary'>$task_type_title</span>"
                            ?></td>
                        </tr>
                        <tr>
                            <td>Metas de Desempeño:</td>  
                            <?php 

                            $DB_data = db_select_simple_fetch("infoapp_performance_goals", "perf_name", "perf_code=$perf_code_1");
                            $perf_name_A = ($DB_data["perf_name"]) ? ($DB_data["perf_name"]) : ("Sin asignar");

                            $DB_data = db_select_simple_fetch("infoapp_performance_goals", "perf_name", "perf_code=$perf_code_2");
                            $perf_name_B = ($DB_data["perf_name"]) ? ($DB_data["perf_name"]) : ("Sin asignar");

                            $DB_data = db_select_simple_fetch("infoapp_performance_goals", "perf_name", "perf_code=$perf_code_3");
                            $perf_name_C = ($DB_data["perf_name"]) ? ($DB_data["perf_name"]) : ("Sin asignar");

                            ?> 
                            <td><?php echo "<span class='badge badge-primary'>A: $perf_name_A</span> 
                                        <span class='badge badge-primary'>B: $perf_name_B</span> 
                                        <span class='badge badge-primary'>C: $perf_name_C</span> ";
                            ?></td>
                        </tr>
                        <tr>
                            <td>T&iacute;tulo:</td>  
                            <td><?php echo $task_title;?></td>
                        </tr>
                        <tr>
                            <td>Descripci&oacute;n de actividad:</td>  
                            <td><?php echo $task_description;?></td>
                        </tr>
                        <tr>
                            <td>Atiende:</td>  
                            <?php 

                            $DB_data = db_select_simple_fetch("infoapp_users", "last_name", "user_code=$user_code_1");
                            $last_name_A = ($DB_data["last_name"]) ? ($DB_data["last_name"]) : ("Sin asignar");

                            $DB_data = db_select_simple_fetch("infoapp_users", "last_name", "user_code=$user_code_2");
                            $last_name_B = ($DB_data["last_name"]) ? ($DB_data["last_name"]) : ("Sin asignar");

                            $DB_data = db_select_simple_fetch("infoapp_users", "last_name", "user_code=$user_code_3");
                            $last_name_C = ($DB_data["last_name"]) ? ($DB_data["last_name"]) : ("Sin asignar");

                            ?> 
                            <td><?php echo "<span class='badge badge-info'>A: $last_name_A</span> 
                                        <span class='badge badge-info'>B: $last_name_B</span> 
                                        <span class='badge badge-info'>C: $last_name_C</span> ";
                            ?></td>
                        </tr>
                        <tr>
                            <td>Marcado como:</td>  
                            <td>
                            <?php 
                                $DB_data = db_select_simple_fetch("infoapp_task_report", "report_description", "report_code=$task_report");
                                $task_report_description = ($DB_data["report_description"]) ? ($DB_data["report_description"]) : ("error");
                                echo "<span class='badge badge-success'>$task_report_description</span>"
                            ?></td>
                        </tr>
                        <tr>
                            <td>Cambiar a:</td> 
                            <td>
                                <p><em>Se cambiar&aacute; el estado de <span class='badge badge-success'>Listo</span> 
                                a <span class='badge badge-warning'>pendiente</span> para que el personal asignado 
                                vuelva trabajar en esta actividad en este nuevo mes.</p></em>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ¡Advertencia!
                            </td>
                            <td>
                                Los siguientes avances ser&aacute;n eliminados:
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 1:</td>  
                            <td>
                                <?php echo $progress_1;?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 2:</td>  
                            <td>
                                <?php echo $progress_2;?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 3:</td>  
                            <td>
                                <?php echo $progress_3;?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 4:</td>  
                            <td>
                                <?php echo $progress_4;?>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td>Fecha Solicitud:</td>
                            <td>
                                <input name="creation_date" type="text" id="creation_date" size="15"
                                maxlength="100" value="<?php echo $today;?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Nueva Fecha de Entrega:</td>
                            <td>
                                <input name="req_date" type="datetime-local" id="req_date" size="8" maxlength="100">
                            </td>
                        </tr>
                        <tr>
                                <td class="my_td" colspan="2"><input class="btn btn-warning" type="submit" name="Submit" value="Reactivar"></td>
                                <td></td>
                        </tr>
                        <tr>
                            <td class="my_td" colspan="2">
                                <a class="btn btn-info" href="index.php">Volver</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <?php
            mysqli_free_result($result); 
            include 'includes/footer.php'; 
        ?>

	</div>
</body>
</html>