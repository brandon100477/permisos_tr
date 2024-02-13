document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
  
    form.addEventListener("submit", function (event) {
        // Verificar que todos los campos requeridos estén llenos
        const camposRequeridos = ['hora_inicio', 'hora_fin', 'fecha_inicio', 'fecha_fin', 'permiso', 'adicional', 'observaciones', 'firma_jefe'];
        let todosLlenos = true;
  
        camposRequeridos.forEach(function(campo) {
            const input = form.elements[campo];
            if (!input.value) {
                todosLlenos = false;
                input.focus();
                Swal.fire('Lo sentimos', 'Parece que faltan campos por ingresar', 'error');
                return false;
            }
        });
  
        // Si todos los campos requeridos están llenos, permitir el envío del formulario
        if (todosLlenos) {
            mostrarAlerta();
            const buttonAprobar = document.getElementById("button2");
            const buttonRechazar = document.getElementById("button3");
            buttonAprobar.addEventListener("click", function (event) {
                event.preventDefault();
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'submit_action';
                input.value = 'aprobar';
                form.appendChild(input);
            });
            buttonRechazar.addEventListener("click", function (event) {
                event.preventDefault();
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'submit_action';
                input.value = 'rechazar';
                form.appendChild(input);
            });
        } else {
            // Si algún campo requerido no está lleno, prevenir el envío del formulario
            event.preventDefault();
        }
    });
 });
 
 async function mostrarAlerta() {
    await Swal.fire({
        title: '¡Perfecto!',
        text: 'Registro actualizado con éxito',
        icon: 'success',
        timer: 5000,
        allowOutsideClick: false
    });
 }