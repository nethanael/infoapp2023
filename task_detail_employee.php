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

    $task_code = $_GET['data']; 
    $dept_code = $_SESSION['DEPT_CODE'];
    include 'includes/functions.php';

    //------------------First query-------------------------------

    $tasks_table="infoapp_tasks";
    $departments_table="infoapp_departments";
    $task_type_table="infoapp_task_type";
    $users_table="infoapp_users";
    $perf_goal_table="infoapp_performance_goals";

    $fields="infoapp_tasks.task_code, infoapp_tasks.task_title, infoapp_tasks.task_description, 
    infoapp_users.name, infoapp_users.last_name, infoapp_departments.dept_name, 
    infoapp_task_type.task_type_title, infoapp_tasks.creation_date, infoapp_tasks.req_date,
    infoapp_tasks.delivery_date, infoapp_tasks.task_status, infoapp_tasks.performance,
    infoapp_tasks.progress_1, infoapp_tasks.progress_2, infoapp_tasks.progress_3, infoapp_tasks.progress_4";

    $ONclause1="infoapp_tasks.dept_code=infoapp_departments.dept_code";
    $ONclause2="infoapp_tasks.task_type_code=infoapp_task_type.task_type_code";
    $ONclause3="infoapp_tasks.user_code_1=infoapp_users.user_code";

    $whereClause="infoapp_tasks.task_code='$task_code' AND infoapp_tasks.dept_code=$dept_code";

    $result = db_select_3_inner_query($tasks_table, $departments_table, $task_type_table, $users_table, $fields, $ONclause1, $ONclause2, $ONclause3, $whereClause);
    $data = mysqli_fetch_assoc($result);
    
	$task_code = $data["task_code"];
    $task_title = $data["task_title"];
    $task_description = $data['task_description'];
    $last_name = $data['last_name'];
    $name = $data['name'];
    $dept_name = $data['dept_name'];
    $task_type_title = $data['task_type_title'];
    $creation_date = $data['creation_date'];
    $req_date = $data['req_date'];
    $delivery_date = $data['delivery_date'];
    $task_status = $data['task_status'];
    $progress_1 = $data['progress_1'];
    $progress_2 = $data['progress_2'];
    $progress_3 = $data['progress_3'];
    $progress_4 = $data['progress_4'];
    $performance = $data['performance'];
    //$ = $data[''];

    mysqli_free_result($result);

    //----------------------------Second Query-------------------

    $fields="infoapp_users.name, infoapp_users.last_name";

    $ONclause1="infoapp_tasks.user_code_2=infoapp_users.user_code";

    $result = db_select_1_inner_query($tasks_table, $users_table, $fields, $ONclause1, $whereClause);
    $data = mysqli_fetch_assoc($result);

    $name_2 = $data['name'];
    $last_name_2 = $data['last_name'];

    mysqli_free_result($result);

    //---------------------------Third Query----------------------

    $ONclause1="infoapp_tasks.user_code_3=infoapp_users.user_code";

    $result = db_select_1_inner_query($tasks_table, $users_table, $fields, $ONclause1, $whereClause);
    $data = mysqli_fetch_assoc($result);

    $name_3 = $data['name'];
    $last_name_3 = $data['last_name'];

    mysqli_free_result($result);

    //---------------------------Fourth Query----------------------

    $fields="infoapp_performance_goals.perf_name";
    
    $ONclause1="infoapp_tasks.perf_code_1=infoapp_performance_goals.perf_code";

    $result = db_select_1_inner_query($tasks_table, $perf_goal_table, $fields, $ONclause1, $whereClause);
    $data = mysqli_fetch_assoc($result);
    
    $performance_goal_1 = $data['perf_name'];

    mysqli_free_result($result);

    //---------------------------Fifth Query----------------------

    $ONclause1="infoapp_tasks.perf_code_2=infoapp_performance_goals.perf_code";

    $result = db_select_1_inner_query($tasks_table, $perf_goal_table, $fields, $ONclause1, $whereClause);
    $data = mysqli_fetch_assoc($result);
    
    $performance_goal_2 = $data['perf_name'];

    mysqli_free_result($result);

    //---------------------------Sixth Query----------------------

    $ONclause1="infoapp_tasks.perf_code_3=infoapp_performance_goals.perf_code";

    $result = db_select_1_inner_query($tasks_table, $perf_goal_table, $fields, $ONclause1, $whereClause);
    $data = mysqli_fetch_assoc($result);
    
    $performance_goal_3 = $data['perf_name'];

    mysqli_free_result($result);
    
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
                <form name="" method="post" action="scripts/reabrir_act.php"> 
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="my_td" colspan="2">Detalles de actividad:</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>C&oacutedigo de Actividad:</td>  
                                <td><input name="task_code" id="task_code" size="1" value="<?php echo $task_code;?>"readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>T&iacutetulo de Actividad:</td>  
                            <td><?php echo $task_title;?></td>
                        </tr>
                        <tr>
                            <td>Descripci&oacuten:</td>  
                                <td><?php echo $task_description;?></td>
                            </tr>
                        <tr>
                            <td>Responsable:</td>  
                            <td><?php 
                                    echo "<span class='badge badge-info'>";
                                    echo ($last_name) ? $last_name : "Sin asignar";
                                    echo "</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Responsable 2:</td>  
                            <td><?php
                                    echo "<span class='badge badge-info'>"; 
                                    echo ($last_name_2) ? $last_name_2 : "Sin asignar";
                                    echo "</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Responsable 3:</td>  
                            <td><?php 
                                    echo "<span class='badge badge-info'>";
                                    echo ($last_name_3) ? $last_name_3 : "Sin asignar";
                                    echo "</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Departamento:</td>  
                            <td><?php echo $dept_name;?></td>
                        </tr>
                        <tr>
                            <td>Tipo de Actividad:</td>  
                            <td><?php echo "<span class='badge badge-secondary'>$task_type_title</span>";?></td>
                        </tr>
                        <tr>
                            <td>Fecha Creaci&oacuten:</td>  
                            <td><?php echo $creation_date;?></td>
                        </tr>
                        <tr>
                            <td>Fecha solicitada:</td>  
                            <td><?php echo $req_date;?></td>
                        </tr>
                        <tr>
                            <td>Fecha Entregada:</td>  
                            <td>
                                <?php 
                                    echo ($delivery_date != null) ? $delivery_date : "Sin entregar"; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Estado de la actividad:</td>  
                            <td>
                                <?php 
                                    echo ($task_status == 0) ? "<span class='badge badge-warning'>Abierta</span>" : "<span class='badge badge-success'>Cerrada</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 1:</td>  
                            <td>
                                <?php 
                                    echo ($progress_1 == null) ? "" : "<i>".$progress_1."</i>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 2:</td>  
                            <td>
                                <?php 
                                    echo ($progress_2 == null) ? "" : "<i>".$progress_2."</i>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 3:</td>  
                            <td>
                                <?php 
                                    echo ($progress_3 == null) ? "" : "<i>".$progress_3."</i>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 4:</td>  
                            <td>
                                <?php 
                                    echo ($progress_4 == null) ? "" : "<i>".$progress_4."</i>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Meta de Desempeño 1:</td>  
                            <td>
                                <?php 
                                    echo "<span class='badge badge-primary'>";
                                    echo ($performance_goal_1 == '') ? "No Asignada" : $performance_goal_1;
                                    echo "</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Meta de Desempeño 2:</td>  
                            <td>
                                <?php
                                    echo "<span class='badge badge-primary'>";
                                    echo ($performance_goal_2 == '') ? "No Asignada" : $performance_goal_2;
                                    echo "</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Meta de Desempeño 3:</td>  
                            <td>
                                <?php 
                                    echo "<span class='badge badge-primary'>";
                                    echo ($performance_goal_3 == '') ? "No Asignada" : $performance_goal_3;
                                    echo "</span>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Desempe&ntildeo:</td>  
                            <td>
                                <?php 
                                    echo ($performance == null) ? "Sin evaluar" : $performance;
                                ?>
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