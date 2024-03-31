<?php

	$ts = gmdate("D, d M Y H:i:s") . " GMT";
	header("Expires: $ts");
	header("Last-Modified: $ts");
	header("Pragma: no-cache");
	header("Cache-Control: no-cache, must-revalidate");

	session_start();

    $adServer = "ldap://icetel.ice:3268";

    $ldap = ldap_connect($adServer);
    $username = $_SESSION['USER'];
    $password = $_SESSION['PASS'];

    //echo $_SESSION['PASS'];

    $ldaprdn = 'icetel' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);

    if ($bind) {
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,"dc=icetel,dc=ice",$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);

        // next "for" explores de ldap object

        /*for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
            echo "<p>Usuario de RED: <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
            echo '<pre>';
            var_dump($info);
            echo '</pre>';
            $userDn = $info[$i]["distinguishedname"][0]; 
        }*/
        @ldap_close($ldap);
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
				<table class="table">
					<thead class="thead-light">
						<tr>
							<th class="my_td h5" colspan="2"><?php echo "<p>Usuario de RED: <strong> <br />". $info[0]["sn"][0] .", " . $info[0]["givenname"][0] ."</strong><br /> (" . $info[0]["samaccountname"][0] .")</p>\n";?></th>
						</tr>
					</thead>
					<tr>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['company'][0]; ?></p></td>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['department'][0]; ?></p></td>
					</tr>
					<tr>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['physicaldeliveryofficename'][0]; ?></p></td>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['streetaddress'][0]; ?></p></td>
					</tr>
                    <tr>
                        <td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['extensionattribute4'][0]; ?></p></td>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['mail'][0]; ?></p></td>
					</tr>
                    <tr>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['telephonenumber'][0]; ?></p></td>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $info[0]['mobile'][0]; ?></p></td>
					</tr>
					<tr>
							<th class="my_td h5" colspan="2"><?php echo "Datos InfoAPP";?></th>
						</tr>
					<tr>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $_SESSION['USER']; ?></p></td>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $_SESSION['USER_CODE']; ?></p></td>
					</tr>
					<tr>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $_SESSION['ROLE_NAME']; ?></p></td>
						<td class="my_td"><p class="badge badge-secondary" href=""><?php echo $_SESSION['ROLE_DESCRIPTION']; ?></p></td>
					</tr>
				</table>
				</div>
			</div>

        <div class = "row justify-content-center my_row">
			<div class = "col my_td"><a class="btn btn-info" href="index.php">Volver</a></div>
		</div>

		<?php include 'includes/footer.php'; ?>

	</div>
</body>
</html>

<?php  } else {
        $msg = "Invalid email address / password";
        echo $msg;
    } ?>



