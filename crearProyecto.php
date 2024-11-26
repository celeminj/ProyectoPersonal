<?php
session_start();
require_once 'bd.php';

require_once 'insertProyecto.php';
$proyectos = insertProyectos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    require_once('mensajes.php');

    if (isset($_SESSION['ciudad'])) {
        $ciudad = $_SESSION['ciudad'];
        unset($_SESSION['ciudad']);
    } else {
        $ciudad = [
            'id_ciudad' => '',
            'nombre' => ''
        ];
    }
    ?>
    <form action="" method="POST">
     <div class="container">

            <div class="card-body">
                <h1 class="card-title">Proyecto</h1>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="nombreProyecto" class="col-form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control" name="titulo_proyecto" id="id_titulo_proyecto"
                            placeholder="Introduce el titulo del proyecto" autofocus
                            value="<?php echo $proyectos['titulo_proyecto']; ?>">

                    </div>
                </div>

            </div>
            <div class="mt-3 text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary" name="insert">Añadir</button>
                    <a href="welcome.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </div>

    </form>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>

</html>