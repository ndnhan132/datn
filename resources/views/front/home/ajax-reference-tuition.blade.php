<div >
    <div class="reference-tuition-table table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <caption><b>x</b> : Lớp chưa có trong hệ thống</caption>
            <thead>
                <tr>
                    <th>x</th>
                    @foreach ($subjects as $item)
                    <th scope="col" class="text-capitalize text-nowrap">{{ strtolower($item->display_name) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($courseLevels as $lv)
                <tr>
                    <td scope="row" class="text-capitalize">{{ strtolower($lv->display_name) }}</td>
                    @foreach ($subjects as $sub)
                    @php
                        $cou = $courses->where('subject_id', $sub->id)->where('course_level_id', $lv->id)->first();
                        $tuition = 'x';
                        if($cou) {
                            $tuition = $cou->getDisplayTution();
                        }
                    @endphp
                        <td {{ ($tuition == 'x') ? 'class=cell-null' : '' }}>{{ $tuition }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="w-100 d-flex">
    <a href="{{ route('front.getReferenceTuitionPage') }}" class="btn btn-sm btn-primary rounded-pill text-uppercase px-4 ml-auto">Xem thêm</a>
</div>
