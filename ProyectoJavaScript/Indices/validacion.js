function validar(form) {
    let msg = "";
    
    // El nombre debe ser mayor a 5 caracteres y menor a 50
    if((form.nombre.value.length > 50) || (form.nombre.value.length < 5)) {
        msg = "Proporcione un Nombre válido";
    }

    // El apellido debe ser mayor a 5 caracteres y menor a 50
    if((form.apellido.value.length > 50) || (form.apellido.value.length < 5)) {
        msg = "Proporcione un Apellido válido";
    }

    // El username debe ser mayor a 5 caracteres y menor a 50
    if((form.username.value.length > 50) || (form.username.value.length < 5)) {
        msg = "Proporcione un Nombre de Usuario válido";
    }

    // Debe ser mayor a 10 años y menor a 100
    if((form.edad.value > 100) || (form.edad.value < 10) || isNaN(form.edad.value)) {
        msg = "Proporcione una Edad válida";
    }

    // Que la contraseña contenga al menos 5 caracteres y menos de 20
    if((form.password.value.length > 20) || (form.password.value.length < 5)) {
        msg = "Proporcione una Contraseña válida (Entre 5 y 20 caracteres)";
    }

    // Verificar el email con una expresión regular
    var ercorreo = /^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/;
    if (!(ercorreo.test(form.email.value))) {
        msg = "Proporcione una Dirección de Correo Electrónico válida";
    }

    // Verificar el telefono con una expresión regular
    var tlf = /^\d{10}$/;
    if (!(tlf.test(form.telefono.value))) {
        msg = "Proporcione un Teléfono válido";
    }

    // Mostrar la alerta
    if (msg != "") {
        window.alert(msg);
        return false;
    } else {
        alert("Bienvenido a Tenis OSWI");
        return true;
    }
}
