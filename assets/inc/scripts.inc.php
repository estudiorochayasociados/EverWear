<script src="<?= URL ?>/assets/js/jquery-3.4.0.min.js"></script>
<script src="<?= URL ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= URL ?>/assets/js/owl/owl.carousel.js"></script>
<script src="<?= URL ?>/assets/js/owl/owl.autoplay.js"></script>
<script src="<?= URL ?>/assets/js/owl/owl.navigation.js"></script>
<script src="<?= URL ?>/assets/js/toastr.min.js"></script>
<script src="<?= URL ?>/assets/js/toastr.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    new WOW().init();

    function send(url, data) {
        event.preventDefault();
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(data) {
                console.log(data);
                $('#smsSend').html(data);
            },
            error: function() {

            }
        });
    }


    $('select').selectize();
</script>