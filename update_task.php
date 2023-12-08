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
    $task_title = $DB_data["task_title"];
    $task_description = $DB_data["task_description"];

    $user_code_1 = $DB_data["user_code_1"];
    $user_code_2 = $DB_data["user_code_2"];
    $user_code_3 = $DB_data["user_code_3"];

    $task_status = $DB_data["task_status"];
    $task_report = $DB_data["task_report"];

    $progress_1 = $DB_data["progress_1"];
    $progress_2 = $DB_data["progress_2"];
    $progress_3 = $DB_data["progress_3"];
    $progress_4 = $DB_data["progress_4"];

    $perf_code_1 = $DB_data["perf_code_1"];
    $perf_code_2 = $DB_data["perf_code_2"];
    $perf_code_3 = $DB_data["perf_code_3"];

    $creation_date = $DB_data["creation_date"];
    $req_date = $DB_data["req_date"];
    
	mysqli_free_result($result);   
    
    $right_now = date("Y-m-d H:i");
    $dateTimestamp1 = strtotime($right_now);
    $dateTimestamp2 = strtotime($req_date);



    // aca hay que hacer otra logica y agregar TODAS LAS METAS FUCK!

    if ($dateTimestamp1>$dateTimestamp2){
        $performance = 90;
    }
    if ($dateTimestamp1==$dateTimestamp2){
        $performance = 100;
    }
    if ($dateTimestamp1<$dateTimestamp2){
        $performance = 110;
    }
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
          
        <div class = "row justify-content-center my_row">
			<div class = "col-6 my_col">
				<!-- (row_!Centro!) -->
                <form name="" method="post" action="scripts/update_task.php"> 
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Detalles de actividad:</th>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo $_SESSION['UPDATE_TASK_ERROR'] = '';?></th>
                            </tr>
                        </thead>
                        <tr>
                            <td>Codigo de Actividad:</td>  
                            <td>
                                <input name="task_code" size="1" id="task_code" value="<?php echo $task_code;?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Tipo de Actividad:</td>  
                            <td><?php echo $task_type_title;?></td>
                        </tr>
                        <tr>
                            <td>Titulo:</td>  
                            <td><?php echo $task_title;?></td>
                        </tr>
                        <tr>
                            <td>Descripcion de actividad:</td>  
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
                            <td>Estado de actividad :</td>  
                            <?php 
                                $DB_data = db_select_simple_fetch("infoapp_task_status", "status_description", "status_code=$task_status");
                                $status = ($DB_data["status_description"]) ? ($DB_data["status_description"]) : ("otro estado");
                            ?>
                            <td><?php echo "<span class='badge badge-warning'>$status</span>";?></td>
                        </tr>
                        <tr>
                            <td>Cambiar estado a:</td> 
                            <td>    
                                <select id="task_status" name="task_status">
                                    <option value=0>Abierta</option>
                                    <option value=1>Cerrada</option>
                                </select> 
                                <p><em>Si desea que la actividad sea reactivada automaticamente el pr&oacuteximo mes mantenga abierta, si la actividad no se har&aacute de nuevo marque cerrada.</p></em>
                            </td>
                        </tr>

                        <tr>
                            <td>Listo para informe? </td> 
                            <?php 
                                $DB_data = db_select_simple_fetch("infoapp_task_report", "report_description", "report_code=$task_report");
                                $report = ($DB_data["report_description"]) ? ($DB_data["report_description"]) : ("otro estado");
                            ?>
                            <td><?php echo "<span class='badge badge-warning'>$report</span>";?></td>
                        </tr>
                        <tr>
                            <td>Cambiar estado a:</td> 
                            <td>    
                                <select id="task_report" name="task_report">
                                    <option value=0>Pendiente</option>
                                    <option value=1>Listo</option>
                                </select> 
                                <p><em>Al cambiar a "Listo" la actividad está lista para aparecer en el informe mensual y los responsables no podr&aacuten actualizar m&aacutes sus avances. Para esto deber&aacute solicitar su reapertura.</p></em>
                            </td>
                        </tr>

                        <tr>
                        <tr>
                            <td colspan="2"><p class="text-info">Tamaño máximo por avance 450 caractéres</p></td>
                        </tr>
                        <tr>
                            <td>Avance 1:</td>  
                            <td>
                                <textarea name="progress_1" id="progress_1" value="" rows="5" cols="35" maxlength="450"><?php echo $progress_1;?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 2:</td>  
                            <td>
                                <textarea name="progress_2" id="progress_2" value="" rows="5" cols="35" maxlength="450"><?php echo $progress_2;?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 3:</td>  
                            <td>
                                <textarea name="progress_3" id="progress_3" value="" rows="5" cols="35" maxlength="450"><?php echo $progress_3;?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Avance 4:</td>  
                            <td>
                                <textarea name="progress_4" id="progress_4" value="" rows="5" cols="35" maxlength="450"><?php echo $progress_4;?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha Solicitud:</td>  
                            <td><?php echo $creation_date;?></td>
                        </tr>
                        <tr>
                            <td>Fecha L&iacutemite:</td>  
                            <td><?php echo $req_date;?></td>
                        </tr>
                        <tr>
                            <td>Fecha de Entrega:</td>  
                            <td><input type="text" value="<?php echo $right_now;?>" id="right_now" name="right_now" size="15" readonly></td>
                        </tr>
                        <tr>
                            <td>Desempe&ntildeo si entrega en este momento:</td>  
                            <td><input type="text" value="<?php echo $performance;?>" id="performance" name="performance" size="1" readonly></td>
                        </tr>
                        <tr>
                                <td class="my_td" colspan="2"><input type="submit" name="Submit" value="Actualizar"></td>
                                <td></td>
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