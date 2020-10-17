$(function () {
    var pageNum = 1;
    reloadMainTable();
    $(document).on('click', '.btn-table-reload', function () {
        reloadMainTable();
    });
    function reloadMainTable() {
        $url = window.location.pathname + '/ajax/index?page=' + pageNum;
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
