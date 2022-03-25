$(document).ready(function() {

    $('#boton-atender').click(e => {
        const postData = {
            sintomas: $('#sintomas').val(),
            rayos: $('#rayos').val(),
            diagnostico: $('#diagnostico').val(),
            medicina: $('#medicina').val(),
            costo: $('#costo').val(),
        };
        const url = 'atender-perro.php';

        $.ajax({
            url: url,
            data: postData,
            type: 'POST',
            success: function(response) {
                $(location).attr('href','homedoctor.php');
            }
        })
    })

    $('#boton-cancelar').click(e => {
        $(location).attr('href','homedoctor.php');
    })

})