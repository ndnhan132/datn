@isset($title)
    <div class="d-flex py-2 text-primary">
        <i class="{{ $icon ?? 'fab fa-battle-net'}} fa-2x p-2"></i>
        <h4 class="text-uppercase font-weight-normal border-bottom border-primary col mb-auto">
            {{ $title }}
        </h4>
    </div>
@endisset
