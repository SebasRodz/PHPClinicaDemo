$(document).ready(function() {

    const url = "ver-consulta.php";

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if(!response.error) {
                let template = '';
                if (!response) {
                    let template_error = '<p style="text-align: center;">Ha ocurrido un error</p>';
                    $("#table").html(template_error);
                } else {
                    let response_parse = JSON.parse(response);
                    for (var k in response_parse) {
                        template += `<h4>Medicina</h4>
                        <p>` + response_parse[k].medicina + `</p>
                        <h4>Prueba de Sangre</h4
                        <p>` + response_parse[k].prueba_sangre + `</p>
                        <h4>Rayos X</h4>
                        <p>` + response_parse[k].rayosx + `</p>
                        <h4>Sintomas</h4>
                        <p>` + response_parse[k].sintomas + `</p>`;
                    }           
                    $("#table").html(template);
                }
            } else {
                console.log(response);
            }
        }
    })

    $('#boton-cancelar').click(e => {
        $(location).attr('href','homeadmin.php');
    })
})