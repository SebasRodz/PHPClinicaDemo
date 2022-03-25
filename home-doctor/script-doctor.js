$(document).ready(function() {

    ajaxFunction();

    function ajaxFunction() {
        const url = "listar-perros.php";

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if(!response.error) {
                    let template = '';
                    if (!response) {
                        let template_error = '<div id="error"></div>' +
                                            '<div style = "text-align: center;"><p>No hay nada para mostrar</p></div>' +
                                            '<div></div>';
                        $("#grid-triple").html(template_error);
                        perros = [];
                    } else {
                        let response_parse = JSON.parse(response);
                        let n;
                        perros = [];
                        for (var k in response_parse) {
                            n = parseInt(k);
                            n += 1;
                            template += '<div class="card mb-3"><div class = "card-header">' +
                                        '<h5 class="pt-2" style="float: left;">Mascota Numero ' + n + '</h5>' +
                                        '<button id="' + response_parse[k].id + '" name="' + response_parse[k].nombre + '" type="button" class="atender btn btn-primary" style="float: right;">Atender</button></div>' +
                                        '<div class = "card-body">';
                            template += '<label class="form-label"> Nombre: ' + response_parse[k].nombre + '</label><br>' +
                                    '<label class="form-label"> Raza: ' + response_parse[k].raza + '</label><br>' +
                                    '<label class="form-label"> Genero: ' + response_parse[k].genero + '</label><br>' +
                                    '<label class="form-label"> Fecha de Nacimiento: ' + response_parse[k].fechanac + '</label><br>' +
                                    '<img class="imagen-result mt-2" src="' + response_parse[k].foto + '" alt="Imagen no disponible"><br><br>';
                                    // '<label class="form-label">' + response_parse[k].Foto + '</label>';
                            template += '</div></div>';
                        }           
                        $("#grid-triple").html(template);
                    }
                } else {
                    console.log(response);
                }
            }
        })
    }

    $(document).on ('click', '.atender', (e) => {
        if(confirm('¿Estas seguro de atender a esta mascota?')) {
            const element = $(this)[0].activeElement
            const id = $(element).attr("id");
            const nombre = $(element).attr("name");
            // console.log(id);
            const postData = {
                perro_id: id,
                perro_nombre: nombre
            };
            const url = 'localizar_perro.php';
            $.ajax({
                url: url,
                data: postData,
                type: 'POST',
                success: function(response) {
                    if(!response.error) {
                        $(location).attr('href','atender-perro.php');
                    } else {
                        alert(response);
                    }
                }
            })
        }
    })

    $("#cerrar-sesion").click(e => {
        $(location).attr('href','../logout.php');
    })
})