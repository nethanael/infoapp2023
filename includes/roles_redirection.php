<?php
            if ($_SESSION['ROLE_NAME'] == "administrator") header("Location: home_admin.php");
			if ($_SESSION['ROLE_NAME'] == "supervisor") header("Location: home_supervisor.php");
            if ($_SESSION['ROLE_NAME'] == "employee") header("Location: home_employee.php");
?>