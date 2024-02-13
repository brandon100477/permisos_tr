async function mostrarAlerta() {
  await Swal.fire('¡Perfecto!', 'Registro actualizado con éxito', 'success');}
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  form.addEventListener("submit", async function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente
      await mostrarAlerta(); // Muestra la alerta y espera a que se cierre
      form.submit(); // Envía el formulario después de mostrar la alerta
  });
});