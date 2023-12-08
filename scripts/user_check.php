<?php 

session_start();

$user = $_POST["user"];
$pass = md5($_POST["pass"]);

if ($user == '' || $pass == '') 
{

	$_SESSION['LOGIN_ERROR'] = "Datos incompletos!";
	$_SESSION['USER_TEMP'] = $user;
	header("Location: ../index.php");
}
else 
{
	include '../includes/connection.php';
    $query = "SELECT * FROM `infoapp_users` INNER JOIN `infoapp_roles` 
    ON infoapp_users.role_code=infoapp_roles.role_code WHERE infoapp_users.user='$user'";
	//$query = "SELECT * FROM infoapp_users WHERE user like '$user'";
	$resul = mysqli_query($conn, $query, MYSQLI_USE_RESULT);
	$data = mysqli_fetch_assoc($resul);
	$user_bd = $data["user"];
	$pass_bd = $data["password"];

// Primeramente hacer la autenticación contra el active directory
// Que el password esté en el LDAP
// pero el role si se mantiene una tabla de la base de datos local

	mysqli_free_result($resul); 

	if ($user == $user_bd) 
	{
		if ($pass == $pass_bd) 
		{
			include '../includes/session_start.php';
            if ($_SESSION['ROLE_NAME'] == "administrator") header("Location: ../home_admin.php");
			if ($_SESSION['ROLE_NAME'] == "supervisor") header("Location: ../home_supervisor.php");
            if ($_SESSION['ROLE_NAME'] == "employee") header("Location: ../home_employee.php");
	    }
		else
		{
			$_SESSION['LOGIN_ERROR'] = "Clave Incorrecta.";
			$_SESSION['USER_TEMP'] = $user;
			header("Location: ../index.php");
		}
	}
	else 
	{ 
		$_SESSION['LOGIN_ERROR'] = "Usuario no registrado";
		$_SESSION['TEMP'] = '';
		header("Location: ../index.php");
	}
}

?>

