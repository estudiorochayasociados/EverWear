$('table').addClass("table-hover");
$('input[type=text]').addClass("form-control");
$('input[type=date]').addClass("form-control");
$('input[type=url]').addClass("form-control");
$('input[type=number]').addClass("form-control");
$('select').addClass("form-control");
$('textarea').addClass("form-control");

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})

$('.btn-danger').on("click", function (e) {
    e.preventDefault();
    var choice = confirm("Â¿EstÃ¡s seguro de eliminar?");
    if (choice) {
        window.location.href = $(this).attr('href');
    }
});
$(".ckeditorTextarea").each(function () {
    CKEDITOR.replace(this, {
        customConfig: 'config.js',
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
});
$(document).ready(function () {
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function agregar_input(div, name) {
    var cod = 1 + Math.floor(Math.random() * 999999);
    $('#' + div).append('<div class="col-md-12 input-group" id="' + cod + '"><input onkeydown="return (event.keyCode!=13);" type="text" class="form-control mb-10 mr-10" name="' + name + '[' + cod + '][atributo]"><input id="tg' + cod + '" onkeydown="return (event.keyCode!=13);" type="text" class="form-control mb-10 mr-10" name="' + name + '[' + cod + '][valores]"></div>');
    $('#' + cod).append(' <div class="input-group-addon"><a href="#" onclick="$(\'#' + cod + '\').remove()" class="btn btn-primary"> <i class="fas fa-minus"></i> </a> </div>');
    $('#tg' + cod).tagify();
}


function agregar_atributo(div) {
    var cod = 1 + Math.floor(Math.random() * 999999);
    $('#' + div).append('<div class="input-group" id="' + cod + '"><input onkeydown="return (event.keyCode!=13);" type="text" class="form-control mb-10 mr-10" name="atributo[]"></div>');
    $('#' + cod).append(' <div class="input-group-addon"><a href="#" onclick="$(\'#' + cod + '\').remove()" class="btn btn-primary"> <i class="fas fa-minus"></i> </a> </div>');
}


function AgregarCombinacion(id, destino, total) {
    if ($('[id=combinaciones]').length <= total - 1) {
        $random = Math.floor((Math.random() * 1000) + 1);

        var newItem = $("#" + id).clone();
        newItem.find("input[name]").each(function () {
            var nameCurrent = $(this).attr("name");
            nameCurrent = nameCurrent.slice(0, -1);
            $(this).attr("name", nameCurrent + $random + "]");
        });
        newItem.find("select option").each(function () {
            $(this).removeAttr("selected");
        });
        newItem.find("select").each(function () {
            $(this).children().each(function (key, value) {
                if (key == 0) {
                    $(this).attr("selected", "selected");
                }
                console.log(key + '-' + value);
            });
        });
        newItem.find("input[value]").each(function () {
            $(this).attr("value", 0);
        });
        newItem.appendTo("#" + destino);
    }
}

function _ajax(params, url, type) {
    $.ajax({
        url: url,
        type: type,
        data: { params },
        success: function (data) {
            return data;
        }
    });
}

$('.modal-page-ajax').click(function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var titulo = $(this).attr('data-title');
    $('#contenidoForm').load(url, function (result) {
        $('#moda-page-ajax').modal('show');
        $('.modal-title').html(titulo);
        e.preventDefault();
    })
});


function openModal(url, titulo) {
    $('#contenidoForm').load(url, function (result) {
        $('#moda-page-ajax').modal('show');
        $('.modal-title').html(titulo);
        e.preventDefault();
    })
};


function edit(url, db, attr, cod) {
    event.preventDefault();
    $.ajax({
        url: url + '/api/public/edit.php',
        type: "POST",
        data: {
            db: db,
            attr: attr,
            value: $("#" + cod).val(),
            cod: cod
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data["status"]) {
                successMessage("Actualizado correctamente");
            } else {
                errorMessage("Error al actualizar");
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
}