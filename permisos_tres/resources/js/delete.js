$(document).ready(function() {
    $('#seleccionarTodo').click(function() {
        var isChecked = $('input[type="checkbox"]').not(this).prop('checked');
        if (isChecked) {// Si todos los checkboxes están marcados
            $('input[type="checkbox"]').not(this).prop('checked', false);// Desmarcar todos los checkboxes
        }else{
            $('input[type="checkbox"]').not(this).prop('checked', true);// Marcar todos los checkboxes
        }
    });
});

document.getElementById('boton_eliminar').addEventListener('click', function(e) {
    var checkboxes = document.querySelectorAll('.checkbox');
    var checked = Array.prototype.slice.call(checkboxes).some(x => x.checked);
    if (!checked) {
        e.preventDefault();
        Swal.fire('Lo sentimos', 'Debes seleccionar al menos un dato', 'error');
    } else {
        // Lógica para mostrar la alerta
        e.preventDefault();
        mostrarAlertaConfirmacion();
    }
});
function mostrarAlertaConfirmacion() {
    document.querySelector('#boton_eliminar').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the form from submitting
        var form = document.querySelector('#bin');
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#30d636',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    '¡Borrado!',
                    'El registro ha sido eliminado',
                    'success'
                );
                setTimeout(function () { form.submit(); }, 1300);
            }
        });
    });
}
$(document).ready(function () {
    // Agrega un evento de clic al enlace con clase "eliminar-link"
    $(".eliminar-link").on("click", function (e) {
        e.preventDefault(); // Evita que el enlace redireccione automáticamente
        Swal.fire({// Muestra una alerta de advertencia
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6347', 
            cancelButtonColor: '#5f9ea0',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {// Si el usuario confirma la eliminación, redirige al enlace original
                Swal.fire(
                    '¡Borrado!',
                    'El registro ha sido eliminado',
                    'success'
                )
            setTimeout(( window.location.href = $(this).attr('href')), 2000);};
        });
    })
});