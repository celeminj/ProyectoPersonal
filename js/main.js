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
    const tasks = document.querySelectorAll(".item"); // Tareas
    const dropZones = document.querySelectorAll(".droppable"); // Zonas de drop

    tasks.forEach(task => {
        task.addEventListener("dragstart", e => {
            e.dataTransfer.setData("text/plain", e.target.dataset.id);
            e.target.classList.add("dragging");
        });

        task.addEventListener("dragend", e => {
            e.target.classList.remove("dragging");
        });
    });

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

            const taskId = e.dataTransfer.getData("text/plain"); // ID de la tarea
            const taskElement = document.querySelector(`#task-${taskId}`);

            if (taskElement) {
                // Añadir la tarea a la zona de drop
                zone.appendChild(taskElement);

                // Obtener el nuevo estado desde la zona de drop
                const newStatus = zone.dataset.status;

                // Llamar al servidor para actualizar el estado de la tarea
                fetch(`php_controllers/tareaController.php`, {
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
                            throw new Error('Error en la solicitud: ' + response.statusText);
                        }
                        return response.json(); // Suponiendo que devuelves un JSON como respuesta
                    })
                    .then(data => {
                        console.log(data.mensaje); // Mensaje de confirmación del servidor
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setupDragAndDrop(".item", ".droppable", "php_controllers/tareaController.php");
});

