<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id_proyecto = $_POST['id_proyecto'];
    $titulo_proyecto = $_POST['titulo_proyecto'];
  
    // Llama a la funcion para actualizar el titulo del proyecto
    updateProyecto($id_proyecto, $titulo_proyecto);
    
    header("Location: welcome.php");
    exit();
  }
  
  // Función para actualizar el proyecto
  function updateProyecto($id_proyecto, $titulo_proyecto) {
   
    global $pdo; 
  
    $stmt = $pdo->prepare("UPDATE proyectos SET titulo_proyecto = ? WHERE id_proyecto = ?");
    $stmt->execute([$titulo_proyecto, $id_proyecto]);
  }