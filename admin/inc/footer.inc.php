<script src="<?= URL_ADMIN ?>/js/jquery.magicsearch.js"></script>
<script src="<?= URL_ADMIN ?>/js/jQuery.tagify.min.js"></script>

<?php
//echo '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">';
echo '</script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>';
echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>';
echo '<script src="' . URL_ADMIN . '/ckeditor/ckeditor.js"></script>';
echo '<script src="' . URL_ADMIN . '/ckeditor/lang/es.js"></script>';
echo '<script src="' . URL_ADMIN . '/js/script.js"></script>';
?>
<div id="moda-page-ajax" class="modal fade zindex_m">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase fs-15"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="contenidoForm">
            </div>
        </div>
    </div>
</div>