/**
 * Para crear una animacion de texto escribiendo solo el titulo 'BIENVENIDO A MULTITAREAS'
 */
document.addEventListener("DOMContentLoaded", () => {
  const textTranslations = ["BIENVENIDO A MULTITAREAS"];
  const animatedText = document.getElementById("animatedText");

  if (!animatedText) {
      console.error("Elemento con id 'animatedText' no encontrado.");
      return;
  }

  function typeText() {
      const text = textTranslations[0]; // Solo un texto
      let index = 0;

      const typingInterval = setInterval(() => {
          animatedText.textContent += text[index];
          index++;

          if (index === text.length) {
              clearInterval(typingInterval); // Detener el intervalo al terminar
          }
      }, 100); // Velocidad de tipeo
  }

  typeText(); 
});

/**
 * Para arrastrar las tareas de proceso a revision y terminado
 */
// DRAG AND DROP 
document.addEventListener("DOMContentLoaded", () => {
    const tasks = document.querySelectorAll(".item"); // Tareas
    const dropZones = document.querySelectorAll(".droppable"); // Zonas de drop

    // Configurar el arrastre
    tasks.forEach(task => {
        task.addEventListener("dragstart", e => {
            e.dataTransfer.setData("text/plain", e.target.dataset.id);
            e.target.classList.add("dragging");
        });

        task.addEventListener("dragend", e => {
            e.target.classList.remove("dragging");
        });
    });

    // Configurar las zonas de drop
    dropZones.forEach(zone => {
        zone.addEventListener("dragover", e => {
            e.preventDefault();
            zone.classList.add("drag-over");
        });

        zone.addEventListener("dragleave", e => {
            zone.classList.remove("drag-over");
        });

        zone.addEventListener("drop", e => {
            e.preventDefault();
            zone.classList.remove("drag-over");

            // Obtener el ID de la tarea arrastrada
            const taskId = e.dataTransfer.getData("text/plain");
            const taskElement = document.querySelector(`#task-${taskId}`);

            if (taskElement) {
                zone.appendChild(taskElement);

                // Obtener el nuevo estado
                const newStatus = zone.dataset.status;

                // Actualizar el estado en la base de datos vía AJAX
                fetch("php_controllers/tareaController.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id_tarea: taskId,
                        nuevo_estado: newStatus,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`Tarea ${taskId} actualizada a estado ${newStatus}`);
                    } else {
                        console.error("Error al actualizar la tarea:", data.message);
                    }
                })
                .catch(err => console.error("Error en la petición AJAX:", err));
            }
        });
    });
});
