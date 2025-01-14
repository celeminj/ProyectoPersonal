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
        const text = textTranslations[0];
        let index = 0;

        const typingInterval = setInterval(() => {
            animatedText.textContent += text[index];
            index++;

            if (index === text.length) {
                clearInterval(typingInterval);
            }
        }, 100);
    }

    typeText();
});

/**
 * Para arrastrar las tareas de proceso a revision y terminado
 */
// DRAG AND DROP 
function setupDragAndDrop(taskSelector, dropZoneSelector) {
    const tasks = document.querySelectorAll(taskSelector); // Selección de tareas
    const dropZones = document.querySelectorAll(dropZoneSelector); // Selección de zonas de drop


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

            const taskId = e.dataTransfer.getData("text/plain"); // ID de la tarea arrastrada
            const task = document.querySelector(`#task-${taskId}`);
            const currentZone = task.closest(dropZoneSelector); // Zona actual de la tarea

            if (currentZone && currentZone.dataset.status === "3" && zone !== currentZone) {
                window.alert("No puedes mover tareas fuera de 'Acabado'.");
                return;
            }

            if (task) {
                zone.appendChild(task);
                console.log("Tarea movida");
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setupDragAndDrop(".item", ".droppable", "php_controllers/tareaController.php");
});
