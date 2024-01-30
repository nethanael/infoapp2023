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
    $task_report = $DB_data["task_report"];
    
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
                <form name="" method="post" action="scripts/return_task.php"> 
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="my_td" colspan="4">Detalles de actividad a devolver: </th>
                            </tr>
                            <tr>
                                <th colspan="4"> <span class="text-danger"><?php echo $_SESSION['RETURN_TASK_ERROR']; ?></span></th>
                            </tr>
                           
                        </thead>
                        <tr>
                            <td>C&oacute;digo de Actividad:</td>
                            <td> 
                                <input name="task_code" id="task_code" size="1" value="<?php echo $task_code;?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>T&iacute;tulo:</td>
                            <td><?php echo $task_title;?></td>
                        </tr>
                        <tr>
                            <td>Descripci&oacute;n:</td>  
                            <td><?php echo $task_description;?></td>
                        </tr>
                        <tr>
                            <td>Tipo de Actividad:</td>  
                            <td><?php 
                                    echo "<span class='badge badge-success'>$task_type_title</span>";
                            ?></td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                A continuaci&oacuten los avances registrados por los colaboradores:
                            </th>
                        </tr>
                        <tr>
                            <td>Avance 1:</td>  
                            <td><?php echo $progress_1;?></td>
                        </tr>
                        <tr>
                            <td>Avance 2:</td>  
                            <td><?php echo $progress_2;?></td>
                        </tr>
                        <tr>
                            <td>Avance 3:</td>  
                            <td><?php echo $progress_3;?></td>
                        </tr>
                        <tr>
                            <td>Avance 4:</td>  
                            <td><?php echo $progress_4;?></td>
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
                            <td>Fecha Entrega: (a&ntildeo-mes-d&iacutea T hora:min)</td>
                            <td>
                                <?php echo $req_date;?>
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
                            <td>Cambiar estado:</td> 
                            <td>Pendiente<br>
                                <p><em>Al cambiar de estado a "Pendiente" el personal asignado vuelve a tener pendiente el trabajo y puede hacer nuevas actualizaciones o corregir las existentes.</p></em>
                            </td>
                        </tr>
                        <tr>
                                <td class="my_td" colspan="2"><input class="btn btn-warning" type="submit" name="Submit" value="Devolver"></td>
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