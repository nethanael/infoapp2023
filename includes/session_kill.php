<?php

session_start();

	//Vaciar variables principales

	$_SESSION['LOGIN_INFOAPP'] = FALSE;
	$_SESSION['USER'] = '';
	$_SESSION['NAME'] = '';
	$_SESSION['LAST_NAME'] = '';
	$_SESSION['ID'] = '';
	$_SESSION['USER_CODE'] = '';
	$_SESSION['DEPT_CODE'] = '';
	$_SESSION['ROLE_NAME'] = '';
    $_SESSION['ROLE_DESCRIPTION'] = '';

	//empty all form temporary sessions variables

	$_SESSION['LOGIN_ERROR'] = '';				
	$_SESSION['USER_TEMP'] = '';		
	
	
	$_SESSION['NEW_TASK_ERROR'] = '';	
	$_SESSION['TASK_TITLE_TEMP'] = '';
	$_SESSION['TASK_DESCRIPTION_TEMP'] = '';			
	//$_SESSION['EDITAR_ERROR'] = '';				
	//$_SESSION['REACT_ERROR'] = '';				
	//$_SESSION['REABRIR_ERROR'] = '';				
	
	//$_SESSION['AVC_ERROR'] = '';
	
	//$_SESSION['MSJ_ERROR'] = '';
	
	header("Location: ../index.php");

?>
