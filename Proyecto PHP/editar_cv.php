<?php
include("conexion.php");
//revisar todo
if (!isset($_GET["id"])) {
    die("ID no especificado");
}
//Variable para guardar el id.
$id = intval($_GET["id"]);


//consulta para extraer los datos del cv por id.
$searchDbId = "SELECT * FROM datos_cv WHERE id = ?";

$sentencia = $connect->prepare($searchDbId);

$sentencia->bind_param("i", $id);
$sentencia->execute();

$resultado = $sentencia->get_result();

if ($resultado->num_rows === 0) {
    die("CV no encontrado");
}

$cv = $resultado->fetch_assoc();

$sentencia->close();
$connect->close();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Editar CV (se creará una nueva versión)</h2>

    <form action="send_cv.php" method="POST" enctype="multipart/form-data">

        <!-- 🔴 CLAVE: mantener version_cv -->
        <input type="hidden" name="version_cv" value="<?= $cv['version_cv'] ?>">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control"
                       value="<?= htmlspecialchars($cv['nombre']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control"
                       value="<?= htmlspecialchars($cv['apellidos']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($cv['email']) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control"
                       value="<?= htmlspecialchars($cv['telefono']) ?>">
            </div>

            <div class="col-md-12">
                <label class="form-label">Domicilio</label>
                <input type="text" name="domicilio" class="form-control"
                       value="<?= htmlspecialchars($cv['domicilio']) ?>">
            </div>

            <div class="col-md-12">
                <label class="form-label">Experiencia</label>
                <textarea name="experiencia" class="form-control" rows="3"><?= htmlspecialchars($cv['experiencia']) ?></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Formación</label>
                <textarea name="formacion" class="form-control" rows="3"><?= htmlspecialchars($cv['formacion']) ?></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Habilidades</label>
                <textarea name="habilidades" class="form-control"><?= htmlspecialchars($cv['habilidades']) ?></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Idiomas</label>
                <textarea name="idiomas" class="form-control"><?= htmlspecialchars($cv['idiomas']) ?></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Nueva foto (opcional)</label>
                <input type="file" name="foto" class="form-control">
                <input type="hidden" name="foto_actual" value="<?= htmlspecialchars($cv['foto']) ?>">
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                Guardar nueva versión
            </button>
            <a href="listado.php" class="btn btn-secondary">Cancelar</a>
        </div>

    </form>
</div>

</body>
</html>
