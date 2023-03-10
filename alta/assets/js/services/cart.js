$('#btn-a-1').attr("disabled", false);

function addToCart() {
    event.preventDefault();
    $("#btn-a-1").hide();
    $('#btn-a').append("<button id='btn-a-2' class='btn ld-ext-right running' disabled><div class='ld ld-ring ld-spin'></div></button>");
    var url = $('#cart-f').attr("data-url") ;

    if ($('#amount').val() != '' && $('#amount').val() > 0) {
        $.ajax({
            url: url + "/api/cart/add.php",
            type: "POST",
            data: $('#cart-f').serialize(),
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data['status'] == true) {
                    document.location.href = url + '/carrito';
                    //$('#modalSP').modal('toggle');
                } else {
                    $('#error').html('');
                    $('#error').append(data['message']);
                    $('#modalEP').modal('toggle');
                    $("#btn-a-1").show();
                    $('#btn-a-2').remove();
                }
            }
        });
    } else {
        $('#error').html('');
        $('#error').append('INGRESE UN VALOR CORRECTO EN CANTIDAD');
        $('#modalEP').modal('toggle');
        $("#btn-a-1").show();
        $('#btn-a-2').remove();
    }
}