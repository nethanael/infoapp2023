<?php

	$_SESSION['LOGIN_INFOAPP'] = TRUE;
	$_SESSION['USER'] = $data["user"];
	$_SESSION['NAME'] = $data["name"];
	$_SESSION['LAST_NAME'] = $data["last_name"];
	$_SESSION['ID'] = $data["id"];
	$_SESSION['USER_CODE'] = $data["user_code"];
	$_SESSION['ROLE_NAME'] = $data["role_name"];
    $_SESSION['ROLE_DESCRIPTION'] = $data["role_description"];

	//recordar vaciar todas las variables de sesión.

	$_SESSION['LOGIN_ERROR'] = '';				//revisado
	$_SESSION['USER_TEMP'] = '';				//revisado
	//$_SESSION['CAMBIO_PASS_ERROR'] = '';		//revisado
	
	//$_SESSION['ACT_ERROR'] = '';				//revisado
	//$_SESSION['EDITAR_ERROR'] = '';				//revisado
	//$_SESSION['REACT_ERROR'] = '';				//revisado
	//$_SESSION['REABRIR_ERROR'] = '';			//revisado	

	//$_SESSION['AVC_ERROR'] = '';
	
	//$_SESSION['MSJ_ERROR'] = '';
	
?>