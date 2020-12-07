$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Login Page Flipbox control
    // $('.login-content [data-toggle="flip"]').click(function() {
    //     $('.login-box').toggleClass('flipped');
    //     return false;
    // });
    $('.login-content .login-box .forget-form button[type="submit"]').on('click', function(event) {
        event.preventDefault();
        var fData = $('.login-content .login-box form.forget-form').serialize();
        $.ajax({
            url: '/quan-ly/ajax/users/forget-password',
            type: 'POST',
            dataType: 'json',
            data: fData,
          })
          .done(function(data) {
            if(data.success){
                swal({
                    title: "Check Your Email To Reset Password",
                    type: "success",
                    timer: 10000,
                    // showCancelButton: false,
                    showConfirmButton: false,
                });
            } else {
                console.log(typeof data.message);
                console.log($.isEmptyObject(data.message));
                if (typeof data.message != "undefined" && !$.isEmptyObject(data.message)) {
                    console.log(data.message);
                    printAjaxOrderErrorMsg(data.message);
                }
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            msgErrors();
          });
    });
    $('.login-content .login-box .login-form button[type="submit"]').on('click', function(event) {
        event.preventDefault();
        var fData = $('.login-content .login-box form.login-form').serialize();
        $.ajax({
            url: '/quan-ly/ajax/users/login',
            type: 'POST',
            dataType: 'json',
            data: fData,
          })
            .done(function (data) {
              console.log(data);
            if(data.success){
                Swal.fire({
                    // position: 'top-end',
                    icon: 'success',
                    title: 'Đăng nhập thành công!',
                    showConfirmButton: false,
                    timer: 1500
                });
                  location.reload();
            }else{
                if(typeof data.message != "undefined" && !$.isEmptyObject(data.message)){
                    printAjaxOrderErrorMsg(data.message);
                }
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            msgErrors();
          });
    });
    function printAjaxOrderErrorMsg (msg) {
        $element = $(document).find("#print-error-msg");
        $element.html('');
        $element.css('display','block');
        $.each( msg, function( key, value ) {
            alertHtml = '<div class = "alert alert-danger" style = "float: left;width: calc(100% - 0px);margin-left: 0px;">' +
                ' <i class = "fa fa-exclamation-circle"> </i>' +
                ' Warning: ' + value + '<button type="extutton" class="close" data-dismiss="alert">×</button >'
            '</div>';
            $element.append(alertHtml);
        });
        $('#js-modal-errors').modal('show');
    }
    function msgErrors() {
        Swal.fire({
            title: "Successfully",
            type: "danger",
            timer: 1500,
            showCancelButton: false,
            showConfirmButton: false,
        });
    }
    function msgSuccess() {
        Swal.fire({
            title: "Successfully",
            type: "success",
            timer: 1500,
            showCancelButton: false,
            showConfirmButton: false,
        });
    }
});
