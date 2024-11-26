<?php
session_start();
require_once 'db.php';
require 'selectProyecto.php';
$pdo = openDB();
if (!isset($_SESSION['user_id'])) {
    header("Location: iniciarSesion.php");
    exit();
}

$stmt = $pdo->prepare("SELECT nombre FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user) {
    $nombre = htmlspecialchars($user['nombre']); // el htmlspecialchars caracteres especiales para evitar codigo malicioso
    echo "<h1>Bienvenido, $nombre</h1>";
    echo '<a href="logout.php">Cerrar sesión</a>';
} else {
    echo "Error: No se encontró información del usuario.";
    session_destroy();
    header("Location: iniciarSesion.php");
    exit();
}

$proyectos = selectProyectos();

?>

<form action="" method="POST">
    <div class="container text-center mt-5">
        <h1>Gestión de Proyectos</h1>
        <p>Crea un proyecto nuevo</p>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="crearProyecto.php" class="btn btn-primary ms-3">Añadir</a>
        </div>

    </div>
    <tbody>
        <!-- Encabezado para las ciudades -->
        <tr class="table-info">
            <td colspan="3"><strong>Tus Proyectos</strong></td>
        </tr>
        <?php foreach ($proyectos as $proyecto) { ?>
            <tr>
                <td><?php echo $proyecto['id_proyecto']; ?></td>
                <td><?php echo $proyecto['titulo_proyecto']; ?></td>
                <td>
                    <form method="POST" action="selectProyecto.php">
                        <input type="hidden" name="id_proyecto" value="<?php echo $proyecto['id_proyecto']; ?>">
                        <input type="hidden" name="titulo_proyecto" value="<?php echo $proyecto['titulo_proyecto']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Borrar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</form>