<?php

session_start();

	//Vaciar variables principales

	$_SESSION['LOGIN_INFOAPP'] = FALSE;
	$_SESSION['USER'] = '';
	$_SESSION['PASS'] = '';
	$_SESSION['NAME'] = '';
	$_SESSION['LAST_NAME'] = '';
	$_SESSION['ID'] = '';
	$_SESSION['USER_CODE'] = '';
	$_SESSION['DEPT_CODE'] = '';
	$_SESSION['ROLE_NAME'] = '';
    $_SESSION['ROLE_DESCRIPTION'] = '';
	$_SESSION['ROLE_CODE'] = '';
	$_SESSION['INBOX_MSG'] = '';

	//empty all form temporary sessions variables

	$_SESSION['LOGIN_ERROR'] = '';				
	$_SESSION['USER_TEMP'] = '';				
	//$_SESSION['CAMBIO_PASS_ERROR'] = '';		
	
	$_SESSION['NEW_TASK_ERROR'] = '';			
	$_SESSION['TASK_TITLE_TEMP'] = '';			
	$_SESSION['TASK_DESCRIPTION_TEMP'] = '';	

	$_SESSION['EDIT_TASK_ERROR'] = '';		
	$_SESSION['REACTIVATE_TASK_ERROR'] = '';

	$_SESSION['UPDATE_TASK_ERROR'] = '';
	$_SESSION['RETURN_TASK_ERROR'] = '';
				
	//$_SESSION['REACT_ERROR'] = '';				
	//$_SESSION['REABRIR_ERROR'] = '';				
	
	//$_SESSION['MSJ_ERROR'] = '';
	
	header("Location: ../index.php");

?>
