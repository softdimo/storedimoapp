// js.js

$(document).ready(function () {
    

    // Abrir el calendario desde el ícono
    $('.input-group-text').on('click', function () {
        const input = $(this).siblings('input[type="date"]');
        input.trigger('focus');
        if (typeof input[0].showPicker === "function") {
            input[0].showPicker();
        }
    });
}); // FIN document.ready

// ===================================================================

// Función global para mostrar nombre de archivo seleccionado y la imagen del logo
function displaySelectedFile(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    preview.innerHTML = '';
    preview.classList.add('hidden');

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const fileName = file.name;
    const extension = fileName.split('.').pop().toLowerCase();

    const allowedExtensions = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'];
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

    if (!allowedExtensions.includes(extension)) {
        input.value = ''; // Limpiar el input
        preview.textContent = 'Tipo de archivo no permitido. Solo se permiten: ' + allowedExtensions.join(', ');
        preview.classList.remove('hidden');
        return;
    }

    if (imageExtensions.includes(extension)) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Vista previa" class="img-thumbnail mt-2" style="max-width: 40px; max-height: 40px;">
                <span class="text-muted ms-2">${fileName}</span>
            `;
        };
        reader.readAsDataURL(file);
    } else if (extension === 'pdf') {
        const pdfIcon = "/img/pdf-icon.png"; // Asegúrate que exista en public/images
        preview.innerHTML = `
            <img src="${pdfIcon}" alt="Archivo PDF" class="mt-2" style="max-width: 40px; max-height: 40px;">
            <span class="text-muted ms-2">${fileName}</span>
        `;
    } else {
        preview.innerHTML = `<span class="text-muted mt-2">${fileName}</span>`;
    }

    preview.classList.remove('hidden');
}
