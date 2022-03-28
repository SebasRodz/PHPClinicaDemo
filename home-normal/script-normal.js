$(document).ready(function() {

    const url2 = 'consultar_perro.php';
    ajaxfunctions();

    function ajaxfunctions() {
        $.ajax({
            url: url2,
            type: 'GET',
            success: function(response) {
                console.log(response);
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
                                        '<h5 class="pt-2" style="float: left;">Mascota Numero ' + n + '</h5></div>' +
                                        '<div class = "card-body">';
                            template += '<label class="form-label"> Nombre: ' + response_parse[k].nombre + '</label><br>' +
                                    '<label class="form-label"> Raza: ' + response_parse[k].raza + '</label><br>' +
                                    '<label class="form-label"> Genero: ' + response_parse[k].genero + '</label><br>' +
                                    '<label class="form-label"> Fecha de Nacimiento: ' + response_parse[k].fechanac + '</label><br>' +
                                    '<img class="imagen-result mt-2" src="' + response_parse[k].foto + '" alt="Imagen no disponible"><br>';
                                    // '<label class="form-label">' + response_parse[k].Foto + '</label>';
                            if (response_parse[k].consulta == 1) {
                                template += '<div class = "botones mt-1">' + 
                                            '<button value="' + response_parse[k].id + '" name = "' + response_parse[k].nombre + '" type="button" class="consulta btn btn-primary">Comprobar Consulta</button></div>';
                            } else {
                                template += '<div class = "botones mt-1">' + 
                                            '<button type="button" class="btn btn-primary disabled">Sin Consulta</button></div>';
                            }
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

    $(document).on ('click', '#boton-registrar', (e) => {
        const grid = $(".grid-triple");
        var count = $(grid).children().length;
        if (count < 3) {
            $(location).attr('href','registrar_perro.php');
        } else {
            if ($(grid).children().first().attr("id") == "error") {
                $(location).attr('href','registrar_perro.php');
            } else {
                let template = '<small class="color: red; smalling form-text text-muted">Maximo 3 mascotas</small>';
                $("#response").html(template);
                let template2 = '<small class="smalling form-text text-muted">.</small>'
                $("#response2").html(template2);
            }    
        }
    })

    $(document).on ('click', '.consulta', (e) => {
        const element = $(this)[0].activeElement
        const id = $(element).attr("value");
        const name = $(element).attr("name");
        const postData = {
            perro_id: id,
            perro_nombre: name
        };
        const url = '../home-doctor/localizar_perro.php';
        $.ajax({
            url: url,
            data: postData,
            type: 'POST',
            success: function(response) {
                if(!response.error) {
                    $(location).attr('href','comprobar-consulta.php');
                } else {
                    alert(response);
                }
            }
        })
    })

    $("#cerrar-sesion").click(e => {
        $(location).attr('href','../logout.php');
    })
})