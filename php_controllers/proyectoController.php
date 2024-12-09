<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  require_once './proyectos/updateProyecto.php';

  
  if (isset($_POST['edit'])) {
    $id_proyecto = $_POST['id_proyecto'] ?? null;
    $titulo_proyecto = $_POST['titulo_proyecto'] ?? null;

    // Verificar los valores recibidos
    echo "ID Proyecto: " . var_export($id_proyecto, true) . "<br>";
    echo "Título Proyecto: " . var_export($titulo_proyecto, true) . "<br>";

    if ($id_proyecto && $titulo_proyecto) {
        updateProyecto($id_proyecto, $titulo_proyecto);

        if ($resultado['success']) {
            // Redirigir con éxito
            header('Location: ../welcome.php');
        } else {
            echo $resultado['message'];
        }
    } else {
        echo "Error: Datos incompletos para la edición.";
    }
    exit();
}
elseif(isset($_POST['delete'])){
    $id_proyecto = $_POST['id_proyecto'] ?? null;

    if($id_proyecto){
      $resultado = deleteProyecto($id_proyecto);
      echo 'Se ha eliminado el proyecto';
      header('Location: ../welcome.php');
    }
    exit();

  }
?>