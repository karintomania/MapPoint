<turbo-frame id="point-list">
    @foreach($points as $point)
        @include('points._show', ['point' => $point])
    @endforeach
</turbo-frame>
