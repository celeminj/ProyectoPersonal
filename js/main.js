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
function setupDragAndDrop(taskSelector, dropZoneSelector, apiEndpoint) {
    const tasks = document.querySelectorAll(taskSelector); // Selección de tareas
    const dropZones = document.querySelectorAll(dropZoneSelector); // Selección de zonas de drop

    // Configuración de eventos para tareas
    tasks.forEach(task => {
        task.addEventListener("dragstart", e => {
            e.dataTransfer.setData("text/plain", e.target.dataset.id);
            e.target.classList.add("dragging");
        });

        task.addEventListener("dragend", e => {
            e.target.classList.remove("dragging");
        });
    });

    // Configuración de eventos para zonas de drop
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

            const taskId = e.dataTransfer.getData("text/plain"); // ID de la tarea arrastrada
            const taskElement = document.querySelector(`#task-${taskId}`);

            if (taskElement) {
                // Mover tarea al nuevo contenedor
                zone.appendChild(taskElement);

                // Obtener el nuevo estado desde la zona de drop
                const newStatus = zone.dataset.status;

                // Enviar actualización al servidor
                fetch(apiEndpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id_tarea: taskId,
                        nuevo_estado: newStatus
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error en la solicitud: ${response.statusText}`);
                        }
                        return response.json(); // Suponiendo que el servidor devuelve un JSON
                    })
                    .then(data => {
                        if (data.success) {
                            console.log(data.mensaje || "Tarea actualizada con éxito");
                        } else {
                            console.error(data.error || "Error al actualizar la tarea");
                        }
                    })
                    .catch(error => {
                        console.error("Error al conectar con el servidor:", error);
                        alert("Hubo un problema al actualizar el estado de la tarea. Inténtalo nuevamente.");
                    });
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setupDragAndDrop(".item", ".droppable", "php_controllers/tareaController.php");
});
