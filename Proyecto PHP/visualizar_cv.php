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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CV de <?= htmlspecialchars($cv['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="Css/custom.css">
</head>
<body class="bg-dark rounded-1">
    <header>
        <div class="navbar navbar-dark bg-primary mb-4">
            <div class="container"> <span class="navbar-brand mb-0 h1"><i class="bi bi-file-earmark-person"></i> CV Generator</span> 
            </div>

            <div class="me-4">
                <button type="button" class="btn btn-outline-light ">Inicia Sesión</button>
                <button type="button" class="btn bg-light ">Registrate</button>
            </div>
        </div>
    </header>
    
    <main class="container my-5">
        <!--Multiples divs, para respetar la herencia de boostrap, permitiendo el orden de grid con columns y row-->
        <div class="row justify-content-center">
            <div class="col-lg-3 col-xl-9">
                <div class="card shadow-sm">

                    <div class="card-body p-0">

                        <div class="row g-0 ">
                            <!--Columna izquierda fotos y contacto.-->

                            <aside class="col-md-4">
                                <div class=" m-2 p-5 rounded-5 shadow-sm" style="background-color:#d8dcd8; ">

                                    <!--Foto.-->
                                    <div class="text-center mb-4">
                                        <?php if (!empty($cv['foto'])): ?>
                                            <img src="uploads/<?= htmlspecialchars($cv['foto']) ?>" 
                                            class="rounded-circle shadow-sm mb-3" width="180" height="170"alt="Foto de perfil">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!--Sobre mí.-->
                                    <div class="mb-4">
                                        <h5 class="text-uppercase fw-bold mb-2">
                                            Sobre mí
                                        </h5>
                                        <p class="small pb-4 border-bottom border-2 border-black">
                                            Mi parte favorita de la preciosa vida, es trabajar.
                                        </p>
                                    </div>

                                    <!--Contacto.-->
                                    <div class="mb-4">
                                        <h5 class="text-uppercase fw-bold mb-2">
                                            Contacto
                                        </h5>
    
                                        <p class="small mb-1">
                                            <strong>Email:</strong><br>
                                            <?= htmlspecialchars($cv['email']) ?>
                                        </p>
    
                                        <p class="small mb-1">
                                            <strong>Teléfono:</strong><br>
                                            <?= htmlspecialchars($cv['telefono']) ?>
                                        </p>
    
                                        <p class="small mb-0">
                                            <strong>Dirección:</strong><br>
                                            <?= htmlspecialchars($cv['domicilio']) ?>
                                        </p>
                                    </div>


                                </div>


                            </aside>

                            <!--Columna derecha contenido principal.-->
                            <section class="col-md-8 p-4 bg-light rounded-end ">

                                <!--Cabecera-->
                                <div class="mb-4">

                                    <!--Primer nombre.-->
                                    <h2 class=" mb-1 text-info-emphasis" >
                                        <?= htmlspecialchars($cv['nombre'])?>
                                    </h2>
                                    <!--Segundo nombre.-->
                                    <h3 class="fw-semibold mb-5 text-info-emphasis">
                                        <?= htmlspecialchars($cv['apellidos'])?>
                                    </h3>
                                                                    
                                </div>

                                <!--Experiencia laboral.-->
                                <div class="mb-2 mt-5">
                                    <h4 class="text-primary  pb-2 mb-3 mt-5">
                                        Experiencia laboral
                                    </h4>

                                    <p class="mb-5 pb-4 border-bottom border-2 border-black">
                                        <?= nl2br(htmlspecialchars($cv['experiencia'])) ?>
                                    </p>
                                </div>

                                <!--Formación académica.-->

                                <div class="mb-4">

                                    <h4 class="text-primary  pb-2 mb-3">
                                        Formación académica
                                    </h4>

                                    <p class="mb-5 pb-4 border-bottom border-2 border-black">
                                        <?= nl2br(htmlspecialchars($cv['formacion'])) ?>
                                    </p>

                                </div>

                                
                                <!--Habilidades e idiomas.-->
                                <div class="row mt-4">

                                    <!--Habilidades.-->
                                    <div class="col-md-5 border-end border-2 border-black">
                                        <h4 class="text-primary pb-2 mb-3">
                                            Habilidades
                                        </h4>

                                        <p class="mb-0">
                                            <?= nl2br(htmlspecialchars($cv['habilidades'])) ?>
                                        </p>
                                    </div>

                                    <!--idiomas.-->
                                    <div class="col-md-6">
                                        <h4 class="text-primary  ps-5 mb-3">
                                            Idiomas
                                        </h4>

                                        <p class="mb-0 ps-5">
                                            <?= nl2br(htmlspecialchars($cv['idiomas'])) ?>
                                        </p>
                                    </div>

                                </div>

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

        <!--Botones.-->
        <div class="no-print text-center mb-4">
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


                                 
    <script>
    /**
     * Hay que meter script embebido, debido que el fichero script tiene algunos problemas al cargar desde este lado
     * Lo mismo ocurre con los otros ficheros.
     * */ 
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