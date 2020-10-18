$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(function () {
    var pageNum = 1;
    var pathName = window.location.pathname;
    reloadMainTable();
    $(document).on('click', '.btn-table-reload', function () {
        reloadMainTable();
    });
    function reloadMainTable() {
        $url =  pathName + '/ajax/index?page=' + pageNum;
        $('#content-table').load($url, function () {
            console.log('load Index');
        });
    }
    function setPageNum(num) {
        pageNum = num;
    }

    $(document).on('click', '.pagination-item', function () {
        setPageNum($(this).data('pagenum'));
        reloadMainTable();
    });

});

// $.ajax({
//   url: '/',
//   type: 'POST',
//   dataType: 'json',
//   data: {param1: 'value1'},
// })
// .done(function(data) {
//   console.log("success");
// })
// .fail(function(jqXHR, textStatus, errorThrown) {
//   console.log("error");
// })
// .always(function(data|jqXHR, textStatus, jqXHR|errorThrown ) {
//   console.log("complete");
// });
