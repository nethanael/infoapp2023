<?php

    $ts = gmdate("D, d M Y H:i:s") . " GMT";
    header("Expires: $ts");
    header("Last-Modified: $ts");
    header("Pragma: no-cache");
    header("Cache-Control: no-cache, must-revalidate");

    session_start();

    include '../includes/functions.php';

    $user = $_SESSION['USER'];
    $user_code = $_SESSION['USER_CODE'];
    $dept_code = $_SESSION['DEPT_CODE'];
    $name = $_SESSION['NAME'];
    $last_name = $_SESSION['LAST_NAME'];

    $month = date("m");
    $year = date("y");

    $addition = 0;
    $average = 0;

//Report DB query

$tasks_table="infoapp_tasks";
$performance_table="infoapp_performance_goals";

$fields="infoapp_performance_goals.perf_name, infoapp_tasks.task_title, infoapp_tasks.req_date, infoapp_tasks.delivery_date, infoapp_tasks.performance";

$ONclause1="infoapp_tasks.perf_code_1 LIKE infoapp_performance_goals.perf_code";
$whereClause="(user_code_1 LIKE $user_code OR user_code_2 LIKE $user_code or user_code_3 LIKE $user_code) AND infoapp_tasks.month LIKE $month AND infoapp_tasks.year LIKE $year AND infoapp_tasks.task_report like 1";
$orderBy="infoapp_performance_goals.perf_code";

$resultA = db_select_1_inner_query_orderby($tasks_table, $performance_table, $fields, $ONclause1, $whereClause, $orderBy);

//Report DB query

$ONclause1="infoapp_tasks.perf_code_2 LIKE infoapp_performance_goals.perf_code";
$resultB = db_select_1_inner_query_orderby($tasks_table, $performance_table, $fields, $ONclause1, $whereClause, $orderBy);

//Report DB query

$ONclause1="infoapp_tasks.perf_code_3 LIKE infoapp_performance_goals.perf_code";
$resultC = db_select_1_inner_query_orderby($tasks_table, $performance_table, $fields, $ONclause1, $whereClause, $orderBy);

?>

<!DOCTYPE HTML>
<html>
	<head>
		<!-- <meta charset="utf-8"> -->
        <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/test_borders.css">
		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container my_cont">

	<?php include '../includes/header.php'; ?>

    <div class = "row justify-content-center my_row">
        <div class = "col-6 mi_col bg-info text-white">
                <!--(row_!Titulo!)-->
                <p class="text-center h2">Informe Personal de Desempe&ntilde;o</p>
        </div>
    </div>
          
		<div class = "row justify-content-center my_row">
			<div class = "table-responsive">
				<!-- (row_!Centro!) -->
                <table class="table table-sm table-bordered" id="tblData">

                <thead class="thead-light">
                        <tr>
                            <th colspan="5"><h1></h1></th>
                        </tr>
                        <tr>
                            <td colspan="5"><h2>Informe de Desempe&ntildeo Mensual</h2></td>
                        </tr>
                        <tr>
                            <td colspan="5">Correspondiente al mes de 
                            <?php                                  
                                    echo monthName($mes)."del 20".$year;                         //funcion de mes
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">Funcionario
                                <?php echo $name. ' '; 
                                echo $last_name;?>
                            </td>
                        </tr>
                        <tr>
                            <th>Meta de Desempe&ntildeo Primaria:</th>
                            <th>T&iacutetulo:</th>
                            <th>Fecha l&iacutemite:</th>
                            <th>Fecha entregada:</th>
                            <th>Nota Obtenida:</th>
                        </tr>
                    </thead>
                    <?php
                        while ($line =  $resultA->fetch_assoc()) 
                                    {
                                        echo "<tr>";
                                        foreach ($line as $col_name => $col_value)
                                        {
                                            echo "<td><small>$col_value</small></td>";
                                        }
                                        echo "</tr>";
                                    }
                    ?>
                    <thead class="thead-light">
                        <tr>
                            <th>Meta de Desempe&ntildeo Secundaria:</th>
                            <th>T&iacutetulo:</th>
                            <th>Fecha l&iacutemite:</th>
                            <th>Fecha entregada:</th>
                            <th>Nota Obtenida:</th>
                        </tr>
                    </thead>
                    <?php
                        while ($line =  $resultB->fetch_assoc()) 
                                    {
                                        echo "<tr>";
                                        foreach ($line as $col_name => $col_value)
                                        {
                                            echo "<td><small>$col_value</small></td>";
                                        }
                                        echo "</tr>";
                                    }
                    ?>
                    <thead class="thead-light">
                        <tr>
                            <th>Meta de Desempe&ntildeo Terciaria:</th>
                            <th>T&iacutetulo:</th>
                            <th>Fecha l&iacutemite:</th>
                            <th>Fecha entregada:</th>
                            <th>Nota Obtenida:</th>
                        </tr>
                    </thead>
                    <?php
                        while ($line =  $resultC->fetch_assoc()) 
                                    {
                                        echo "<tr>";
                                        foreach ($line as $col_name => $col_value)
                                        {
                                            echo "<td><small>$col_value</small></td>";
                                        }
                                        echo "</tr>";
                                    }
                    ?>
                

                </table>
            </div>
        <button class="btn btn-warning" onclick="exportTableToExcel('tblData', 'informe_desempeno')">Exportar a Excel</button><br>
		</div>

        <div class = "row justify-content-center my_row">
                <div class = "col-6 my_col">
                    <p class="text-center"><a class="btn btn-info" href="../index.php">Volver</a></p>  
                </div>                
        </div>

		<div class = "row justify-content-center mi_row">
			<div class = "col-6 my_col blockquote-footer">
				<!--(row_!abajo!)-->

				<p class="text-center">- Desarrollado por Laboratorio I + D - 2020 - </p>
			</div>
		</div>

	</div>
<script src="export_report_excel.js"></script> 
</body>
</html>