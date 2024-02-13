/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/archivo.js ***!
  \*********************************/
$(document).ready(function () {
  $('#seleccionarTodo').click(function () {
    var isChecked = $('input[type="checkbox"]').not(this).prop('checked');

    // Si todos los checkboxes están marcados
    if (isChecked) {
      // Desmarcar todos los checkboxes
      $('input[type="checkbox"]').not(this).prop('checked', false);
    } else {
      // Marcar todos los checkboxes
      $('input[type="checkbox"]').not(this).prop('checked', true);
    }
  });
});
document.getElementById('boton_excel').addEventListener('click', function (e) {
  var checkboxes = document.querySelectorAll('.checkbox');
  var checked = Array.prototype.slice.call(checkboxes).some(function (x) {
    return x.checked;
  });
  if (!checked) {
    e.preventDefault();
    Swal.fire('Lo sentimos', 'Debes seleccionar al menos un dato', 'error');
  }
});
document.getElementById('boton_pdf').addEventListener('click', function (e) {
  var checkboxes = document.querySelectorAll('.checkbox');
  var checked = Array.prototype.slice.call(checkboxes).some(function (x) {
    return x.checked;
  });
  if (!checked) {
    e.preventDefault();
    Swal.fire('Lo sentimos', 'Debes seleccionar al menos un dato', 'error');
  }
});
/******/ })()
;