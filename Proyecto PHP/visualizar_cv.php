<?php
include("conexion.php");

//Revisión de si obtiene el id.
if (!isset($_GET["id"])){
    die("ID del cv no encontrado");
}

//Se guarda en la variable ID el valor obtenido.
$id= intval($_GET["id"]);

//Consulta que busca el id en la base de datos.
$searchDbId = "SELECT * FROM datos_cv WHERE id = ?";
$sentencia = $connect->prepare($searchDbId);

//Comprobación de conexión.
if(!$sentencia){
    die("Error de prepare(): " .$connect->error);
}

$sentencia->bind_param("i", $id);
$sentencia->execute();

//Variable que guarda la obtencion de los datos.
$resultado = $sentencia->get_result();

//Busqueda del cv.
if($resultado->num_rows ===0){
    die("CV no encontrado.");
}

//Varioalbe que guarda el cv.
$cv = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CV de <?= htmlspecialchars($cv['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }

        .cv-container {
            background: white;
            max-width: 900px;
            margin: 40px auto;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .cv-header {
            display: flex;
            gap: 20px;
            align-items: center;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .cv-header img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }

        @media print {
            body {
                background: white;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="cv-container">

    <!-- BOTONES -->
    <div class="no-print text-end mb-4">
    <button onclick="window.print()" class="btn btn-primary">
        🖨️ Imprimir CV
    </button>

    <!-- Botón Guardar PDF --> <!--CAMBIAR ESTO POR DIOS.-->
    <button onclick="guardarPDF()" class="btn btn-outline-primary disable">
        📄 Guardar como PDF
    </button>
        <a href="listado.php" class="btn btn-secondary">
            Volver
        </a>
    </div>

    <!-- CABECERA -->
    <div class="cv-header">
        <?php if (!empty($cv['foto'])): ?>
            <img src="uploads/<?= htmlspecialchars($cv['foto']) ?>" alt="Foto de perfil">
        <?php endif; ?>

        <div>
            <h1><?= htmlspecialchars($cv['nombre']) ?> <?= htmlspecialchars($cv['apellidos']) ?></h1>
            <p><strong>Email:</strong> <?= htmlspecialchars($cv['email']) ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($cv['telefono']) ?></p>
            <p><strong>Dirección:</strong> <?= htmlspecialchars($cv['domicilio']) ?></p>
        </div>
    </div>

    <!-- SECCIONES -->
    <section class="mb-4">
        <h4 class="text-primary">Experiencia Laboral</h4>
        <p><?= nl2br(htmlspecialchars($cv['experiencia'])) ?></p>
    </section>

    <section class="mb-4">
        <h4 class="text-primary">Formación Académica</h4>
        <p><?= nl2br(htmlspecialchars($cv['formacion'])) ?></p>
    </section>

    <section class="mb-4">
        <h4 class="text-primary">Habilidades</h4>
        <p><?= nl2br(htmlspecialchars($cv['habilidades'])) ?></p>
    </section>

    <section class="mb-4">
        <h4 class="text-primary">Idiomas</h4>
        <p><?= nl2br(htmlspecialchars($cv['idiomas'])) ?></p>
    </section>

</div><!--Cambiar esto por dios-->
<script>
function guardarPDF() {
    alert(
        "Para guardar el currículum en PDF:\n\n" +
        "1. Pulsa Aceptar\n" +
        "2. En el diálogo de impresión elige 'Guardar como PDF'\n" +
        "3. Confirma la descarga"
    );
    window.print();
}
</script>
</body>
</html>