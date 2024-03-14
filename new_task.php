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

    $dept_code = $_SESSION['DEPT_CODE'];
    date_default_timezone_set('CST');
    $today = date("Y-m-d H:i");

    include 'includes/functions.php';

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
                <form name="" method="post" action="scripts/new_task.php"> 
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="my_td" colspan="2">Crear Actividad:</th>
                            </tr>
                            <tr>
                                <td class="my_td" colspan="2">
                                    <span class="lead text-info">
                                    Aqu&iacute; podr&aacute; crear cualquier tipo de actividad y asignar personal que se encargue de la misma en el tiempo y prioridad que se crea necesario.
                                    </span>
                                </td>
                            </tr>
                        </thead>
                        <tr>
                            <td class="my_td" colspan="2">
                                <img src="imgs/new_task.png"><br>
                                <span class="text-danger">
                                    <?php echo $_SESSION['NEW_TASK_ERROR'];?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>*Tipo de Actividad:</td>
                            <td>
                                <?php  
                                    $query = "SELECT task_type_title FROM infoapp_task_type WHERE task_type_dept_code = $dept_code";
                                    $query2 = "SELECT task_type_code FROM infoapp_task_type WHERE task_type_dept_code = $dept_code"; 
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'task_type', '', 'some_var');
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td>*Meta de Desempeno 1:</td>
                            <td>
                                <?php  
                                    $query = "SELECT perf_name FROM infoapp_performance_goals WHERE perf_dept_code = $dept_code";
                                    $query2 = "SELECT perf_code FROM infoapp_performance_goals WHERE perf_dept_code = $dept_code";   
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'perf_goal_1', '', 'some_var');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>*Meta de Desempeno 2:</td>
                            <td>
                                <?php  
                                    $query = "SELECT perf_name FROM infoapp_performance_goals WHERE perf_dept_code = $dept_code";
                                    $query2 = "SELECT perf_code FROM infoapp_performance_goals WHERE perf_dept_code = $dept_code";   
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'perf_goal_2', '', 'some_var');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Meta de desempeno 3:</td>
                            <td>
                                <?php  
                                    $query = "SELECT perf_name FROM infoapp_performance_goals WHERE perf_dept_code = $dept_code";
                                    $query2 = "SELECT perf_code FROM infoapp_performance_goals WHERE perf_dept_code = $dept_code";     
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'perf_goal_3', '', 'some_var');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>*T&iacute;tulo de la Actividad:</td>
                            <td> 
                                <input 
                                    name="task_title" 
                                    type="text" 
                                    id="task_title" 
                                    size="" 
                                    maxlength="100"
                                    value="<?php echo $_SESSION['TASK_TITLE_TEMP']; ?>"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>*Descripci&oacute;n (Recordar mencionar qui&eacute;n solicita)</td>
                            <td>
                                <textarea name="task_description" rows="10" cols="30" maxlength="400"><?php echo $_SESSION['TASK_DESCRIPTION_TEMP']; ?></textarea>
                            <td>
                        </tr>
                        <tr>
                            <td>*Asignar a:</td>
                            <td>
                                <?php 
                                    $query = "SELECT last_name FROM infoapp_users WHERE dept_code = $dept_code"; 
                                    $query2 = "SELECT user_code FROM infoapp_users WHERE dept_code = $dept_code"; 
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'user_1', '', 'some_var');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Asignar a: (opcional)</td>
                            <td>
                                <?php 
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'user_2', '', 'some_var');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Asignar a: (opcional)</td>
                            <td>
                                <?php 
                                    echo dynamic_select_2(db_1D_query($query), db_1D_query($query2), 'user_3', '', 'some_var');
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha Solicitud:</td>
                            <td>
                                <input name="creation_date" type="" id="creation_date" size="15"
                                maxlength="100" value="<?php echo $today;?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>*Fecha de Entrega:</td>
                            <td>
                                <input name="req_date" type="datetime-local" id="req_date" size="8" maxlength="100">
                            </td>
                        </tr>
                        <tr>
                            <td class="my_td" colspan="2"><input class="btn btn-warning" type="submit" name="Submit" value="Crear"></td>
                        </tr>
                        <tr>
                            <td class="my_td" colspan="2">
                                <span class="text-danger">
                                    <?php echo $_SESSION['NEW_TASK_ERROR'];?>
                                </span>
                            </td>
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