<?php

	$_SESSION['LOGIN_INFOAPP'] = TRUE;
	$_SESSION['USER'] = $data["user"];
	$_SESSION['NAME'] = $data["name"];
	$_SESSION['LAST_NAME'] = $data["last_name"];
	$_SESSION['ID'] = $data["id"];
	$_SESSION['USER_CODE'] = $data["user_code"];
	$_SESSION['DEPT_CODE'] = $data["dept_code"];
	$_SESSION['ROLE_NAME'] = $data["role_name"];
	$_SESSION['ROLE_CODE'] = $data["role_code"];
    $_SESSION['ROLE_DESCRIPTION'] = $data["role_description"];
	$_SESSION['INBOX_MSG'] = $data["inbox_msg"];

	//empty all form temporary sessions variables

	$_SESSION['LOGIN_ERROR'] = '';				
	$_SESSION['USER_TEMP'] = '';				
	//$_SESSION['CAMBIO_PASS_ERROR'] = '';		
	
	$_SESSION['NEW_TASK_ERROR'] = '';			
	$_SESSION['TASK_TITLE_TEMP'] = '';			
	$_SESSION['TASK_DESCRIPTION_TEMP'] = '';	

	$_SESSION['EDIT_TASK_ERROR'] = '';	
	$_SESSION['REACTIVATE_TASK_ERROR'] = '';		
			
	//$_SESSION['REACT_ERROR'] = '';				
	//$_SESSION['REABRIR_ERROR'] = '';			

	//$_SESSION['AVC_ERROR'] = '';
	
	//$_SESSION['MSJ_ERROR'] = '';
	
?>