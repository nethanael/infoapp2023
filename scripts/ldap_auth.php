<?php

session_start();

//$adServer = "ldap://domaincontroller.mydomain.com";
$adServer = "ldap://icetel.ice:3268";

$ldap = ldap_connect($adServer);
$username = $_POST['user'];
$password = $_POST['pass'];

//$ldaprdn = 'mydomain' . "\\" . $username;
$ldaprdn = 'icetel' . "\\" . $username;

ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

$bind = @ldap_bind($ldap, $ldaprdn, $password);

if ($bind) {


    include '../includes/connection.php';
    $query = "SELECT * FROM `infoapp_users` INNER JOIN `infoapp_roles` 
    ON infoapp_users.role_code=infoapp_roles.role_code WHERE infoapp_users.user='$username'";
    $resul = mysqli_query($conn, $query, MYSQLI_USE_RESULT);
    $data = mysqli_fetch_assoc($resul);

    $_SESSION['PASS'] = $password;
    include '../includes/session_start.php';
    if ($_SESSION['ROLE_NAME'] == "administrator") header("Location: ../home_admin.php");
    if ($_SESSION['ROLE_NAME'] == "supervisor") header("Location: ../home_supervisor.php");
    if ($_SESSION['ROLE_NAME'] == "employee") header("Location: ../home_employee.php");


    @ldap_close($ldap);
    } else {

        $_SESSION['LOGIN_ERROR'] = "Clave Incorrecta.";
        $_SESSION['USER_TEMP'] = $user;
        header("Location: ../index.php");

    }?>

