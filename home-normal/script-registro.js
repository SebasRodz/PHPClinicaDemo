// setInterval(function(){location.reload(true);}, 10000);

$(document).ready(function() {

    $('#boton-registrar').click(e => {
        const postData = {
            codigo: $('#codigo').val(),
            nombre: $('#nombre').val(),
            fecha: $('#fecha').val(),
            genero: $('.checked-reg:checked').val(),
            raza: $('#select-gen').val(),
            imagen: $('#imagen').val()
        };
        const url = 'registrar_perro.php';
        // console.log(postData, url);

        $.ajax({
            url: url,
            data: postData,
            type: 'POST',
            success: function(response) {
                $(location).attr('href','home.php');
            }
        })
    })

    $('#boton-cancelar').click(e => {
        $(location).attr('href','home.php');
    })
})