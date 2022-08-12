<x-common.layout>
    <div class="p-4">
        <h1 class="my-8 text-center text-2xl">Save any places</h1>
        <div class="flex flex-col gap-8">
            @include('points._create')
            <turbo-frame id="point-list" src="{{route('points.index')}}">
                <p>Loading...</p>
            </turbo-frame>
        </div>
    </div>
</x-common.layout>