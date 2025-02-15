<?php
session_start();
require_once 'basedatos/bd.php';
require_once 'tareas/insertTareas.php';
require_once 'proyectos/usuarioAsociadoProyecto.php';
require_once 'php_controllers/usuarios-vinculados.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciarSesion.php");
    exit();
}

// Guardar resultados
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <?php require_once('mensaje.php'); ?>
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary">
        <div class="user-info mb-4">
            <h5>Bienvenido, <?php echo $nombre; ?></h5>
            <a href="logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                    <path fill-rule="evenodd"
                        d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
            </a>
        </div>
        <a href="welcome.php"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi pe-none me-2" width="40" height="32">
                <use xlink:href="#bootstrap" />
            </svg>
            <img src="./img/iconoEmpresa.png" alt="Logo de la empresa" width="40" height="30">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="welcome.php" class="nav-link active" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16">
                        <use xlink:href="#home" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor"
                        class="bi bi-house" viewBox="0 0 16 16">
                        <path
                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <a href="crearProyecto.php?id_proyecto?" class="nav-link link-body-emphasis">
                    <svg class="bi pe-none me-2" width="16" height="16">
                        <use xlink:href="#speedometer2" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pie-chart" viewBox="0 0 16 16">
                        <path
                            d="M7.5 1.018a7 7 0 0 0-4.79 11.566L7.5 7.793zm1 0V7.5h6.482A7 7 0 0 0 8.5 1.018M14.982 8.5H8.207l-4.79 4.79A7 7 0 0 0 14.982 8.5M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8" />
                    </svg>
                    Añadir Proyectos
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-body-emphasis">
                    <svg class="bi pe-none me-2" width="16" height="16">
                        <use xlink:href="#table" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-plus" viewBox="0 0 16 16">
                        <path
                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        <path fill-rule="evenodd"
                            d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                    </svg>
                    Invitar
                </a>
            </li>
        </ul>
        <hr>
    </div>
    <div class="container text-center mt-5">
        <input type="hidden" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
        <h1><strong>Crear Tareas</strong></h1>
    </div>
    <table>
        <div class="container text-left mt-5 col-6 border-start border-5">
            <div><strong>Tarea</strong></div>

            <form action="php_controllers/tareaController.php" method="POST">
                <input type="hidden" name="id_proyecto" value="<?php echo $id_proyecto; ?>">

                <div class="mb-3">
                    <label for="nombre_tarea" class="form-label">Nombre de la tarea:</label>
                    <input type="text" id="nombre_tarea" name="nombre_tarea" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
                    <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_final" class="form-label">Fecha final:</label>
                    <input type="datetime-local" id="fecha_final" name="fecha_final" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario:</label>
                    <select id="id_usuario" name="id_usuario" class="form-control" required>
                        <option value="" disabled selected>Selecciona un usuario</option>
                        <?php if (!empty($usuarios)) { ?>
                            <?php foreach ($usuarios as $usuario) { ?>
                                <option value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                                    <?php echo htmlspecialchars($usuario['nombre']); ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado de la tarea:</label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" id="enproceso" name="estado_tarea" value="En proceso" required>
                        En proceso
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" id="enrevision" name="estado_tarea" value="En revision" required>
                        En revision
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" id="acabado" name="estado_tarea" value="Acabado" required>
                        Acabado
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de tarea:</label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="tipo_tarea" value="Programacion" required>
                        Programación
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="tipo_tarea" value="Base de Datos" required>
                        Base de Datos
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="tipo_tarea" value="Diseño" required>
                        Diseño
                    </label>
                </div>
                    <button type="submit" class="btn btn-primary" name="insertTareas">Añadir</button>
                    <a href="welcome.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>