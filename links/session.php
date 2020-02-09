<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$fn = $_SESSION['fullname'];
$idu = $_SESSION['idusuario'];
$rl = $_SESSION['rol'];

if ($rl != 'administrador') {
	header("location:back/logout.php");
	exit;
}

if (!isset($fn) || !isset($idu) ) {
  header("location:index.php");
}

?>