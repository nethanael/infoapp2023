<?php

    session_start();

	$_SESSION['ROLE_NAME'] = "employee";
	$_SESSION['ROLE_CODE'] = 3;
    $_SESSION['ROLE_DESCRIPTION'] = "Department employee";

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

    header("Location: ../home_employee.php");
	
?>