
    @php
    $fields = array(
        [
            'label'       => 'Hon ten',
            'name'        => 'fullname',
        ],
        [
            'label'       => 'dia chi',
            'name'        => 'address',
        ],
        [
            'label'       => 'dien thoai',
            'name'        => 'phone',
        ],
        // [
        //     'label'       => 'email',
        //     'name'        => 'email',
        // ],
        // [
        //     'label'       => 'thoi gian',
        //     'name'        => 'time_working',
        // ],
        // [
        //     'label'       => 'so hoc sinh',
        //     'name'        => 'fullname',
        // ],
        // [
        //     'label'       => 'so buoi',
        //     'name'        => 'fullname',
        // ],
        // [
        //     'label'       => 'Hon ten',
        //     'name'        => 'fullname',
        // ],
        // [
        //     'label'       => 'hoc phi',
        //     'name'        => 'fullname',
        // ],
        // [
        //     'label'       => 'yeu cau khac',
        //     'name'        => 'fullname',
        // ],
    );
    @endphp

<div class="border px-4">
<h1 class="w-100 text-center">Dang ky</h1>
<form id="course-register-form" method="post">
    @csrf
    @foreach ($fields as $item)
    <div class="form-group row">
    <label class="col-sm-2 col-form-label text-capitalize">{{ $item['label'] }}</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" name="{{ $item['name'] }}">
        </div>
    </div>
    @endforeach
    <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary submit">Dang ky</button>
        </div>
      </div>
</form>
</div>
