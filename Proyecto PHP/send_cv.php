<?php

//Importamos el archivo php que tiene la conexión.
include("conexion.php");

// echo "<pre>"; //borrar en el futuro
// print_r($_POST);
// print_r($_FILES);
// echo "</pre>";

//Proceso que recoge los datos de los inputs.
$nombre = trim($_POST['nombre']);
$apellidos= trim($_POST['apellidos']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$domicilio = trim($_POST['domicilio']);
$experiencia = trim($_POST['experiencia']);
$formacion = trim($_POST['formacion']);
$habilidades = trim($_POST['habilidades']);
$idiomas = trim($_POST['idiomas']);

//Variable para guardar las versiones de un CV.
$version_cv = time();

//Actualizar foto?-
$nombreFoto = null;

//Guardar foto en la carpeta designada.
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0){
    $nombreOriginal = $_FILES["foto"]["name"];
    $tmp = $_FILES["foto"]["tmp_name"];

    //Para evitar sobrescribir el nombre.
    $nombreFoto = time() . "_" . $nombreOriginal;
    $rutaDestino = "uploads/" . $nombreFoto;

    if (move_uploaded_file($tmp, $rutaDestino)) {
        echo "<p>✅ Foto guardada correctamente en: $rutaDestino</p>";
    } else {
        echo "<p>❌ Error al mover la foto</p>";
    }
} else {
    echo "<p> No se encontro la foto <p>";
    
};

//Insertar los datos recogidos en la tabla de base de datos.
$insertTable = "INSERT INTO datos_cv 
(version_cv, nombre, apellidos, email, telefono, domicilio, experiencia, formacion, habilidades, idiomas, foto)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$sentencia = $connect->prepare($insertTable);

if (!$sentencia) {
    die("JODER en prepare(): " . $connect->error);
}

$sentencia->bind_param(
    "issssssssss",
    $version_cv,
    $nombre,
    $apellidos,
    $email,
    $telefono,
    $domicilio,
    $experiencia,
    $formacion,
    $habilidades,
    $idiomas,
    $nombreFoto
);
if ($sentencia->execute()) {
    echo "OK";
} else {
    echo "CAGOENDIO en execute(): " . $sentencia->error;
}

//Variable que guarda el id.
$id_cv = $sentencia->insert_id;
header("Location: ver_cv.php?id=" . $id_cv);
exit;

//Se cierra la sentencia y la conexión.
$sentencia->close();
$connect->close();
?>