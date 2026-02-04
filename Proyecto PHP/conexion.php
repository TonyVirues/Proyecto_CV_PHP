<?php

//Configuración de la conexión a BD.
$serverName="localhost";
$userName = "root";
$password = "";
$dbName = "generador_cv";

//Crear conexión.
$connect = new mysqli($serverName,$userName,$password,$dbName);

//Verificar conexión.
if($connect->connect_error){
    die("Error de conexión: " .$connect->connect_error);
}
?>