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
        const errorMsg = document.querySelector(`${selector}-error`); // Busca el span basado en el id del input

        if (!input) return;

        const iti = window.intlTelInput(input, {
            initialCountry: "co",
            preferredCountries: ["co", "us", "mx", "es"],
            separateDialCode: true,
            utilsScript: "/js/utils.js", // ojo: asegúrate que existe en public/js
        });

        // Función auxiliar para mostrar/ocultar errores
        const validate = () => {
            input.classList.remove("is-invalid");
            errorMsg.classList.add("d-none");
            errorMsg.innerHTML = "";

            if (input.value.trim()) {
                if (!iti.isValidNumber()) {
                    input.classList.add("is-invalid");
                    errorMsg.innerHTML = "Número de celular no válido para el país seleccionado.";
                    errorMsg.classList.remove("d-none");
                    return false;
                }
            }
            return true;
        };

        // Bloquear letras en tiempo real
        input.addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            // Opcional: Validar mientras escribe o limpiar el error al escribir
            errorMsg.classList.add("d-none");
            input.classList.remove("is-invalid");
        });

        // Validar al salir del campo (Blur)
        input.addEventListener("blur", validate);

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
            setInputLength(iti.getSelectedCountryData().iso2);
            input.value = "";
            validate(); // Limpia errores previos
        });

        // Antes de enviar el formulario -> guardamos en formato internacional
        if (input.form) {
            input.form.addEventListener("submit", function (e) {
                if (!validate()) {
                    e.preventDefault();
                    input.focus(); // Lleva al usuario al campo con error
                } else {
                    // Si todo está bien, guardamos el formato completo (+57310...)
                    input.value = iti.getNumber();
                }
            });
        }
    };
});


// ====================
// Validación Teléfono Fijo
// ====================
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
// function initNitValidation(inputSelector, errorSelector) {
//     // Validación en tiempo real (solo números y máximo 9 caracteres)
//     $(document).on("input", inputSelector, function() {
//         let value = $(this).val();

//         // Eliminar todo lo que no sea número
//         value = value.replace(/\D/g, "");

//         // Limitar a 9 caracteres
//         if (value.length > 10) {
//             value = value.substring(0, 10);
//         }

//         $(this).val(value);
//     });

//     // Validación al salir del campo
//     $(document).on("blur", inputSelector, function() {
//         const value = $(this).val().trim();
//         const errorMsg = $(errorSelector);

//         errorMsg.text("").addClass("d-none");

//         if (!value) return;

//         if (value.length !== 10) {
//             errorMsg.text("El NIT debe tener exactamente 10 dígitos incluyendo el de verificación sin el guión.").removeClass("d-none");

//             setTimeout(() => {
//                 errorMsg.addClass("d-none");
//                 $(this).val(""); // limpiar el campo
//             }, 4000);
//         }
//     });
// }

// En validation.js
function initNitValidation(inputSelector, errorSelector, serverValidationCallback = null) {
    const $input = $(inputSelector);
    const $errorMsg = $(errorSelector);

    // Bloqueo de entrada: solo números y máximo 10
    $(document).on("input", inputSelector, function() {
        this.value = this.value.replace(/\D/g, "");
        if (this.value.length > 10) {
            this.value = this.value.substring(0, 10);
        }
    });

    // Validación al salir del campo
    $(document).on("blur", inputSelector, async function() {
        const value = $input.val().trim();

        // Limpiar estados previos
        $errorMsg.addClass("d-none").text("");
        $input.removeClass("is-invalid is-valid");

        if (!value) return;

        // --- VALIDACIÓN DE FORMATO (Local) ---
        if (value.length !== 10) {
            $errorMsg.text("El NIT debe tener exactamente 10 dígitos.").removeClass("d-none");
            $input.addClass("is-invalid");

            setTimeout(() => {
                $errorMsg.addClass("d-none");
                $input.val("").removeClass("is-invalid");
            }, 4000);
            return; // Detenemos aquí, no llamamos al servidor si el formato es inválido
        }

        // --- VALIDACIÓN DE DISPONIBILIDAD (Servidor) ---
        // Si el formato es correcto y existe un callback (la lógica de la vista), se ejecuta
        if (serverValidationCallback && typeof serverValidationCallback === "function") {
            serverValidationCallback(value, $input, $errorMsg);
        } else {
            // Si no hay callback, simplemente marcamos como válido localmente
            $input.addClass("is-valid");
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
