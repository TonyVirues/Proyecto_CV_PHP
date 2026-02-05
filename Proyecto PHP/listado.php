<?php
include("conexion.php");


//Consulta para obtener todos los cv almacenados.
$obtenerTodosCv="SELECT id, nombre, apellidos, email, fecha_creacion 
        FROM datos_cv 
        ORDER BY fecha_creacion DESC";


//Variable que ejecuta la consulta y guarda la info extraida.
$resultado = $connect->query($obtenerTodosCv);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis CVs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Mis Currículums</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cv = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($cv['nombre']) ?> <?= htmlspecialchars($cv['apellidos']) ?></td>
                        <td><?= htmlspecialchars($cv['email']) ?></td>
                        <td><?= $cv['fecha_creacion'] ?></td>
                        <td>
                            <a href="ver_cv.php?id=<?= $cv['id'] ?>" class="btn btn-sm btn-primary">
                                Ver
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay CVs guardados.</p>
    <?php endif; ?>

</div>

</body>
</html>