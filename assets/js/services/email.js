function send(url, data) {
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        success: function (data) {
            console.log(data);

        },
        error: function () {

        }
    });
}