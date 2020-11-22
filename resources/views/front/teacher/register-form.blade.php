<div class="mainbox">
    <form id="teacher-register-form" method="post">
        @csrf
        <div class="form-alert">
        </div>





















        <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Lưu</a>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).on('click', 'form#teacher-register-form .btn-submit', function(event) {
        event.preventDefault();
        var formData = $('#teacher-register-form').serialize()
        $.ajax({
            url: '/front/ajax/teacher/store',
            type: 'POST',
            dataType: 'json',
            data: formData,
        })
        .done(function(data) {
          alert(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          console.log("error");
        })
        .always(function(data, textStatus,errorThrown ) {
            console.log("complete");
        });
    });
</script>
