<turbo-frame id="@domid($point)" class="w-full bg-gray-100">
    <x-points.map lat="{{$point->lat}}" lng="{{$point->lng}}" />
    <div class=" bg-gray-100">
        {{$point->note}}
        <form method="get" action="{{route('points.edit', ['point' => $point])}}" >
            <input type="submit" value="edit" />
        </form>
        <form method="delete" action="{{route('points.destroy', ['point' => $point])}}" >
            @csrf
            <input type="submit" value="delete" />
        </form>
    </div>
</turbo-frame>