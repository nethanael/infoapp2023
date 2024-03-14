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
    $name = $_SESSION['NAME'];
    $user_code = $_SESSION['USER_CODE'];

    $year = date("y");	
	$month = date("m");

    $user_codes_1D=db_1D_query("SELECT user_code FROM infoapp_users WHERE dept_code LIKE $dept_code");

    include 'includes/connection.php';  
    $query1 = "SELECT COUNT(*) as total FROM infoapp_tasks WHERE month = '$month' AND year = '$year' AND dept_code LIKE $dept_code";
    //echo $query2;
    $result1 = mysqli_query($conn, $query1, MYSQLI_USE_RESULT);
    $data1 = mysqli_fetch_assoc($result1);  

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
            <div class="col-5 my_col">
                <canvas id="myChart" width="20" height="20"></canvas>
            </div>
			<div class = "col-3 my_col">
				<!-- (row_!Centro!) -->
                <table class="table table-sm table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th class="my_td" colspan="3">Actividades asignadas</th>
						</tr>
						<tr>
							<th class="my_td" colspan="3"> 
								Mes:   
								<?php                                  
									echo monthName();                         //funcion de mes
								?>
							</th>
						</tr>
                    </thead>
					<tr>
							<td>Colaborador</td>
                            <td>Cantidad</td>
                            <td>Participac&iacuteon</td>
					</tr>

                        <?php
                                $phpDataPoints = array();                       //se crear array de php para meter los datos del grafico    
                                foreach($user_codes_1D as $user_code){
                                    include 'includes/connection.php';  
                                    $query2 = "SELECT COUNT(*) as total FROM infoapp_tasks WHERE (user_code_1 = '$user_code' OR user_code_2 = '$user_code' OR user_code_3 = '$user_code') AND month = '$month' AND year = '$year' ";
                                    //echo $query1;
                                    $result2 = mysqli_query($conn, $query2, MYSQLI_USE_RESULT);
                                    $data2 = mysqli_fetch_assoc($result2);  

                                    $DB_data = db_select_simple_fetch("infoapp_users", "last_name", "user_code=$user_code");
                                    $last_name = ($DB_data["last_name"]) ? ($DB_data["last_name"]) : ("Sin asignar");
                                    $data3 = ($data2["total"] * 100) / $data1["total"]; 

                                    $involvement = $data2["total"];
                                    array_push($phpDataPoints, $involvement, $last_name);

                                    echo "<tr>";
                                        echo "<td><span class='badge badge-info'>$last_name</span></td>";
                                        echo '<td class="my_td">'.$data2["total"]."</td>";
                                        echo '<td class="my_td">'.round($data3, 2).'%</td>';
                                    echo "<tr>";
                                }

                                echo '<tr><td class="my_td">Total del área:</td>';
                                echo '<td class="my_td" colspan="2">'.$data1["total"].'</td></tr>';
                                $dept_total = $data1["total"];
                                        //Se insertan datos al array de php para el grafico
                                array_push($phpDataPoints, $dept_total, "Total Area");
                                $js_dataPoints = json_encode($phpDataPoints);               //Se transforma array de PHP a array JS
                                //var_dump($dataPoints);
                        ?>   

                <tr><td class="my_td" colspan="4"><a class="btn btn-sm btn-info" href="index.php">Volver</a></td></tr>  
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