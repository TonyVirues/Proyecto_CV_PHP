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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-dark">
    <header>
        <div class="navbar navbar-dark bg-primary mb-4">
            <div class="container">              
                <button class="btn">
                    <a class="nav-link navbar-brand mb-0 h1" href="index.html">
                        <i class="bi bi-file-earmark-person"></i>
                            CV Generator</a>
                </button>
            </div>

            <div class="me-4">
                <button type="button" class="btn btn-outline-light ">Inicia Sesión</button>
                <button type="button" class="btn bg-light ">Registrate</button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-5">
        <h2 class="mb-4 ms-5">Mis Currículums</h2>

        <?php if ($resultado->num_rows > 0): ?>
                <div class="row">

                    <!--Menú de navegación.-->
                    <div class="col-3">
                        <div class="px-3 py-4 h-100">

                            <nav class=" rounded-4 shadow-sm p-3 h-100" style="background-color: #e3f2fd;">

                                <ul class="nav nav-pills flex-column gap-1">
                                    <li class="nav-item">
                                        <a class="nav-link " href="index.html">Creación Curriculum</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="listado.php">Mis curriculums</a>
                                    </li>
                                </ul>

                            </nav>

                        </div>
                    </div>

                    <!--Tabla de curriculums.-->
                    <div class="col-9">
                        <div class="py-4 me-5">
                            <table class="table table-striped table-bordered rounded-2">
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
                                                <a href="visualizar_cv.php?id=<?= $cv['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
                                                <a href="editar_cv.php?id=<?= $cv['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                            <a href="eliminar_cv.php?id=<?= $cv['id'] ?>"class="btn btn-sm btn-danger"onclick="return confirm('¿Seguro que quieres eliminar esta versión del CV?');">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

        <?php else: ?>
            <p>No hay CVs guardados.</p>

        <?php endif; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>