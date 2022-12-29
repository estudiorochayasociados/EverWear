var start = 0;
var limit = 24;
var order = '';
const url = location.origin + "/muaa";

$(document).ready(() => {
    getData();
});

function orderBy(value) {
    order = value;
    getData();
}

function loadMore() {
    disableLoadMore();
    start += limit;
    getData('add');
}

function disableLoadMore() {
    $('#grid-products-btn').hide();
}

function enableLoadMore() {
    $('#grid-products-btn').show();
}

function getData(type) {
    let list = type != 'add' ? true : false;

    if (url) {
        if (list) {
            loader();
            start = 0;
            enableLoadMore();
        }
        $.ajax({
            url: url + "/api/products/list.php?start=" + start + "&limit=" + limit + "&order=" + order,
            type: "POST",
            data: $('#filter-form').serialize(),
            success: (data) => {
                list ? reset() : enableLoadMore();
                if (!data.length) disableLoadMore();
                $('#grid-products').append(data);
                if ($('#grid-products ').children().size() < limit) disableLoadMore();
            }
        });
    }
}

function appendProducts(data) {
    if (Array.isArray(data)) {
        if (data.length < limit) {
            disableLoadMore();
        }

    } else {
        /*notFound();*/
    }
}

function loader() {
    reset();
    $('#grid-products').append("" +
        "<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>" +
        "    <div class='product-wrap mb-10 mt-100 mb-400'>" +
        "        <div class='product-content text-center'>" +
        "            <i class='fa fa-circle-o-notch fa-spin fa-3x fs-70'></i>" +
        "        </div>" +
        "    </div>" +
        "</div>"
    );
}

function notFound() {
    reset();
    $('#grid-products').append("" +
        "<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>" +
        "    <div class='product-wrap mb-35'>" +
        "        <div class='product-content text-center'>" +
        "            <i class='fa fa-times-circle fs-100' style='color: red'></i>" +
        "            <h4>No se encontró ningun producto con esas características.</h4>" +
        "        </div>" +
        "    </div>" +
        "</div>"
    );
    disableLoadMore();
}

function reset() {
    $('#grid-products').html('');
}