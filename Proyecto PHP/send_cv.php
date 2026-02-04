<?php
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

// Guardar foto en la carpeta designada
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0){
    $nombreOriginal = $_FILES["foto"]["name"];
    $tmp = $_FILES["foto"]["tmp_name"];

    //Para evitar sobrescribir el nombre
    $nombreFinal = time() . "_" . $nombreOriginal;
    $rutaDestino = "uploads/" . $nombreFinal;

    if (move_uploaded_file($tmp, $rutaDestino)) {
        echo "<p>✅ Foto guardada correctamente en: $rutaDestino</p>";
    } else {
        echo "<p>❌ Error al mover la foto</p>";
    }
} else {
    echo "<p> No se encontro la foto <p>";
    
};
?>