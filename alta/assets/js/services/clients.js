
function fil(id) {
    var url = $('#account-form').attr("data-url");
    var fil = $('input[type=file]');
    let formData = new FormData();
    formData.append("id", id);
    for (let i = 0; i < fil.length; i++) {
        for (let j = 0; j < fil[i].files.length; j++) {
            formData.append(fil[i].files[j].name, fil[i].files[j]);
        }
    }
    const API_ENDPOINT = url+"/api/clients/uploadFile.php";
    const request = new XMLHttpRequest();

    request.open("POST", API_ENDPOINT, true);
    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {
            response = request.response;
            data = JSON.parse(response);
            if (data['status']) {
                data['data'].forEach(file => {
                    console.log(file);
                    if (!file['status']) {
                        alertSide(file['message']);
                    } else {
                        //si queres enviar un mensaje de exito
                    }
                });
            } else {
                alertSide(data['message']);
            }
        }
    };

    request.send(formData);
}

function sendEmail(id) {
    var url = $('#account-form').attr("data-url");
    $.ajax({
        url: url + "/api/email/sendClient.php",
        type: "POST",
        data: {id:id},
        success: function (data) {
            console.log(data);
        }
    });
}

function sendAccountRequest() {
    let btn = $('#btn-a-1');
    btn.attr("disabled", true);
    btn.html("");
    btn.addClass("ld-ext-right running");
    btn.append("<div class='ld ld-ring ld-spin'></div>");
    var url = $('#account-form').attr("data-url");
    $.ajax({
        url: url + "/api/clients/create.php",
        type: "POST",
        data: $('#account-form').serialize(),
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data['status']) {
                successSide(data['message']);
                sendEmail(data['id']);
                successSide("Procesando archivos....");
                fil(data['id']);
                $('#account-form').html("");
                $('#account-form').append("<div class='col-md-12'><div class='alert alert-success'>COMPLETADO CORRECTAMENTE!</div></div>");

            } else {
                btn.html("GUARDAR LOS DATOS ");
                btn.removeClass("ld-ext-right running");
                btn.attr("disabled",false);
            }
        }
    });
}

function getStates(from, to) {
    let obj = $('#' + from);
    let state = obj.val();
    let url = $('#account-form').attr("data-url");
    $.ajax({
        url: url + "/api/cities/list.php",
        type: "POST",
        data: {
            state: state
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data['status']) {
                let target = $('#' + to);
                target.html('');
                data['data'].forEach(city => {
                    target.append("<option value='" + city + "'>" + city + "</option>");
                })
            } else {
            }
        }
    });
}