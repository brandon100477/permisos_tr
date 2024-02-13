$("#loginForm").on("submit", function (e) {
    e.preventDefault();
    if (working) return;
    working = true;
    var $this = $(this);
    var $state = $this.find("button > .state");
    $this.addClass("loading");
    $state.html("Authenticating");
    var formData = $this.serialize();// Se obtienen los datos del formulario
    // Envía una solicitud POST al servidor para autenticar al usuario
    $.post($this.attr('action'), formData, function (response) {
        if (response.success) {
            // La autenticación fue exitosa
            $this.addClass("ok");
            $state.html("Welcome back!");
            // Redirige al usuario a la página de inicio o realiza alguna acción adicional
            window.location.href = "/dashboard";
        } else {
            // La autenticación falló
            $state.html("Log in");
            $this.removeClass("ok loading");
            working = false;
            // Muestra un mensaje de error al usuario
            alert("Credenciales incorrectas. Por favor, inténtelo de nuevo.");
        }
    }, 'json');
});

