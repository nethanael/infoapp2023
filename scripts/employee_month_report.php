<?php

    $ts = gmdate("D, d M Y H:i:s") . " GMT";
    header("Expires: $ts");
    header("Last-Modified: $ts");
    header("Pragma: no-cache");
    header("Cache-Control: no-cache, must-revalidate");

    session_start();

    $user = $_SESSION['USER'];
    $user_code = $_SESSION['USER_CODE'];
    $dept_code = $_SESSION['DEPT_CODE'];
    $name = $_SESSION['NAME'];
    $last_name = $_SESSION['LAST_NAME'];

    $month = date("m");
    $year = date("y");

    include '../includes/functions.php';

//Report DB query

    $tasks_table="infoapp_tasks";
    $task_type_table="infoapp_task_type";

    $fields="infoapp_tasks.task_title, infoapp_tasks.task_description, infoapp_task_type.task_type_title, 
    infoapp_tasks.performance, infoapp_tasks.progress_1, infoapp_tasks.progress_2, infoapp_tasks.progress_3, 
    infoapp_tasks.progress_4";

    $ONclause1="infoapp_tasks.task_type_code=infoapp_task_type.task_type_code";
    $whereClause="(user_code_1 LIKE $user_code OR user_code_2 LIKE $user_code or user_code_3 LIKE $user_code) AND month LIKE $month AND year LIKE $year AND infoapp_tasks.task_report like 1";
    $orderBy="infoapp_tasks.task_type_code";

    $result = db_select_1_inner_query_orderby($tasks_table, $task_type_table, $fields, $ONclause1, $whereClause, $orderBy);

// Department name DB query

    $table="infoapp_departments";
    $field="dept_name";
    $whereClause="dept_code LIKE $dept_code";

    $result2=db_select_simple_fetch($table, $field, $whereClause);
 
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/test_borders.css">
		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container my_cont">

    <?php include '../includes/header.php'; ?>

    	<div class = "row justify-content-center my_row">
			<div class = "col-10 my_col">
				<!-- (row_!Centro!) -->
                <div id="exportContent">
                <table table border="1" class="table-responsive my_table">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="4"><h1><?php echo $result2[dept_name]?></h1></th>
                        </tr>
                        <tr>
                            <td colspan="4"><h2>Informe Mensual de actividades</h2></td>
                        </tr>
                        <tr>
                            <td colspan="4">Correspondiente al mes de 
                            <?php                                  
                                    echo monthName($mes)."del 20".$year;                         //funcion de mes
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">Funcionario
                                <?php echo $name. ' '; 
                                echo $last_name;?>
                            </td>
                        </tr>
                    </thead>
                    <?php
                        while ($line =  $result->fetch_assoc()) 
                                    {
                                        echo "<tr>";
                                            echo "<th>T&iacutetulo:</th>";
                                            echo "<th>Descripci&oacuten:</th>";
                                            echo "<th>Tipo de Actividad:</th>";
                                            echo "<th>Desempe&ntildeo:</th>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        foreach ($line as $col_name => $col_value)
                                        {
                                            if ($col_name != 'progress_1' && $col_name != 'progress_2' && $col_name != 'progress_3' && $col_name != 'progress_4' )
                                                {
                                                    echo "<td><small>$col_value</small></td>";
                                                } elseif($col_value) {
                                                        echo "<tr><td colspan='4'><small>$col_value</small></td></tr>";
                                                    }
                                        }
                                    }
                    ?>
                </table>
                </div>
			</div>
    	</div>

        <div class = "row justify-content-center my_row">
            <div class = "col-4 my_td">
                <button class="btn btn-primary" onclick="Export2Doc('exportContent', `<?php echo $name." ".$last_name; ?>`);">Exportar Word</button>
            </div>
        </div>

        <div class = "row justify-content-center my_row">
			<div class = "col-4 my_td">
                <a class="btn btn-info" href="../index.php">Volver</a>
            </div>
		</div>
        
        <?php include '../includes/footer.php'; ?>

	</div>
</body>
</html>
<script src="export_report_word.js"></script> 