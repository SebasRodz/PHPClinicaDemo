// setInterval(function(){location.reload(true);}, 10000);

$(document).ready(function() {
    $('#boton-cancelar').click(e => {
        $(location).attr('href','home.php');
    })
})