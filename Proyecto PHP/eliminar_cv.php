<?php

include("conexion.php");

if (!isset($_GET['id'])) {
    die("ID no especificado");
}

$id = intval($_GET['id']);

/**
 * Consulta que recoge la foto del servidor,
 * para poder borrarla de la carpeta.
 */
$sqlFoto = "SELECT foto FROM datos_cv WHERE id = ?";
$stmtFoto = $connect->prepare($sqlFoto);
$stmtFoto->bind_param("i", $id);
$stmtFoto->execute();
$resultado = $stmtFoto->get_result();

if ($resultado->num_rows === 0) {
    die("CV no encontrado");
}

$cv = $resultado->fetch_assoc();
$stmtFoto->close();

//Consulta que borra los datos por id.
$sqlDelete = "DELETE FROM datos_cv WHERE id = ?";
$stmtDelete = $connect->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);
$stmtDelete->execute();
$stmtDelete->close();

//Busca la imagen y la borra de la carpeta.
if (!empty($cv['foto']) && file_exists("uploads/" . $cv['foto'])) {
    unlink("uploads/" . $cv['foto']);
}

$connect->close();

//Vuelve al listado.
header("Location: listado.php");
exit;
