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

    $dept_code = $_SESSION['DEPT_CODE'];
    $name = $_SESSION['NAME'];
    $user_code = $_SESSION['USER_CODE'];

    $year = date("y");	
	$month = date("m");

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimun-scale=1.0">
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/test_borders.css">
        <script src="./chart_scripts/createGraphData.js"></script>
        <script src="./chart_scripts/chart.min.js"></script>
        <script src="./chart_scripts/chart.js"></script>
		<title>Sistema de Informes</title>
	</head>
<body>
	<div class = "container my_cont">

	<?php include 'includes/header.php'; ?>
	<?php include 'includes/navBar.php'; ?>
          
		<div class = "row justify-content-center my_row">
            <div class="col-3 my_col">
                <canvas id="myChart" width="400" height="400">
                </canvas>
            </div>
			<div class = "col-3 my_col">
				<!-- (row_!Centro!) -->
                <table class="table table-sm table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th class="my_td" colspan="2">Actividades asignadas</th>
						</tr>
						<tr>
							<th class="my_td" colspan="2"> 
								Mes:   
								<?php                                  
									echo monthName();                         //funcion de mes
								?>
							</th>
						</tr>
                    </thead>
					<tr>
							<td colspan="2"><img src=""></td>
					</tr>

                        <?php
                                $phpDataPoints = array();                       //se crear array de php para meter los datos del grafico    
                                
                                include 'includes/connection.php';  
                                $query1 = "SELECT COUNT(*) as total FROM infoapp_tasks WHERE (user_code_1 = '$user_code' OR user_code_2 = '$user_code' OR user_code_3 = '$user_code') AND month = '$month' AND year = '$year' ";
                                //echo $query1;
                                $result1 = mysqli_query($conn, $query1, MYSQLI_USE_RESULT);
                                $data1 = mysqli_fetch_assoc($result1);  
                                echo '<tr><td class="my_td">'.$name.":</td>";
                                echo '<td class="my_td">'.$data1["total"]."</td></tr>";

                                include 'includes/connection.php';  
                                $query2 = "SELECT COUNT(*) as total FROM infoapp_tasks WHERE month = '$month' AND year = '$year' AND dept_code LIKE $dept_code";
                                //echo $query2;
                                $result2 = mysqli_query($conn, $query2, MYSQLI_USE_RESULT);
                                $data2 = mysqli_fetch_assoc($result2);  
                                echo '<tr><td class="my_td">Total del área:</td>';
                                echo '<td class="my_td">'.$data2["total"].'</td></tr>';

                                $data3 = ($data1["total"] * 100) / $data2["total"];  
                                echo '<tr><td class="my_td">Porcentaje:</td>';
                                echo '<td class="my_td">'.round($data3, 2).'%</td></tr>';

                                $involvement = $data1["total"];
                                $dept_total = $data2["total"];
                                array_push($phpDataPoints, $involvement, $name);        //Se insertan datos al array de php para el grafico
                                array_push($phpDataPoints, $dept_total, "Total Area");
                                $js_dataPoints = json_encode($phpDataPoints);               //Se transforma array de PHP a array JS
                                //var_dump($dataPoints);
                        ?>   

                <tr><td class="my_td" colspan="2"><a class="btn btn-sm btn-info" href="index.php">Volver</a></td></tr>  
                </table>
            </div>
		</div>

        <?php include 'includes/footer.php'; ?>

	</div>
</body>
<script>
    data = createData(<?php echo $js_dataPoints; ?>); //Se llama función que crea los labels compatibles al chart.js
    console.log(data);
    labels = createLabels(<?php echo $js_dataPoints; ?>); //Se llama función que crea la data compatible al chart.js
    console.log(labels);
</script>
</html>