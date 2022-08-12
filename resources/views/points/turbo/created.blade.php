{{-- append created point --}}
<x-turbo-stream target="point-list" action="prepend">
    @include('points._show', ['point' => $point])
</x-turbo-stream>

{{-- reset create form --}}
<x-turbo-stream target="point-create" action="replace">
    @include('points._create')
</x-turbo-stream>