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

    $task_code = $_GET['data']; 
    $dept_code = $_SESSION['DEPT_CODE'];

    $tasks_table="infoapp_tasks";
    $task_type_table="infoapp_task_type";

    $fields="*";
    $ONclause1="infoapp_tasks.task_type_code=infoapp_task_type.task_type_code";
    $whereClause="infoapp_tasks.task_code='$task_code' AND infoapp_tasks.dept_code='$dept_code'";
    $result = db_select_1_inner_query($tasks_table, $task_type_table, $fields, $ONclause1, $whereClause);
    $DB_data = mysqli_fetch_assoc($result);
    
	$task_type_title = $DB_data["task_type_title"];
    $supervisor_code = $DB_data["supervisor_code"];
    $task_title = $DB_data["task_title"];
    $task_description = $DB_data["task_description"];

    $user_code_1 = $DB_data["user_code_1"];
    $user_code_2 = $DB_data["user_code_2"];
    $user_code_3 = $DB_data["user_code_3"];

    $progress_1 = $DB_data["progress_1"];
    $progress_2 = $DB_data["progress_2"];
    $progress_3 = $DB_data["progress_3"];
    $progress_4 = $DB_data["progress_4"];

    $perf_code_1 = $DB_data["perf_code_1"];
    $perf_code_2 = $DB_data["perf_code_2"];
    $perf_code_3 = $DB_data["perf_code_3"];

    $req_date = $DB_data["req_date"];
    
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
                <form name="" method="post" action="scripts/edit_task.php"> 
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="my_td" colspan="4">Detalles de actividad: </th>
                            </tr>
                            <tr>
                                <th colspan="4"> <span class="text-danger"><?php echo $_SESSION['EDIT_TASK_ERROR']; ?></span></th>
                            </tr>
                           
                        </thead>
                        <tr>
                            <td>C&oacute;digo de Actividad:</td>  
                            <td><input name="task_code" id="task_code" size="1" value="<?php echo $task_code;?>"readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>T&iacute;tulo:</td>
                            <td><textarea name="task_title" id="task_title" value="" rows="5" cols="35"><?php echo $task_title;?></textarea></td>
                        </tr>
                        <tr>
                            <td>Descripci&oacute;n:</td>  
                            <td><textarea name="task_description" id="task_description" value="" rows="5" cols="35"><?php echo $task_description;?></textarea></td>
                        </tr>
                        <tr>
                            <td>Avance 1:</td>  
                            <td><textarea name="progress_1" id="progress_1" value="" rows="10" cols="35"><?php echo $progress_1;?></textarea></td>
                        </tr>
                        <tr>
                            <td>Avance 2:</td>  
                            <td><textarea name="progress_2" id="progress_2" value="" rows="10" cols="35"><?php echo $progress_2;?></textarea></td>
                        </tr>
                        <tr>
                            <td>Avance 3:</td>  
                            <td><textarea name="progress_3" id="progress_3" value="" rows="10" cols="35"><?php echo $progress_3;?></textarea></td>
                        </tr>
                        <tr>
                            <td>Avance 4:</td>  
                            <td><textarea name="progress_4" id="progress_4" value="" rows="10" cols="35"><?php echo $progress_4;?></textarea></td>
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
                            <td>Cambiar responsables:</td>  
                            <td>
                                <input type="checkbox" id="change_users" name="change_users" value="cambiar">
                                S&iacute;.
                            </td>
                        </tr>
                        <tr>
                            <td>*Asignar a:</td>
                            <td>
                                <?php 
                                    $query = "SELECT last_name FROM infoapp_users WHERE role_code = 3 AND dept_code = $dept_code"; 
                                    $query2 = "SELECT user_code FROM infoapp_users WHERE role_code = 3 AND dept_code = $dept_code"; 
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
                            <td>Tipo de Actividad:</td>  
                            <td><?php 
                                    echo "<span class='badge badge-success'>$task_type_title</span>";
                            ?></td>
                        </tr>
                        <tr>
                            <td>Cambiar tipo de actividad:</td>  
                            <td>
                                <input type="checkbox" id="change_task_type" name="change_task_type" value="cambiar">
                                S&iacute;.
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
                            <td>Cambiar metas de desempe&ntildeo:</td>  
                            <td>
                                <input type="checkbox" id="change_perf_goal" name="change_perf_goal" value="cambiar">
                                S&iacute;.
                            </td>
                        </tr>
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
                            <td>Fecha Entrega: (a&ntildeo-mes-d&iacutea T hora:min)</td>
                            <td>
                                <input name="req_date" id="req_date" size="15" value="<?php echo $req_date;?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Actividad creada por:</td>
                            <td>
                                <?php
                                    $DB_data = db_select_simple_fetch("infoapp_users", "last_name", "user_code=$supervisor_code");
                                    $last_name_D = $DB_data["last_name"];
                                    echo $last_name_D;
                                ?>
                            </td>
                        </tr>
                        <tr>
                                <td class="my_td" colspan="2"><input class="btn btn-warning" type="submit" name="Submit" value="Actualizar"></td>
                                <td></td>
                        </tr>
                        <tr>
                            <td class="my_td" colspan="2"><a class="btn btn-info" href="index.php">Volver</a></td>
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