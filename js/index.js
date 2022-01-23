// Script a ejecutar cuando los elementos del DOM se hayan cargado.
$(document).ready(function(){

    // Defino la URL dónde se buscaran los datos de precios de los servicios.
    const URL_JSON = '../data/data.json'

    // Busco los datos en la URL.
    $.getJSON(URL_JSON, function(respuesta, estado) {

        // Si pudo realizarse la conexión correctamente.
        if (estado === 'success') {
            
            // Renderizo los precios en la sección correspondiente.
            for (element of respuesta) {
                let test = $(`#${element.servicio}`)[0];
                test.innerHTML = element.precio;
            };

        };

    });

});