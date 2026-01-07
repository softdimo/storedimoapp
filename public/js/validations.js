// ====================
// Validación Cecular con intlTelInput
// ====================
document.addEventListener("DOMContentLoaded", function () {
    /**
     * Inicializa el plugin intlTelInput en un input específico
     * @param {string} selector - Selector CSS del input (ej: "#celular")
     */
    window.initIntlPhone = function (selector) {
        const input = document.querySelector(selector);

        if (!input) return;

        const iti = window.intlTelInput(input, {
            initialCountry: "co",
            preferredCountries: ["co", "us", "mx", "es"],
            separateDialCode: true,
            utilsScript: "/js/utils.js", // ojo: asegúrate que existe en public/js
        });

        // Longitudes por país (ISO2 -> [min, max])
        const phoneLengths = {
            co: [10, 10], // Colombia
            us: [10, 10], // USA
            mx: [10, 10], // México
            es: [9, 9],   // España
        };

        function setInputLength(countryCode) {
            const lengths = phoneLengths[countryCode] || [7, 15]; // default
            input.setAttribute("minlength", lengths[0]);
            input.setAttribute("maxlength", lengths[1]);
        }

        // Inicializar con el país actual
        setInputLength(iti.getSelectedCountryData().iso2);

        // Cuando cambie el país
        input.addEventListener("countrychange", function () {
            const countryCode = iti.getSelectedCountryData().iso2;
            setInputLength(countryCode);
            input.value = ""; // opcional: limpiar
        });

        // Antes de enviar el formulario -> guardamos en formato internacional
        if (input.form) {
            input.form.addEventListener("submit", function () {
                input.value = iti.getNumber();
            });
        }
    };
});


// ====================
// Validación Teléfono Fijo
// ====================
// function initPhoneValidation(inputSelector, errorSelector) {
//     $(document).on("blur", inputSelector, function() {
//         const value = $(this).val().trim();
//         const errorMsg = $(errorSelector);

//         errorMsg.text("").addClass("d-none");

//         if (!value) return;

//         if (!/^\d*$/.test(value)) {
//             errorMsg.text("Solo se permiten números.").removeClass("d-none");
//         } else if (!value.startsWith("60")) {
//             errorMsg.text("El número debe iniciar con 60.").removeClass("d-none");
//         } else if (value.length < 7 || value.length > 10) {
//             errorMsg.text("El número debe tener entre 7 y 10 dígitos.").removeClass("d-none");
//         }

//         if (!errorMsg.hasClass("d-none")) {
//             setTimeout(() => {
//                 errorMsg.addClass("d-none");
//                 $(this).val(""); //Se limpia el campo del teléfono cuando hay error
//             }, 4000);
//         }
//     });
// }

function initPhoneValidation(inputSelector, errorSelector) {
    // 1. Bloqueo de entrada en tiempo real (solo números)
    $(document).on("input", inputSelector, function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // 2. Validación al salir del campo (blur)
    $(document).on("blur", inputSelector, function() {
        const $input = $(this);
        const value = $input.val().trim();
        const $errorMsg = $(errorSelector);

        // Limpiar estado previo
        $errorMsg.text("").addClass("d-none");

        if (!value) return;

        let mensaje = "";

        // Validaciones en orden de importancia
        if (!value.startsWith("60")) {
            mensaje = "El número telefónico fijo debe iniciar con 60.";
        } else if (value.length < 10) { 
            // Nota: En Colombia, los fijos con el indicativo 60 ahora siempre son de 10 dígitos
            mensaje = "El número debe tener 10 dígitos (ej: 6012345678).";
        }

        if (mensaje !== "") {
            $errorMsg.text(mensaje).removeClass("d-none");
            
            // En lugar de borrar de inmediato, resaltamos el error
            $input.addClass("is-invalid");

            setTimeout(() => {
                $errorMsg.fadeOut(500, function() {
                    $(this).addClass("d-none").show();
                    $input.val("").removeClass("is-invalid"); 
                });
            }, 4000);
        } else {
            $input.removeClass("is-invalid").addClass("is-valid");
        }
    });
}

// ====================
// Validación NIT (9 dígitos exactos, solo números)
// ====================
function initNitValidation(inputSelector, errorSelector) {
    // Validación en tiempo real (solo números y máximo 9 caracteres)
    $(document).on("input", inputSelector, function() {
        let value = $(this).val();

        // Eliminar todo lo que no sea número
        value = value.replace(/\D/g, "");

        // Limitar a 9 caracteres
        if (value.length > 9) {
            value = value.substring(0, 9);
        }

        $(this).val(value);
    });

    // Validación al salir del campo
    $(document).on("blur", inputSelector, function() {
        const value = $(this).val().trim();
        const errorMsg = $(errorSelector);

        errorMsg.text("").addClass("d-none");

        if (!value) return;

        if (value.length !== 9) {
            errorMsg.text("El NIT debe tener exactamente 9 dígitos.").removeClass("d-none");

            setTimeout(() => {
                errorMsg.addClass("d-none");
                $(this).val(""); // limpiar el campo
            }, 4000);
        }
    });
}

// Validar correo electrónico
function validarEmail(input) {
    const email = input.value.trim();
    const errorSpan = document.getElementById("error_email");

    // Expresión regular básica para emails
    const regex = /^[a-zA-Z0-9]+([._%+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)*\.[a-zA-Z]{2,}$/;

    if (email === "") {
        errorSpan.textContent = "El correo electrónico es obligatorio.";
        input.classList.add("is-invalid");
    } else if (!regex.test(email)) {
        errorSpan.textContent = "Por favor ingresa un correo electrónico válido.";
        input.classList.add("is-invalid");
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
    }
}


// Función para validar email
function initEmailValidation(inputSelector, errorSelector) {
    $(document).on("input blur", inputSelector, function () {
        const value = $(this).val().trim();
        const errorMsg = $(errorSelector);

        // Expresión regular mejorada
        const regex = /^[a-zA-Z0-9]+([._%+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)*\.[a-zA-Z]{2,}$/;

        errorMsg.text("").addClass("d-none");

        if (value === "") {
            errorMsg.text("El correo electrónico es obligatorio.")
                .removeClass("d-none");

            setTimeout(() => {
                errorMsg.addClass("d-none");
                $(this).val(""); 
            }, 4000);
            return; // detenemos aquí
        }

        if (!regex.test(value)) {
            errorMsg.text("Por favor, ingresa un correo electrónico válido.")
                .removeClass("d-none");

            setTimeout(() => {
                errorMsg.addClass("d-none");
                $(this).val(""); 
            }, 4000);
        }
    });
}



