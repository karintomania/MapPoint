<x-common.layout lead="Save Any Places" class="m-24">
    <div>
        <div class="flex flex-col gap-8">
            @include('points._create')
            <x-common.lead>Your Saved Places</x-common.lead>
            <turbo-frame id="point-list" src="{{route('points.index')}}"  class="grid grid-cols-3 gap-4">
                <p>Loading...</p>
            </turbo-frame>
        </div>
    </div>
</x-common.layout>
