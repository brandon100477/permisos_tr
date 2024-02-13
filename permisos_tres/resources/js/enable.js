$(document).ready(function() {
    $('#seleccionarTodo').click(function() {
        var isChecked = $('input[type="checkbox"]').not(this).prop('checked');
        //Si todos los checkboxes están marcados
        if (isChecked) {
            //Desmarcar todos los checkboxes
            $('input[type="checkbox"]').not(this).prop('checked', false);
        }else{
            //Marcar todos los checkboxes
            $('input[type="checkbox"]').not(this).prop('checked', true);
        }
    });
});

document.getElementById('boton_eliminar').addEventListener('click', function(e) {
    var checkboxes = document.querySelectorAll('.checkbox');
    var checked = Array.prototype.slice.call(checkboxes).some(x => x.checked);
    if (!checked) {
        e.preventDefault();
        Swal.fire('Lo sentimos', 'Debes seleccionar al menos un dato', 'error');
    }else{
        // Lógica para mostrar la alerta de confirmación
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
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Habilitarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    '¡Perfecto!',
                    'El usuario ha sido habilitado',
                    'success'
                );
                setTimeout(function () { form.submit(); }, 1300);
            }
        });
    });
}
$(document).ready(function () {
    $(".eliminar-link").on("click", function (e) {// Agrega un evento de clic al enlace con clase "eliminar-link"
        e.preventDefault(); // Evita que el enlace redireccione automáticamente
        // Muestra una alerta de advertencia
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Habilitarlo',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'confr', // Cambia el color del botón de confirmación
                cancelButton: 'cancel' // Cambia el color del botón de cancelar
            },
        }).then((result) => {
            // Si el usuario confirma la eliminación, redirige al enlace original
            if (result.isConfirmed) {
                Swal.fire(
                    '¡Perfecto!',
                    'El usuario ha sido habilitado',
                    'success'
            )
        setTimeout(( window.location.href = $(this).attr('href')), 2000);};
        }); 
    })
});