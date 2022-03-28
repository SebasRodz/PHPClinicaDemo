$(document).ready(function() {

    const url = "../home-admin/ver-consulta.php";

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
                        <p>` + response_parse[k].sintomas + `</p>
                        <h4>Costo</h4>
                        <p class="text-success">` + response_parse[k].costo + `</p>`;
                    }           
                    $("#table").html(template);
                }
            } else {
                console.log(response);
            }
        }
    })

    $('#boton-aceptar').click(e => {
        const element = $(this)[0].activeElement
        const id = $(element).attr("value");
        if(confirm('¿Estas seguro de aceptar la consulta?')) {
            const url = "eliminar_perro.php";
            const postData = {
                id: id
            }
            $.ajax({
                url: url,
                data: postData,
                type: 'POST',
                success: function(response) {
                    if (!response) {
                        console.log(response);
                    } else {
                        console.log(response);
                        alert("Perro atendido");
                        $(location).attr('href','home.php');
                    }   
                }
            })
        }
    })

    $('#boton-cancelar').click(e => {
        $(location).attr('href','home.php');
    })
})