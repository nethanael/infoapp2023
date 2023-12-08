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

    // count how many performance goals the dept have in DB

    $DB_data = countRows("infoapp_performance_goals", "perf_dept_code=$dept_code");
    //var_dump($DB_data);  
    $numberRows= $DB_data["COUNT(*)"];

    $performance_goal_index = 1;

    // HERE WE BUILD ONE QUERY FOR EVERY PERFOMANCE GOAL (PERF CODE 1)

    for ($numberRows; $numberRows > 0; $numberRows--) {

        /*$queries[$performance_goal_index] = "SELECT infoapp_performance_goals.perf_name, infoapp_performance_goals.perf_code, 
        infoapp_tasks.task_code, infoapp_tasks.task_title, infoapp_tasks.task_description, infoapp_tasks.performance 
        FROM infoapp_tasks INNER JOIN infoapp_performance_goals ON infoapp_tasks.perf_code_1=infoapp_performance_goals.perf_code OR infoapp_tasks.perf_code_2=infoapp_performance_goals.perf_code OR infoapp_tasks.perf_code_3=infoapp_performance_goals.perf_code 
        WHERE (user_code_1 Like $user_code OR user_code_2 LIKE $user_code or user_code_3 LIKE $user_code) AND perf_code_1 LIKE $performance_goal_index 
        AND month LIKE $month AND year LIKE $year AND infoapp_tasks.task_report like 1"; */

        $queries[$performance_goal_index] = "SELECT * FROM infoapp_performance_goals 
        WHERE perf_code LIKE $performance_goal_index";
        
        $performance_goal_index = $performance_goal_index + 1; 
    }

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
                <?php
                  
                //print_r($queries);

                for ($i = 1; $i <= count($queries); $i++){
                    include '../includes/connection.php';
                    $result = mysqli_query($conn, $queries[$i]);
    
                    while ($line =  $result->fetch_assoc()) 
                                    {
                                        foreach ($line as $col_name => $col_value)
                                        {
                                            echo "<tr><td colspan='4'><small>$col_value</small></td></tr>";
                                        }
                                    }
                    
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
<script src="export_excel.js"></script> 
</body>
</html>