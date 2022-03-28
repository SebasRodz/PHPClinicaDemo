$(document).ready(function() {

    const url = "observar-consulta.php";

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
                    // let response_parse = JSON.parse(response);
                    // for (var k in response_parse) {
                    //     template += `<thead>
                    //     <tr>
                    //         <th scope="col">Sintomas</th>
                    //         <tbody>
                    //     <tr class="table-active">
                    //         <th scope="row">Active</th>
                    //         <td>`+ response_parse[k].sintomas +`</td>
                    //     </tr>
                    //     </thead>`;
                    // }           
                    // $("#table").html(template);
                    let response_parse = JSON.parse(response);
                    console.log(response_parse);
                }
            } else {
                console.log(response);
            }
        }
    })
})