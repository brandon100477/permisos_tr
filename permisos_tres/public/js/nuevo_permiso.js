/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/nuevo_permiso.js ***!
  \***************************************/
document.addEventListener("DOMContentLoaded", function () {
  var form = document.querySelector("form");
  var buttonFirmar = document.querySelector("#button1");
  buttonFirmar.addEventListener("click", function (event) {
    Swal.fire('¡Perfecto!', 'Registro actualizado con éxito', 'success').then(function (result) {// Envía el formulario después de mostrar la alerta
    });
  });
});
/******/ })()
;