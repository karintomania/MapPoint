<x-common.layout lead="Save Any Places" class="m-24">
    <div>
        <div class="flex flex-col gap-8">
            @include('points._create')
            <turbo-frame id="point-list" src="{{route('points.index')}}">
                <p>Loading...</p>
            </turbo-frame>
        </div>
    </div>
</x-common.layout>
