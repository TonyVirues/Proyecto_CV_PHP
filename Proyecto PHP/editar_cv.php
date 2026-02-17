<?php
include("conexion.php");

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

<!-- Aquí comienza la estructura html. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-dark">

    <header>
        <!--Cabecera-->
        <div class="navbar navbar-dark bg-primary mb-4">
            <div class="container-fluid">
                <button class="btn">
                    <a class="nav-link navbar-brand mb-0 h1" href="index.html">
                        <i class="bi bi-file-earmark-person"></i>Creador Curriculums</a>
                </button>
            </div>
        </div>
    </header>

<main class="container">

    <div class="row justify-content-center " >
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-body p-4" style="background-color: #E3E3E3;">

                    <h3 class="text-center mb-4">
                        Editar CV
                        <small class="d-block text-muted fs-6">
                            Se creará una nueva versión
                        </small>
                    </h3>

                    <form action="send_cv.php" method="POST" enctype="multipart/form-data">

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
                                <input type="tel" name="telefono" class="form-control"
                                    value="<?= htmlspecialchars($cv['telefono']) ?>"pattern="[0-9]{9}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Domicilio</label>
                                <input type="text" name="domicilio" class="form-control"
                                    value="<?= htmlspecialchars($cv['domicilio']) ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Experiencia</label>
                                <textarea name="experiencia" class="form-control" rows="3" required><?= htmlspecialchars($cv['experiencia']) ?></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Formación</label>
                                <textarea name="formacion" class="form-control" rows="3" required><?= htmlspecialchars($cv['formacion']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Habilidades</label>
                                <textarea name="habilidades" class="form-control" required><?= htmlspecialchars($cv['habilidades']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Idiomas</label>
                                <textarea name="idiomas" class="form-control" required><?= htmlspecialchars($cv['idiomas']) ?></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nueva foto (opcional)</label>
                                <input type="file" name="foto" class="form-control">
                                <input type="hidden" name="foto_actual" value="<?= htmlspecialchars($cv['foto']) ?>">
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                Guardar nueva versión
                            </button>
                            <a href="listado.php" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</main>


</body>
</html>
