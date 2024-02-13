document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const buttonFirmar = document.querySelector("#button1");
    buttonFirmar.addEventListener("click", function (event) {
        Swal.fire('¡Perfecto!', 'Registro actualizado con éxito', 'success').then((result) => {// Envía el formulario después de mostrar la alerta
        })
    });
});